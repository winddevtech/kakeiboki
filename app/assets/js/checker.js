"use strict";

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

var Checker = function () {
    function Checker() {
        _classCallCheck(this, Checker);

        this.err_msg = '';
    }

    _createClass(Checker, [{
        key: "addErrMsg",
        value: function addErrMsg(err_msg) {
            if (this.err_msg == '') {
                this.err_msg += err_msg;
            } else {
                this.err_msg += '\n' + err_msg;
            }
        }
    }, {
        key: "getChkRsult",
        value: function getChkRsult() {
            if (this.err_msg != '') {
                alert(this.err_msg);
                return false;
            }
            return true;
        }
    }], [{
        key: "chkStrLen",
        value: function chkStrLen(str, max_len) {
            if (str.length > max_len) {
                return false;
            }
            return true;
        }
    }, {
        key: "chkEmailFormat",
        value: function chkEmailFormat(str) {
            var email_format = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
            if (!str.match(email_format)) {
                return false;
            }
            return true;
        }
    }, {
        key: "chkPasswordLength",
        value: function chkPasswordLength(str) {
            var min_len_pass = 8;
            var max_len_pass = 30;
            if (str.length < min_len_pass || max_len_pass < str.length) {
                return false;
            }
            return true;
        }
    }, {
        key: "chkDate",
        value: function chkDate(date) {
            var date_format = /([1-9][0-9]{3})\/(0[1-9]{1}|1[0-2]{1})\/(0[1-9]{1}|[1-2]{1}[0-9]{1}|3[0-1]{1})/;
            if (!date.match(date_format)) {
                return false;
            }
            return true;
        }
    }, {
        key: "chkPrice",
        value: function chkPrice(price_len) {
            var max_len_price = 8;
            if (price_len > max_len_price) {
                return false;
            }
            return true;
        }
    }, {
        key: "chkFileFormat",
        value: function chkFileFormat(str) {
            var file_format = ".+\.csv";
            if (!str.match(file_format)) {
                return false;
            }
            return true;
        }
    }, {
        key: "chkPictureFormat",
        value: function chkPictureFormat(str) {
            var white_list = Array('jpg', 'jpeg', 'png', 'gif');
            if (white_list.indexOf(str) == -1) {
                return false;
            }
            return true;
        }
    }]);

    return Checker;
}();

// 確認ボタン押下イベント定義


document.getElementById('js-submit').addEventListener('click', dispatcher, false);

function dispatcher(event) {
    var url_array = window.location.href.split('/');
    var current = url_array[url_array.length - 2];
    var result = null;

    if (current == 'app') {
        current = 'index';
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

    if (result == false) {
        event.preventDefault();
    }
}
