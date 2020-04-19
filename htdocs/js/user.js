"use strict";

class User extends Checker{
    constructor(){
        super();
        this.max_len_name = 20;
        this.max_len_email = 50;
    }

    setName(name){
        this.name = name;
    }
    getName(){
        return this.name;
    }

    setEmail(email){
        this.email = email;
    }
    getEmail(){
        return this.email;
    }

    setPass(pass){
        this.pass = pass;
    }
    getPass(){
        return this.pass;
    }

    setConfPass(pass_conf){
        this.pass_conf = pass_conf;
    }
    getConfPass(){
        return this.pass_conf;
    }

    setIcon(icon){
        this.icon = icon;
    }
    getIcon(){
        return this.icon;
    }

    chkNameInput(){
        if (this.name == '') {
            super.addErrMsg('ユーザー名を入力して下さい。');
            return false;
        }
        return true;
    }
    chkNameLen(){
        if (!Checker.chkStrLen(this.name , this.max_len_name)) {
            super.addErrMsg('ユーザー名は20文字以内で入力してくさい。');
            return false;
        }
        return true;
    }

    chkEmailInput(){
        if (this.email == '') {
            super.addErrMsg('Emailを入力して下さい。');
            return false;
        }
        return true;
    }
    chkEmailLen(){
        if (!Checker.chkStrLen(this.email, this.max_len_email)) {
            super.addErrMsg('Emailは50文字以内で入力してくさい。');
            return false;
        }
        return true;
    }
    chkEmailFormat(){
        if (!Checker.chkEmailFormat(this.email)) {
            super.addErrMsg('Emailが不正です。');
            return false;
        }
        return true;
    }

    chkPassInput(){
        if (this.pass == '') {
            super.addErrMsg('パスワードを入力して下さい。');
            return false;
        }
        return true;
    }

    chkPassLen(){
        if (!Checker.chkPasswordLength(this.pass)) {
            super.addErrMsg('パスワードの長さは8文字以上、30文字以内で入力して下さい。');
            return false;
        }
        return true;
    }

    chkPassConfInput(){
        if (this.pass_conf == '') {
            super.addErrMsg('確認用パスワードを入力して下さい。');
            return false;
        }
        return true;
    }
    chkPassConfLen(){
        if (!Checker.chkPasswordLength(this.pass_conf)) {
            super.addErrMsg('確認用パスワードの長さは8文字以上、30文字以内で入力して下さい。');
            return false;
        }
        return true;
    }
    chkPassCompare(){
        if (this.pass != this.pass_conf) {
            super.addErrMsg('パスワードと確認用パスワードが一致しません。');
            return false;
        }
        return true;
    }

    chkIcon(){
        if (!Checker.chkPictureFormat(this.icon)) {
            super.addErrMsg('使用できる画像はjpg、jpeg、png、gif形式のみです。');
            return false;
        }
        return true;
    }
}

function userAction() {
    var wk_user_obj = new User();
    wk_user_obj.setName(document.getElementById('user_name').value);
    wk_user_obj.setEmail(document.getElementById('email').value);
    wk_user_obj.setPass(document.getElementById('password').value);
    wk_user_obj.setConfPass(document.getElementById('password_conf').value);
    var icon = document.getElementById('js-upload_btn').value;
    var post_icon = document.getElementById('js-post_icon_img').value;

    var result_flg = wk_user_obj.chkNameInput();
    if (result_flg){
        result_flg = wk_user_obj.chkNameLen();
    }

    result_flg = wk_user_obj.chkEmailInput();
    if (result_flg){
        result_flg = wk_user_obj.chkEmailFormat();
    }
    if (result_flg){
        result_flg = wk_user_obj.chkEmailLen();
    }

    var result_flg_pass = wk_user_obj.chkPassInput();
    if (result_flg_pass){
        result_flg_pass = wk_user_obj.chkPassLen();
    }

    var result_flg_pass_conf = wk_user_obj.chkPassConfInput();
    if (result_flg_pass_conf){
        result_flg_pass_conf = wk_user_obj.chkPassConfLen();
    }
    if (result_flg_pass && result_flg_pass_conf){
        result_flg = wk_user_obj.chkPassCompare();
    }

    if (icon != ''){
        post_icon = post_icon.split('/');
        post_icon = post_icon[1].split(';');
        wk_user_obj.setIcon(post_icon[0]);
        wk_user_obj.chkIcon();
    }

    return wk_user_obj.getChkRsult();
}

function loginAction() {
    var wk_user_obj = new User();
    var result_flg = null;
    wk_user_obj.setEmail(document.getElementById('email').value);
    wk_user_obj.setPass(document.getElementById('password').value);
    result_flg = wk_user_obj.chkEmailInput();
    if (result_flg){
        wk_user_obj.chkEmailFormat();
    }
    wk_user_obj.chkPassInput();
    return wk_user_obj.getChkRsult();
}

function authAction() {
    var wk_user_obj = new User();
    var result_flg = null;
    wk_user_obj.setEmail(document.getElementById('email').value);
    result_flg = wk_user_obj.chkEmailInput();
    if (result_flg){
        wk_user_obj.chkEmailFormat();
    }
    return wk_user_obj.getChkRsult();
}
