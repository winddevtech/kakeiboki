"use strict";

// 仮パスワード発行申請用
function authAction() {
    var email = document.getElementById('email').value;
    var errMsg = '';

    var chkObj = new Checker();
    if (email == '') {
        errMsg = 'Emailを入力して下さい。';
    } else if (!chkObj.chkEmailFormat()) {
        errMsg = 'Emailが不正です。';
    }

    if (errMsg != '') {
        alert(errMsg);
        return false;
    }
    return true;
}
