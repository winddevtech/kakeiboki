"use strict";

class Checker {
    constructor (){
        this.err_msg = '';
    }

    static chkStrLen (str, max_len){
        if (str.length > max_len) {
            return false;
        }
        return true;
    }

    static chkEmailFormat (str) {
        var email_format = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
        if (!str.match(email_format)) {
            return false;
        }
        return true;
    }

    static chkPasswordLength (str) {
        var min_len_pass = 8;
        var max_len_pass = 30;
        if (str.length < min_len_pass || max_len_pass < str.length) {
            return false;
        }
        return true;
    }

    static chkDate(date) {
        var date_format = /([1-9][0-9]{3})\/(0[1-9]{1}|1[0-2]{1})\/(0[1-9]{1}|[1-2]{1}[0-9]{1}|3[0-1]{1})/;
        if (!date.match(date_format)) {
            return false;
        }
        return true;
    }

    static chkPrice(price_len) {
        var max_len_price = 8 //1千万円の桁数;
        if (price_len > max_len_price) {
            return false;
        }
        return true;
    }

    static chkFileFormat(str) {
        var file_format = ".+\.csv";
        if (!str.match(file_format)) {
            return false;
        }
        return true;
    }

    static chkPictureFormat(str) {
        var white_list = Array('jpg', 'jpeg', 'png', 'gif');
        if (white_list.indexOf(str) == -1){
            return false;
        }
        return true;
    }

    addErrMsg(err_msg){
        if (this.err_msg == ''){
            this.err_msg += err_msg;
        } else {
            this.err_msg += '\n' + err_msg;
        }
    }

    getChkRsult(){
        if (this.err_msg != '') {
            alert(this.err_msg);
            return false;
        }
        return true;
    }
}



// 確認ボタン押下イベント定義
document.getElementById('js-submit').addEventListener('click', dispatcher, false);

function dispatcher(event) {
    var url_array = window.location.href.split('/');
    var current = url_array[url_array.length - 2];
    var result = null;

    if (current == 'src') {
        current = 'index'
    }
    switch (current) {
        case '':
        case 'index':
            result = loginAction();
            break;
        case 'signup':
        case 'edit':
            result = userAction();
            break;
        /*case 'import':
            result = importAction();
            break;*/
        case 'auth':
            result = authAction();
            break;
        case 'contact':
            result = contactAction();
            break;
        case 'budget':
            result = budgetAction();
            break;
        default:
            break;
    }

    if(result == false){
        event.preventDefault();
    }
}
