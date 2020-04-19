"use strict";

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

var _get = function get(object, property, receiver) { if (object === null) object = Function.prototype; var desc = Object.getOwnPropertyDescriptor(object, property); if (desc === undefined) { var parent = Object.getPrototypeOf(object); if (parent === null) { return undefined; } else { return get(parent, property, receiver); } } else if ("value" in desc) { return desc.value; } else { var getter = desc.get; if (getter === undefined) { return undefined; } return getter.call(receiver); } };

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }

var Import = function (_Checker) {
    _inherits(Import, _Checker);

    function Import() {
        _classCallCheck(this, Import);

        var _this = _possibleConstructorReturn(this, (Import.__proto__ || Object.getPrototypeOf(Import)).call(this));

        _this.max_len_fliesize = 1048576;
        return _this;
    }

    _createClass(Import, [{
        key: 'setFile',
        value: function setFile(file) {
            this.file = file;
        }
    }, {
        key: 'getFile',
        value: function getFile() {
            return this.file;
        }
    }, {
        key: 'chkFileInput',
        value: function chkFileInput() {
            if (this.file == null) {
                _get(Import.prototype.__proto__ || Object.getPrototypeOf(Import.prototype), 'addErrMsg', this).call(this, 'インポートファイルを設定してください。');
                return false;
            }
            return true;
        }
    }, {
        key: 'chkFileFormat',
        value: function chkFileFormat() {
            if (!Checker.chkFileFormat(this.file.name)) {
                _get(Import.prototype.__proto__ || Object.getPrototypeOf(Import.prototype), 'addErrMsg', this).call(this, 'インポートファイルはcsv形式のファイルを設定してください。');
                return false;
            }
            return true;
        }
    }, {
        key: 'chkFileSize',
        value: function chkFileSize() {
            if (this.file.size > this.max_len_fliesize) {
                _get(Import.prototype.__proto__ || Object.getPrototypeOf(Import.prototype), 'addErrMsg', this).call(this, 'インポートファイルのサイズは1MB以下に設定してください。');
                return false;
            }
            return true;
        }
    }]);

    return Import;
}(Checker);

function chkModuleImport(up_file) {
    var errMsg = '';
    var wk_import_obj = new Import();
    wk_import_obj.setFile(up_file);

    /*var result_flg = wk_import_obj.chkFileInput();
    if (result_flg){
        result_flg = wk_import_obj.chkFileFormat();
    }
    if (result_flg){
        result_flg = wk_import_obj.chkFileSize();
    }*/

    return wk_import_obj.getChkRsult();
}

var up_file = null;
var uploading = false;
$(function () {
    var $overlay = $('.modal-overlay');
    var $panel = $('.modal');

    $('#js-import_file').change(function (event) {
        up_file = event.target.files[0];
        $('#filename').text(up_file.name);
    });

    var preview = function preview(files) {
        up_file = files[0];
        if (up_file.name.split(/\.(?=[^.]+$)/)[1] == 'csv') {
            $('#filename').text(up_file.name);
            $('#js-import_file')[0].files[0] = up_file;
        }
    };

    $('#form-import').on('dragover dragenter', function () {
        $(this).addClass('hover');
        return false;
    }).on('dragleave', function () {
        $(this).removeClass('hover');
        return false;
    }).on('drop', function (event) {
        $(this).removeClass('hover');
        event.preventDefault();
        preview(event.originalEvent.dataTransfer.files);
        return false;
    });

    $('#js-submit').click(function () {
        var chk_result = chkModuleImport(up_file);

        if (chk_result && !uploading && up_file) {
            uploading = true;

            var post = new FormData();
            post.append('import_file', up_file);
            var headerflg = document.getElementById('headerflg');
            if (headerflg.checked) {
                headerflg = headerflg.value;
            } else {
                headerflg = 0;
            }
            post.append('headerflg', headerflg);
            post.append('token', document.getElementById('token').value);

            $.ajax({
                url: 'confirm',
                type: 'post',
                data: post,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function success(data) {
                    var $overlay = $('.modal-overlay');
                    var $panel = $('.modal');

                    if (data.status == 'success') {
                        $panel.find('#js-error-none').show();
                        $panel.find('#js-error-exist').hide();
                        $('#js_import_ok').text(data.ok_count);
                        $('#js_import_ng').text(data.ng_count);
                    } else {
                        $panel.find('#js-error-none').hide();
                        $panel.find('#js-error-exist').show();
                        $('#js-error-msg').text(data.err_msg);
                    }

                    $panel.fadeIn();
                    $overlay.fadeIn();
                    var panelHeight = $panel.height();
                    var windowHeight = $(window).height();
                    $panel.css('top', (windowHeight - panelHeight) / 2);
                },
                error: function error(data) {
                    //パラメータ初期化
                    up_file = null;
                    alert('送信エラーが発生しました。');
                }
            }).always(function (data) {
                //パラメータ初期化
                uploading = false;
                $('#token').val(data.token);
            });
        }
        return false;
    });

    var $overlay = $('.modal-overlay');
    var $panel = $('.modal');

    $(window).on('resize', function () {
        setPosition();
    });

    function setPosition() {
        var panelHeight = $panel.height();
        var windowHeight = $(window).height();
        $panel.css('top', (windowHeight - panelHeight) / 2);
    }

    $('#js-btn-import').click(function () {
        var post = new FormData();
        post.append('token', document.getElementById('token').value);
        $.ajax({
            url: 'complete',
            type: 'post',
            data: post,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function success(data) {
                if (data.status == 'success') {
                    hideModal();
                    $('#js_import_result').text(data.ok_count);
                    toastAction();
                } else {
                    alert('プログラムエラーが発生しました。');
                }
            },
            error: function error(data) {
                alert('送信エラーが発生しました。');
            }
        }).always(function (data) {
            //パラメータ初期化
            uploading = false;
            up_file = null;
            $('#token').val(data.token);
            $('#filename').text('ファイルを選択して下さい。');
        });
    });

    $overlay.click(function () {
        hideModal();
    });

    $('#js-btn-cancel, #js-btn-return').click(function () {
        hideModal();
    });

    function hideModal() {
        $overlay.hide();
        $panel.hide();
    }

    var $toast = $('.toast-panel');

    function toastAction() {
        $toast.fadeIn();
        var timer = window.setTimeout(function () {
            $toast.fadeOut();
            window.clearTimeout(timer);
        }, 5000);
    }
});
