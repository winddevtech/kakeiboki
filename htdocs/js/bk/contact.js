"use strict";


// お問い合わせ用
function contactAction() {
    var category = document.getElementById('category_id').value;
    var context = document.getElementById('context').value;
    var errMsg = '';
    var contextMaxLength = 1000;

    var chkObj = new Checker();
    if (category == '') {
        errMsg = 'お問い合わせカテゴリを選択してください。';
    } else if (context == '') {
        errMsg = 'お問い合わせ内容を入力して下さい。';
    } else if (!chkObj.chkStrLen(context, contextMaxLength)) {
        errMsg = 'お問い合わせ内容は1000文字以内で入力して下さい。';
    }

    if (errMsg != '') {
        alert(errMsg);
        return false;
    }
    return true;
}
