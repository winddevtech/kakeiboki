<?php
require_once dirname(__FILE__) . '/../com/MainDBModel.php';
//お問い合わせDBクラス
class ContactDB extends MainDBModel {
    // DBに新規登録
    public static function insertDB($user_id, $category_id, $context) {
        $isExecute = false;
        try {
            parent::query('set autocommit = 0;');
            parent::query('start transaction;');

            $sql = 'insert into contact (user_id, category_id, rs_id, created_at) values (:user_id, :category_id, 1,now())';
            $query_arg = array (
                    ':user_id' => array ($user_id, PDO::PARAM_INT),
                    ':category_id' => array ($category_id, PDO::PARAM_INT)
            );
            $isExecute = parent::insert($sql, $query_arg);

            $sql = 'select @contact_id := id from contact where user_id = :user_id order by created_at desc limit 1';
            $query_arg = array (
                    ':user_id' => array ($user_id, PDO::PARAM_INT)
            );
            $isExecute = parent::insert($sql, $query_arg);

            $sql = 'insert into timeline (contact_id, sender, context, created_at) values (@contact_id, 1, :context, now())';
            $query_arg = array (
                    ':context' => array ($context, PDO::PARAM_STR)
            );
            $isExecute = parent::insert($sql, $query_arg);

            parent::query('commit;');
        } catch (PDOException $e){
            parent::query('rollback;');
            parent::outputErrlog(basename(__FILE__), __LINE__, $e->getMessage());
        } catch (Exception $e){
            parent::outputErrlog(basename(__FILE__), __LINE__, $e->getMessage());
        }

        return $isExecute;
    }

    //ユーザーIDでの削除処理
    public static function deleteDB($user_id){
        $isExecute = false;

        try {
            parent::query('set autocommit = 0;');
            parent::query('start transaction;');

            $query_arg = array (
                    ':user_id' => array ($user_id, PDO::PARAM_INT)
            );

            $sql = 'delete from timeline where contact_id in (select id as contact_id from contact where user_id = :user_id)';
            $isExecute = parent::delete($sql, $query_arg);

            $sql = 'delete from contact where user_id = :user_id';
            $isExecute = parent::delete($sql, $query_arg);

            parent::query('commit;');
            parent::query('set autocommit = 1;');
        } catch (PDOException $e){
            parent::query('rollback;');
            parent::outputErrlog(basename(__FILE__), __LINE__, 'お問い合わせ情報削除エラー[sql='.$sql.']' . $e->getMessage());
        } catch (Exception $e){
            parent::outputErrlog(basename(__FILE__), __LINE__, $e->getMessage());
        }

        return $isExecute;
    }


    //タイムラインの基本情報を取得する
    public static function getTimelineBase($contact_id){
        $sql = 'select category_id from contact where id = :contact_id limit 1';
        $query_arg = array (
                ':contact_id' => array ($contact_id, PDO::PARAM_INT)
        );
        $searchData = parent::query($sql, $query_arg);

        if (! $searchData) {
            parent::outputErrlog(basename(__FILE__), __LINE__, 'タイムライン基本情報取得エラー[sql='.$sql.']');
            return false;
        }

        return $searchData;
    }

    //タイムラインを取得する
    public static function getTimeline($contact_id){
        $sql = 'select id, sender, context, created_at from timeline where contact_id = :contact_id';
        $query_arg = array (
                ':contact_id' => array ($contact_id, PDO::PARAM_INT)
        );

        $search_rows = parent::queryAll($sql, $query_arg);

        if (! $search_rows) {
            parent::outputErrlog(basename(__FILE__), __LINE__, 'タイムライン取得エラー[sql='.$sql.']');
            return false;
        }

        return $search_rows;
    }

    // 該当ユーザーのお問い合わせ件数を取得する
    public static function getCount($user_id) {
        $sql = 'select count(*) from contact where user_id = :user_id';
        $query_arg = array (
                ':user_id' => array ($user_id, PDO::PARAM_INT)
        );
        $search_count = parent::queryCount($sql, $query_arg);

        return $search_count;
    }



    // お問い合わせ一覧を取得する
    public static function getList($user_id, $sort_safe, $order_safe, $offset, $count) {
        if ($sort_safe != 'context'){
            $sort_safe = 'c.' . $sort_safe;
        }

        // 指定位置から10件取得する
        $sql = 'select c.id, c.category_id, context, c.created_at, c.rs_id';
        $sql = $sql . ' from contact c left join timeline t on c.id = t.contact_id where user_id = :user_id';
        $sql = $sql . ' group by t.contact_id order by '. $sort_safe . ' ' . $order_safe . ' limit :offset, :count';
        $query_arg = array (
                ':user_id' => array ($user_id, PDO::PARAM_INT),
                ':offset' => array ($offset, PDO::PARAM_INT),
                ':count' => array ($count, PDO::PARAM_INT)
        );
        $search_datas = parent::queryAll($sql, $query_arg);

        return $search_datas;
    }




    // 管理者用返信リスト
    public static function getReplyListByKeyword($keyword, $sort_safe, $order_safe, $offset) {
        if ($sort_safe != 'name'){
            $sort_safe = 'c.' . $sort_safe;
        }

        $sql = 'select c.id, c.created_at, c.updated_at, name, rs_id from contact c left join user u ';
        $sql = $sql . 'on c.user_id = u.id where name like :query ';
        $sql = $sql . 'order by '. $sort_safe . ' ' . $order_safe . ' limit :offset, 10';
        $query_arg = array (
                ':query' => array ('%' . $keyword . '%', PDO::PARAM_STR),
                ':offset' => array ($offset, PDO::PARAM_INT),
        );

        $searchDatas = parent::queryAll($sql,$query_arg);

        if (! $searchDatas) {
            parent::outputErrlog(basename(__FILE__), __LINE__, '管理者用返信リスト取得エラー[sql='.$sql.']');
            return false;
        }

        return $searchDatas;
    }



    // 管理者用返信リスト数
    public static function getReplyListCountByKeyword($keyword){
        $sql = 'select count(*) from contact c left join user u ';
        $sql = $sql . 'on c.user_id = u.id where name like :query';
        $query_arg = array (
                ':query' => array ('%' . $keyword . '%', PDO::PARAM_STR)
        );

        $searchCount = parent::queryCount($sql, $query_arg);

        if (! $searchCount) {
            parent::outputErrlog(basename(__FILE__), __LINE__, '管理者用返信リスト数取得エラー[sql='.$sql.']');
            return false;
        }

        return $searchCount;
    }

    //タイムラインの基本情報を取得する
    public static function getTimelineBaseForReply($contact_id){
        $sql = 'select category_id, name, icon from contact c join user u on c.user_id = u.id and c.id = :contact_id limit 1';
        $query_arg = array (
                ':contact_id' => array ($contact_id, PDO::PARAM_INT)
        );

        $searchData = parent::query($sql, $query_arg);
        if (! $searchData) {
            parent::outputErrlog(basename(__FILE__), __LINE__, 'タイムライン基本情報取得エラー[sql='.$sql.']');
            return false;
        }

        return $searchData;
    }

    //タイムラインを追加する
    public static function addTimeline($contact_id, $sender, $context){
        $isExecute = false;
        try {
            parent::query('set autocommit = 0;');
            parent::query('start transaction;');

            $sql = 'insert into timeline (contact_id, sender, context, created_at) values (:contact_id, :sender, :context, now())';
            $query_arg = array (
                    ':contact_id' => array ($contact_id, PDO::PARAM_INT),
                    ':sender' => array ($sender, PDO::PARAM_INT),
                    ':context' => array ($context, PDO::PARAM_STR)
            );
            $isExecute = parent::insert($sql, $query_arg);

            $sql = 'update contact set rs_id = :rs_id, updated_at = now() where id = :contact_id';
            $query_arg = array (
                    ':contact_id' => array ($contact_id, PDO::PARAM_INT),
                    ':rs_id' => array ($sender, PDO::PARAM_INT)
            );
            $isExecute = parent::update($sql, $query_arg);

            parent::query('commit;');
        } catch (PDOException $e){
            parent::query('rollback;');
            parent::outputErrlog(basename(__FILE__), __LINE__, 'タイムライン登録エラー[sql='.$sql.']');
        } catch (Exception $e){
            parent::outputErrlog(basename(__FILE__), __LINE__, $e->getMessage());
        }

        return $isExecute;
    }



}