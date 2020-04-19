"use strict";

// 家計簿情報入力チェック
function budgetAction() {
    var date = document.getElementById('j_date').value;
    var use_item = document.getElementById('use_item').value;
    var price = document.getElementById('j_price').value;
    var summary = document.getElementById('j_summary').value;
    var errMsg = '';
    var maxSummaryLen = 20;

    var chkObj = new Checker();

    if (date == '') {
        errMsg = '家計発生日を入力して下さい。';
    } else if (!chkObj.chkDate()) {
        errMsg = '家計発生日が不正な形式です。';
    } else if (use_item == '') {
        errMsg = '用途を選択してください。';
    } else if (price == '') {
        errMsg = '金額を入力して下さい。';
    } else if (!chkObj.chkPrice(price) == '') {
        errMsg = '金額は10桁以内で入力して下さい。';
    } else if (!chkObj.chkStrLen(summary, maxSummaryLen)) {
        errMsg = '摘要は20文字以内で入力して下さい。';
    }

    if (errMsg != '') {
        alert(errMsg);
        return false;
    }
    return true;
}
