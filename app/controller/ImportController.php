<?php
require_once 'com/MainController.php';
require_once dirname(__FILE__) . '/../../framework/StrProc.php';
require_once dirname(__FILE__) . '/../model/ImportProc.php';
require_once dirname(__FILE__) . '/../model/detail/ImportData.php';
require_once dirname(__FILE__) . '/../model/com/Form.php';
class ImportController extends MainController {
    public function __construct() {
        parent::__construct();
    }

    public function preAction(){
        if (! $this->session->has('login_user_obj')) {
            Redirect::locationTop();
        }
        parent::preAction();
    }


    /**
     * 家計簿情報インポート設定画面
     */
    public function indexAction() {
        $this->session->setSession('sstoken', Security::generateToken());

        //データ出力
        $this->view->assign('token', $this->session->getSession('sstoken'));
    }

    /**
     * 家計簿情報インポート設定入力チェック
     */
    public function confirmAction() {
        if (! Security::checkToken()) {
            Redirect::err403();
        }

        // インポートファイルを取得
        $import_file = $this->request->getFiles('import_file');
        $header_flg = Request::trimReqSpaceHerf($this->request->getPost('headerflg'));

        $err_msg = array ();

        //詳細オブジェクトを作成
        $import_detail_obj = new ImportData();
        $import_detail_obj->setFile($import_file);
        $header_flg = ($header_flg == 1) ? true : false;
        $import_detail_obj->setHeaderFlg($header_flg);

        //フォームオブジェクトを作成
        $form_obj = new Form($import_detail_obj);

        // インポートファイル入力チェック
        $form_obj = ImportProc::valid($form_obj);
        $err_msg = $form_obj->getErrMsg();

        $this->session->setSession('sstoken', Security::generateToken());


        // エラーメッセージはあるか
        if (is_null($err_msg)) {
            $result_data = array(
                    'status' => 'err',
                    'err_msg' => $err_msg['import_file'],
                    'token' => $this->session->getSession('sstoken')
            );
            echo json_encode($result_data);
            exit();
        }

        // インポートデータチェック処理
        $import_detail_obj = ImportProc::validData($import_detail_obj);

        // セッションに正常なデータを格納した配列と正常なデータ数を設定する
        $this->session->setSession('setting_import_obj', serialize($form_obj));

        $result_data = array(
                'status' => 'success',
                'ok_count' => $import_detail_obj->getOkDataCount(),
                'ng_count' => $import_detail_obj->getNgDataCount(),
                'token' => $this->session->getSession('sstoken')
        );
        echo json_encode($result_data);
        exit();
    }

    /**
     * インポートファイルDB登録処理
     */
    public function completeAction() {
        if (! Security::checkToken()) {
            Redirect::err403();
        }

        //インポートオブジェクトはなしか
        if (! $this->session->has('setting_import_obj')) {
            echo json_encode(
                    array(
                            'status' => 'err',
                            'token' => $this->session->getSession('sstoken'))
                    );
            exit();
        }

        // 仕訳データを一括登録する
        $form_obj = unserialize($this->session->getSession('setting_import_obj'));
        $import_detail_obj = $form_obj->getDetailObj();
        $isExecute = ImportProc::insertAll($import_detail_obj, $this->login_user_obj->getId());

        // DB登録は失敗か
        if (! $isExecute) {
            echo json_encode(array('status' => 'error'));
            exit();
        }

        ImportProc::transaction($this->login_user_obj->getId(), '一括インポート');

        // ユーザー情報が格納されているセッション変数を破棄
        $this->session->remove('setting_import_obj');

        $this->session->setSession('sstoken', Security::generateToken());

        echo json_encode(
                array(
                        'status' => 'success',
                        'ok_count' => $import_detail_obj->getOkDataCount(),
                        'token' => $this->session->getSession('sstoken'))
                );
        exit();
    }
}