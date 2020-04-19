"use strict";

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

var _get = function get(object, property, receiver) { if (object === null) object = Function.prototype; var desc = Object.getOwnPropertyDescriptor(object, property); if (desc === undefined) { var parent = Object.getPrototypeOf(object); if (parent === null) { return undefined; } else { return get(parent, property, receiver); } } else if ("value" in desc) { return desc.value; } else { var getter = desc.get; if (getter === undefined) { return undefined; } return getter.call(receiver); } };

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }

var Contact = function (_Checker) {
    _inherits(Contact, _Checker);

    function Contact() {
        _classCallCheck(this, Contact);

        var _this = _possibleConstructorReturn(this, (Contact.__proto__ || Object.getPrototypeOf(Contact)).call(this));

        _this.max_len_context = 1000;
        return _this;
    }

    _createClass(Contact, [{
        key: 'setCategory',
        value: function setCategory(category) {
            this.category = category;
        }
    }, {
        key: 'getCategory',
        value: function getCategory() {
            return this.category;
        }
    }, {
        key: 'setContext',
        value: function setContext(context) {
            this.context = context;
        }
    }, {
        key: 'getContext',
        value: function getContext() {
            return this.context;
        }
    }, {
        key: 'chkCategory',
        value: function chkCategory() {
            if (this.category == '') {
                _get(Contact.prototype.__proto__ || Object.getPrototypeOf(Contact.prototype), 'addErrMsg', this).call(this, 'お問い合わせカテゴリを選択してください。');
                return false;
            }
            return true;
        }
    }, {
        key: 'chkContextInput',
        value: function chkContextInput() {
            if (this.context == '') {
                _get(Contact.prototype.__proto__ || Object.getPrototypeOf(Contact.prototype), 'addErrMsg', this).call(this, 'お問い合わせ内容を入力して下さい。');
                return false;
            }
            return true;
        }
    }, {
        key: 'chkContextLen',
        value: function chkContextLen() {
            if (!Checker.chkStrLen(this.context, this.max_len_context)) {
                _get(Contact.prototype.__proto__ || Object.getPrototypeOf(Contact.prototype), 'addErrMsg', this).call(this, 'お問い合わせ内容は1000文字以内で入力して下さい。');
                return false;
            }
            return true;
        }
    }]);

    return Contact;
}(Checker);

function contactAction() {
    var wk_contact_obj = new Contact();
    wk_contact_obj.setCategory(document.getElementById('js-category_id').value);
    wk_contact_obj.setContext(document.getElementById('js-context').value);

    wk_contact_obj.chkCategory();

    var result_flg = wk_contact_obj.chkContextInput();
    if (result_flg) {
        result_flg = wk_contact_obj.chkContextLen();
    }

    return wk_contact_obj.getChkRsult();
}
