<?php
require_once 'com/MainController.php';
require_once dirname(__FILE__) . '/../../framework/Util.php';
require_once dirname(__FILE__) . '/../../framework/StrProc.php';
require_once dirname(__FILE__) . '/../../app/model/detail/Contact.php';
require_once dirname(__FILE__) . '/../../app/model/com/Form.php';
//require_once dirname(__FILE__) . '/../../app/model/TimelineProc.php';
require_once dirname(__FILE__) . '/../model/TimelineProc.php';
class TimelineController extends MainController  {
    public function __construct() {
        parent::__construct();
    }

    public function preAction() {
        if (! $this->session->has('login_admin')) {
            Redirect::locationTop();
        }
        parent::preAction();
    }
    /**タイムライン画面
     */
    public function indexAction() {
        // GETデータを取得
        $get_item = $this->request->getQuery();
        $contact_id = Request::trimReqSpaceHerf($get_item['contact_id']);

        // contact_idは数値以外か
        if (! is_numeric($contact_id)) {
            Redirect::err403();
        }

        //データ出力
        $this->view->assign('contact_id', $contact_id);
    }
    /**
     * タイムライン出力
     */
    public function displayAction() {
        $this->session->setSession('sstoken', Security::generateToken());

        $get_item = $this->request->getQuery();
        $contact_id = Request::trimReqSpaceHerf($get_item['contact_id']);

        //contact_idは数値以外か
        if (! is_numeric($contact_id)) {
            echo json_encode(array('status' => 'error'));
            exit();
        }

        $timeline_base = TimelineProc::getTimelineBaseForReply($contact_id);

        //タイムラインの基本情報は未取得か
        if (! $timeline_base){
            echo json_encode(array('status' => 'error'));
            exit();
        }

        $category_name = TimelineProc::categoryWhiteList($timeline_base['category_id']);
        $timeline_list = TimelineProc::getTimeline($contact_id);

        //アイコンが設定されていなければ初期アイコンを表示する
        $icon_img = TimelineProc::getDisplayIcon($timeline_base['icon']);

        // json出力
        $result_data = array(
                'status' => 'success',
                'timeline_list' => $timeline_list,
                'category_name' => $category_name,
                'user_icon' => $icon_img,
                'user_name' => $timeline_base['name'],
                'token' => $this->session->getSession('sstoken')
        );

        echo json_encode($result_data);
        exit();
    }


    /**
     * タイムライン追加
     */
    public function addAction() {
        if (! Security::checkToken()) {
            $result_data = array(
                    'status' => 'error',
                    'token' => $this->session->getSession('sstoken')
            );
            echo json_encode($result_data);
            exit();
        }

        $post_item = $this->request->getPost();
        $contact_id = (isset($post_item['contact_id'])) ? Request::trimReqSpaceHerf($post_item['contact_id']) : '';
        $context = (isset($post_item['context'])) ? Request::trimReqSpaceHerf($post_item['context']) : '';
        $sender = 2; //タイムライン送信フラグ

        $this->session->setSession('sstoken', Security::generateToken());


        //詳細オブジェクトを作成
        $contact_detail_obj = new Contact();
        $contact_detail_obj->setId($contact_id);
        $contact_detail_obj->setContext($context);

        //フォームオブジェクトを作成
        $form_obj = new Form($contact_detail_obj);

        $form_obj = TimelineProc::valid($form_obj);
        $err_msg = $form_obj->getErrMsg();

        // エラーはあるか
        if (! empty($err_msg)) {
            $result_data = array(
                    'status' => 'error',
                    'token' => $this->session->getSession('sstoken')
            );
            echo json_encode($result_data);
            exit();
        }

        //タイムラインを送信する
        $isExecute = TimelineProc::addTimeline($contact_id, $sender, $context);
        // 送信エラーか
        if (! $isExecute) {
            $result_data = array(
                    'status' => 'error',
                    'token' => $this->session->getSession('sstoken')
            );
            echo json_encode($result_data);
            exit();
        }

        // json出力
        $result_data = array(
                'status' => 'success',
                'sender' => $sender,
                'token' => $this->session->getSession('sstoken')
        );

        echo json_encode($result_data);
        exit();
    }
}