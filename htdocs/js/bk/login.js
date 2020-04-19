"use strict";

/*ログインチェック*/
function loginAction() {
    var email = document.getElementById('email').value;
    var password = document.getElementById('password').value;
    var errMsg = '';

    var chkObj = new Checker();
    if (email == '') {
        errMsg = 'Emailを入力して下さい。';
    } else if (!chkObj.chkEmailFormat(email)) {
        errMsg = 'Emailが不正です。';
    } else if (password == '') {
        errMsg = 'パスワードを入力して下さい。';
    }

    if (errMsg != '') {
        alert(errMsg);
        return false;
    }
    return true;
}
