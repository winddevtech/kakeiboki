"use strict";

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

var _get = function get(object, property, receiver) { if (object === null) object = Function.prototype; var desc = Object.getOwnPropertyDescriptor(object, property); if (desc === undefined) { var parent = Object.getPrototypeOf(object); if (parent === null) { return undefined; } else { return get(parent, property, receiver); } } else if ("value" in desc) { return desc.value; } else { var getter = desc.get; if (getter === undefined) { return undefined; } return getter.call(receiver); } };

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }

var User = function (_Checker) {
    _inherits(User, _Checker);

    function User() {
        _classCallCheck(this, User);

        var _this = _possibleConstructorReturn(this, (User.__proto__ || Object.getPrototypeOf(User)).call(this));

        _this.max_len_name = 20;
        _this.max_len_email = 50;
        return _this;
    }

    _createClass(User, [{
        key: 'setName',
        value: function setName(name) {
            this.name = name;
        }
    }, {
        key: 'getName',
        value: function getName() {
            return this.name;
        }
    }, {
        key: 'setEmail',
        value: function setEmail(email) {
            this.email = email;
        }
    }, {
        key: 'getEmail',
        value: function getEmail() {
            return this.email;
        }
    }, {
        key: 'setPass',
        value: function setPass(pass) {
            this.pass = pass;
        }
    }, {
        key: 'getPass',
        value: function getPass() {
            return this.pass;
        }
    }, {
        key: 'setConfPass',
        value: function setConfPass(pass_conf) {
            this.pass_conf = pass_conf;
        }
    }, {
        key: 'getConfPass',
        value: function getConfPass() {
            return this.pass_conf;
        }
    }, {
        key: 'setIcon',
        value: function setIcon(icon) {
            this.icon = icon;
        }
    }, {
        key: 'getIcon',
        value: function getIcon() {
            return this.icon;
        }
    }, {
        key: 'chkNameInput',
        value: function chkNameInput() {
            if (this.name == '') {
                _get(User.prototype.__proto__ || Object.getPrototypeOf(User.prototype), 'addErrMsg', this).call(this, 'ユーザー名を入力して下さい。');
                return false;
            }
            return true;
        }
    }, {
        key: 'chkNameLen',
        value: function chkNameLen() {
            if (!Checker.chkStrLen(this.name, this.max_len_name)) {
                _get(User.prototype.__proto__ || Object.getPrototypeOf(User.prototype), 'addErrMsg', this).call(this, 'ユーザー名は20文字以内で入力してくさい。');
                return false;
            }
            return true;
        }
    }, {
        key: 'chkEmailInput',
        value: function chkEmailInput() {
            if (this.email == '') {
                _get(User.prototype.__proto__ || Object.getPrototypeOf(User.prototype), 'addErrMsg', this).call(this, 'Emailを入力して下さい。');
                return false;
            }
            return true;
        }
    }, {
        key: 'chkEmailLen',
        value: function chkEmailLen() {
            if (!Checker.chkStrLen(this.email, this.max_len_email)) {
                _get(User.prototype.__proto__ || Object.getPrototypeOf(User.prototype), 'addErrMsg', this).call(this, 'Emailは50文字以内で入力してくさい。');
                return false;
            }
            return true;
        }
    }, {
        key: 'chkEmailFormat',
        value: function chkEmailFormat() {
            if (!Checker.chkEmailFormat(this.email)) {
                _get(User.prototype.__proto__ || Object.getPrototypeOf(User.prototype), 'addErrMsg', this).call(this, 'Emailが不正です。');
                return false;
            }
            return true;
        }
    }, {
        key: 'chkPassInput',
        value: function chkPassInput() {
            if (this.pass == '') {
                _get(User.prototype.__proto__ || Object.getPrototypeOf(User.prototype), 'addErrMsg', this).call(this, 'パスワードを入力して下さい。');
                return false;
            }
            return true;
        }
    }, {
        key: 'chkPassLen',
        value: function chkPassLen() {
            if (!Checker.chkPasswordLength(this.pass)) {
                _get(User.prototype.__proto__ || Object.getPrototypeOf(User.prototype), 'addErrMsg', this).call(this, 'パスワードの長さは8文字以上、30文字以内で入力して下さい。');
                return false;
            }
            return true;
        }
    }, {
        key: 'chkPassConfInput',
        value: function chkPassConfInput() {
            if (this.pass_conf == '') {
                _get(User.prototype.__proto__ || Object.getPrototypeOf(User.prototype), 'addErrMsg', this).call(this, '確認用パスワードを入力して下さい。');
                return false;
            }
            return true;
        }
    }, {
        key: 'chkPassConfLen',
        value: function chkPassConfLen() {
            if (!Checker.chkPasswordLength(this.pass_conf)) {
                _get(User.prototype.__proto__ || Object.getPrototypeOf(User.prototype), 'addErrMsg', this).call(this, '確認用パスワードの長さは8文字以上、30文字以内で入力して下さい。');
                return false;
            }
            return true;
        }
    }, {
        key: 'chkPassCompare',
        value: function chkPassCompare() {
            if (this.pass != this.pass_conf) {
                _get(User.prototype.__proto__ || Object.getPrototypeOf(User.prototype), 'addErrMsg', this).call(this, 'パスワードと確認用パスワードが一致しません。');
                return false;
            }
            return true;
        }
    }, {
        key: 'chkIcon',
        value: function chkIcon() {
            if (!Checker.chkPictureFormat(this.icon)) {
                _get(User.prototype.__proto__ || Object.getPrototypeOf(User.prototype), 'addErrMsg', this).call(this, '使用できる画像はjpg、jpeg、png、gif形式のみです。');
                return false;
            }
            return true;
        }
    }]);

    return User;
}(Checker);

function userAction() {
    var wk_user_obj = new User();
    wk_user_obj.setName(document.getElementById('user_name').value);
    wk_user_obj.setEmail(document.getElementById('email').value);
    wk_user_obj.setPass(document.getElementById('password').value);
    wk_user_obj.setConfPass(document.getElementById('password_conf').value);
    var icon = document.getElementById('js-upload_btn').value;
    var post_icon = document.getElementById('js-post_icon_img').value;

    var result_flg = wk_user_obj.chkNameInput();
    if (result_flg) {
        result_flg = wk_user_obj.chkNameLen();
    }

    result_flg = wk_user_obj.chkEmailInput();
    if (result_flg) {
        result_flg = wk_user_obj.chkEmailFormat();
    }
    if (result_flg) {
        result_flg = wk_user_obj.chkEmailLen();
    }

    var result_flg_pass = wk_user_obj.chkPassInput();
    if (result_flg_pass) {
        result_flg_pass = wk_user_obj.chkPassLen();
    }

    var result_flg_pass_conf = wk_user_obj.chkPassConfInput();
    if (result_flg_pass_conf) {
        result_flg_pass_conf = wk_user_obj.chkPassConfLen();
    }
    if (result_flg_pass && result_flg_pass_conf) {
        result_flg = wk_user_obj.chkPassCompare();
    }

    if (icon != '') {
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
    if (result_flg) {
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
    if (result_flg) {
        wk_user_obj.chkEmailFormat();
    }
    return wk_user_obj.getChkRsult();
}
