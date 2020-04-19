"use strict";
class Contact extends Checker{
    constructor(){
        super();
        this.max_len_context = 1000;
    }

    setCategory(category){
        this.category = category;
    }
    getCategory(){
        return this.category;
    }

    setContext(context){
        this.context = context;
    }
    getContext(){
        return this.context;
    }

    chkCategory(){
        if (this.category == '') {
            super.addErrMsg('お問い合わせカテゴリを選択してください。');
            return false;
        }
        return true;
    }

    chkContextInput(){
        if (this.context == '') {
            super.addErrMsg('お問い合わせ内容を入力して下さい。');
            return false;
        }
        return true;
    }
    chkContextLen(){
        if (!Checker.chkStrLen(this.context, this.max_len_context)) {
            super.addErrMsg('お問い合わせ内容は1000文字以内で入力して下さい。');
            return false;
        }
        return true;
    }
}

function contactAction() {
    var wk_contact_obj = new Contact();
    wk_contact_obj.setCategory(document.getElementById('js-category_id').value);
    wk_contact_obj.setContext(document.getElementById('js-context').value);

    wk_contact_obj.chkCategory();

    var result_flg = wk_contact_obj.chkContextInput();
    if (result_flg){
        result_flg = wk_contact_obj.chkContextLen();
    }

    return wk_contact_obj.getChkRsult();
}
