"use strict";
/*入力チェック*/

function Checker() {

}

Checker.prototype.chkStrLen = function(chkStr, maxLen) {
    if (chkStr.length > maxLen) {
        return false;
    }

    return true;
};

Checker.prototype.chkEmailFormat = function(chkStr) {
    //var emailFormat = "^.+@.+\..+$";
    var emailFormat = "^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$";
    if (!chkStr.match(emailFormat)) {
        return false;
    }

    return true;
};

Checker.prototype.chkPasswordLength = function(chkStr) {
    var passwordMin = 8;
    var passwordMax = 30;

    if (chkStr < passwordMin && passwordMax < chkStr) {
        return false;
    }
    return true;
};

Checker.prototype.chkDate = function(chkdate) {
    var dateFormat = '^[2][0-9]{3}/[0-9][2]/[0-9][2]$';
    if (!chkdate.match(dateFormat)) {
        return false;
    }

    return true;
};

Checker.prototype.chkPrice = function(priceLen) {
    var maxPriceLen = 10;
    if (priceLen > maxPriceLen) {
        return false;
    }

    return true;
};

Checker.prototype.chkFileFormat = function(chkStr) {
    var fileFormat = '/^.+.csv$/';
    if (!chkStr.match(fileFormat)) {
        return false;
    }

    return true;
};

// 確認ボタン押下イベント定義
document.getElementById('js-submit').addEventListener('click', dispatcher, false);

function dispatcher(event) {
    var url_array = window.location.href.split('/');
    var current = url_array[url_array.length - 2]
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
        chkPreventDefault(event);
    }
}

// クリックイベントをキャンセルする
function chkPreventDefault(event) {
    if (event.preventDefault) {
        event.preventDefault();
    } else {
        event.returnValue = false;
    }
}
