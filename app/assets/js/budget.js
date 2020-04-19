"use strict";

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

var _get = function get(object, property, receiver) { if (object === null) object = Function.prototype; var desc = Object.getOwnPropertyDescriptor(object, property); if (desc === undefined) { var parent = Object.getPrototypeOf(object); if (parent === null) { return undefined; } else { return get(parent, property, receiver); } } else if ("value" in desc) { return desc.value; } else { var getter = desc.get; if (getter === undefined) { return undefined; } return getter.call(receiver); } };

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }

var Budget = function (_Checker) {
    _inherits(Budget, _Checker);

    function Budget() {
        _classCallCheck(this, Budget);

        var _this = _possibleConstructorReturn(this, (Budget.__proto__ || Object.getPrototypeOf(Budget)).call(this));

        _this.max_len_summary = 20;
        return _this;
    }

    _createClass(Budget, [{
        key: 'setDate',
        value: function setDate(date) {
            this.date = date;
        }
    }, {
        key: 'getDate',
        value: function getDate() {
            return this.date;
        }
    }, {
        key: 'setUseItemId',
        value: function setUseItemId(use_item_id) {
            this.use_item_id = use_item_id;
        }
    }, {
        key: 'getUseItemId',
        value: function getUseItemId() {
            return this.use_item_id;
        }
    }, {
        key: 'setPrice',
        value: function setPrice(price) {
            this.price = price;
        }
    }, {
        key: 'getPrice',
        value: function getPrice() {
            return this.price;
        }
    }, {
        key: 'setSummary',
        value: function setSummary(summary) {
            this.summary = summary;
        }
    }, {
        key: 'getSummary',
        value: function getSummary() {
            return this.summary;
        }
    }, {
        key: 'chkDateInput',
        value: function chkDateInput() {
            if (this.date == '') {
                _get(Budget.prototype.__proto__ || Object.getPrototypeOf(Budget.prototype), 'addErrMsg', this).call(this, '家計発生日を入力して下さい。');
                return false;
            }
            return true;
        }
    }, {
        key: 'chkDateFormat',
        value: function chkDateFormat() {
            if (!Checker.chkDate(this.date)) {
                _get(Budget.prototype.__proto__ || Object.getPrototypeOf(Budget.prototype), 'addErrMsg', this).call(this, '家計発生日が不正な形式です。');
                return false;
            }
            return true;
        }
    }, {
        key: 'chkUseItemId',
        value: function chkUseItemId() {
            if (this.use_item_id == '') {
                _get(Budget.prototype.__proto__ || Object.getPrototypeOf(Budget.prototype), 'addErrMsg', this).call(this, '用途を選択してください。');
                return false;
            }
            return true;
        }
    }, {
        key: 'chkPriceInput',
        value: function chkPriceInput() {
            if (this.price == '') {
                _get(Budget.prototype.__proto__ || Object.getPrototypeOf(Budget.prototype), 'addErrMsg', this).call(this, '金額を入力して下さい。');
                return false;
            }
            return true;
        }
    }, {
        key: 'chkPriceLen',
        value: function chkPriceLen() {
            if (! Checker.chkPrice(this.price.length)) {
                _get(Budget.prototype.__proto__ || Object.getPrototypeOf(Budget.prototype), 'addErrMsg', this).call(this, '金額は1千万円までで入力して下さい。');
                return false;
            }
            return true;
        }
    }, {
        key: 'chkSummary',
        value: function chkSummary() {
            if (!Checker.chkStrLen(this.summary, this.max_len_summary)) {
                _get(Budget.prototype.__proto__ || Object.getPrototypeOf(Budget.prototype), 'addErrMsg', this).call(this, '摘要は20文字以内で入力して下さい。');
            }
        }
    }]);

    return Budget;
}(Checker);

function budgetAction() {
    var wk_budget_obj = new Budget();
    wk_budget_obj.setDate(document.getElementById('creation_date').value);
    wk_budget_obj.setUseItemId(document.getElementById('use_item_id').value);
    wk_budget_obj.setPrice(document.getElementById('price').value);
    var summary = document.getElementById('summary').value;

    var result_flg = wk_budget_obj.chkDateInput();
    if (result_flg) {
        wk_budget_obj.chkDateFormat();
    }

    wk_budget_obj.chkUseItemId();

    result_flg = wk_budget_obj.chkPriceInput();
    if (result_flg) {
        wk_budget_obj.chkPriceLen();
    }

    if (summary != '') {
        wk_budget_obj.setSummary(summary);
        wk_budget_obj.chkSummary();
    }

    return wk_budget_obj.getChkRsult();
}
