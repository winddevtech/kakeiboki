"use strict";

class Budget extends Checker{
    constructor(){
        super();
        this.max_len_summary = 20;
    }

    setDate(date){
        this.date = date;
    }
    getDate(){
        return this.date;
    }

    setUseItemId(use_item_id){
        this.use_item_id = use_item_id;
    }
    getUseItemId(){
        return this.use_item_id;
    }

    setPrice(price){
        this.price = price;
    }
    getPrice(){
        return this.price;
    }

    setSummary(summary){
        this.summary = summary;
    }
    getSummary(){
        return this.summary;
    }

    chkDateInput(){
        if (this.date == '') {
            super.addErrMsg('家計発生日を入力して下さい。');
            return false;
        }
        return true;
    }
    chkDateFormat(){
        if (!Checker.chkDate(this.date)) {
            super.addErrMsg('家計発生日が不正な形式です。');
            return false;
        }
        return true;
    }

    chkUseItemId(){
        if (this.use_item_id == '') {
           super.addErrMsg('用途を選択してください。');
           return false;
        }
        return true;
    }

    chkPriceInput(){
        if (this.price == '') {
            super.addErrMsg('金額を入力して下さい。');
            return false;
        }
        return true;
    }
    chkPriceLen(){
        if (! Checker.chkPrice(this.price.length)) {
            super.addErrMsg('金額は1千万円までで入力して下さい。');
            return false;
        }
        return true;
    }
    chkSummary(){
        if (!Checker.chkStrLen(this.summary, this.max_len_summary)) {
            super.addErrMsg('摘要は20文字以内で入力して下さい。');
        }
    }
}

function budgetAction() {
    var wk_budget_obj = new Budget();
    wk_budget_obj.setDate(document.getElementById('creation_date').value);
    wk_budget_obj.setUseItemId(document.getElementById('use_item_id').value);
    wk_budget_obj.setPrice(document.getElementById('price').value);
    var summary = document.getElementById('summary').value;

    var result_flg = wk_budget_obj.chkDateInput();
    if (result_flg){
        wk_budget_obj.chkDateFormat();
    }

    wk_budget_obj.chkUseItemId();

    result_flg = wk_budget_obj.chkPriceInput();
    if (result_flg){
        wk_budget_obj.chkPriceLen();
    }

    if (summary != ''){
        wk_budget_obj.setSummary(summary);
        wk_budget_obj.chkSummary();
    }

    return wk_budget_obj.getChkRsult();
}
