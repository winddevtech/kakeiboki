'use strict';

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

var j = 0;
var map = new WeakMap();

var Timeline = function () {
    function Timeline(container) {
        _classCallCheck(this, Timeline);

        var p = map.get(container);
        if (!p) {
            p = {};
            map.set(p, container);
        }
    }

    _createClass(Timeline, [{
        key: 'createItem',
        value: function createItem(timeline_obj, user_name, user_icon) {
            var cls_reverse_str = '',
                icon_path = '',
                icon_alt = '',
                timeline_html = '';
            if (timeline_obj.sender == 2) {
                cls_reverse_str = ' is-reverse';
                icon_path = '/kakeiboki/app/assets/images/kanri.png';
                icon_alt = '管理者';
            } else {
                icon_path = user_icon;
                icon_alt = user_name;
            }
            timeline_html += '<div class="ballon-item' + cls_reverse_str + '"><div class="ballon-time">' + timeline_obj.created_at + '</div>';
            timeline_html += '<div class="ballon-image"><img src="' + icon_path + '" width="50" height="50" alt="' + icon_alt + '" ></div>';
            timeline_html += '<div class="ballon-text"><p>' + timeline_obj.context + '</p></div></div>';
            return timeline_html;
        }
    }, {
        key: 'showVertical',
        value: function showVertical(container, delay) {
            var loop = function loop() {
                document.querySelector(container + ' .ballon-item:nth-child(' + (j + 1) + ')').classList.add('show');
                j++;
                if (j == document.querySelector(container).children.length) {
                    clearTimeout(timer);
                }
            };
            var timer = setInterval(loop, delay);
        }
    }]);

    return Timeline;
}();

var formatDate = function formatDate(date, format) {
    if (!format) format = 'YYYY-MM-DD hh:mm:ss.SSS';
    format = format.replace(/YYYY/g, date.getFullYear());
    format = format.replace(/MM/g, ('0' + (date.getMonth() + 1)).slice(-2));
    format = format.replace(/DD/g, ('0' + date.getDate()).slice(-2));
    format = format.replace(/hh/g, ('0' + date.getHours()).slice(-2));
    format = format.replace(/mm/g, ('0' + date.getMinutes()).slice(-2));
    format = format.replace(/ss/g, ('0' + date.getSeconds()).slice(-2));
    if (format.match(/S/g)) {
        var milliSeconds = ('00' + date.getMilliseconds()).slice(-3);
        var length = format.match(/S/g).length;
        for (var i = 0; i < length; i++) {
            format = format.replace(/S/, milliSeconds.substring(i, i + 1));
        }
    }
    return format;
};

function createElemHidden(name, id, value) {
    var elem = document.createElement('input');
    elem.type = 'hidden';
    elem.name = name;
    elem.id = id;
    elem.value = value;

    return elem;
}

function escapeHtml(string) {
    if (typeof string !== 'string') {
        return string;
    }
    return string.replace(/[&'`"<>]/g, function (match) {
        return {
            '&': '&amp;',
            "'": '&#x27;',
            '`': '&#x60;',
            '"': '&quot;',
            '<': '&lt;',
            '>': '&gt;'
        }[match];
    });
}

$(function () {
    $('#wrapper').after('<div id="js-modal-overlay" class="modal-overlay"></div><div id="js-modal" class="modal modal-timeline"><div class="modal-contents"><p class="modal-form__title">内容を入力してください。</p><textarea rows="10" placeholder="内容を入力してください。" name="context" id="js-context" class="ctl-textarea"></textarea><div class="counterRow modal-form__counterRow">あと<span id="js-counter_context">1000</span>文字入力できます。</div></div><div class="btn-row btn-multi"><input type="button" value="キャンセル" class="btn" id="js-btn-cancel"><input type="submit" value="送信" class="btn" id="js-btn-send"></div></div>');

    var $overlay = $('#js-modal-overlay');
    var $panel = $('#js-modal');
    var $sendBtn = $('#js-btn-send');

    document.querySelector('#js-form_open').addEventListener('click', function (e) {
        $overlay.fadeIn();
        $panel.fadeIn();
        setPosition();
        e.preventDefault();
    }, false);

    $('#js-btn-cancel').click(function (e) {
        hideModal();
        resetContextForm();
        e.preventDefault();
    });

    $sendBtn.click(function (e) {
        var context = document.querySelector('#js-context').value;

        if (0 < context.length) {
            hideModal();
            addTimeline(context);
            resetContextForm();
        } else {
            alert('お問い合わせ内容を入力して下さい。');
        }

        e.preventDefault();
    });

    $(window).on('resize', function () {
        setPosition();
    });

    $overlay.click(function (e) {
        hideModal();
        resetContextForm();
        e.preventDefault();
    });

    function resetContextForm(){
        document.querySelector('#js-context').value = '';
        document.querySelector('#js-counter_context').innerHTML = 1000;
    }

    function setPosition() {
        var panelHeight = $panel.height();
        var windowHeight = $(window).height();
        $panel.css('top', (windowHeight - panelHeight) / 2);
    }

    function hideModal() {
        $overlay.fadeOut();
        $panel.fadeOut();
    }

    document.getElementById('js-context').addEventListener('keyup', function () {
        var contextLen = 1000 - this.value.length;
        if (0 <= contextLen && $sendBtn.css('display') == 'none') {
            $sendBtn.show();
        } else if (contextLen <= 0) {
            $sendBtn.hide();
        }

        document.getElementById('js-counter_context').innerHTML = contextLen;
    }, false);

    getTimeline();

    function getTimeline() {
        $.ajax({
            url: 'display',
            type: 'GET',
            data: { 'contact_id': document.getElementById('js-contact_id').value },
            contentType: false,
            processData: true,
            dataType: 'json',
            success: function success(data) {
                if (data.status == 'success') {
                    document.getElementById('js-category_name').innerHTML = data.category_name;
                    $('#js-timeline-head').fadeIn();
                    var elem = createElemHidden('user_name', 'js-user_name', data.user_name);
                    document.getElementById('container').appendChild(elem);
                    elem = createElemHidden('user_icon', 'js-user_icon', data.user_icon);
                    document.getElementById('container').appendChild(elem);

                    $('#js-ballon').timeline({
                        'container': '#js-ballon',
                        'direction': 'vertical',
                        'timeline_list': data.timeline_list,
                        'user_name': document.getElementById('js-user_name').value,
                        'user_icon': document.getElementById('js-user_icon').value
                    });

                    $('#js-timeline-btn').fadeIn();
                } else {
                    //タイムライン取得失敗時はエラーページに遷移する
                    var url_str = window.location.href;
                    if (url_str.indexOf('/app_ad/') != -1) {
                        location.href='/kakeiboki/app_ad/errpage/err404';
                    } else if (url_str.indexOf('/app/') != -1) {
                        location.href='/kakeiboki/app/errpage/err404';
                    }
                }
            },
            error: function error(xhr, textStatus, errorThrown) {
                alert('タイムラインの取得に失敗しました。復旧までしばらくお待ちください。');
            }
        }).always(function (data) {
            $('#token').val(data.token);
        });
    }

    function addTimeline(context) {
        var fd = new FormData();
        fd.append('contact_id', document.getElementById('js-contact_id').value);
        fd.append('context', context);
        fd.append('token', document.getElementById('token').value);

        $.ajax({
            url: 'add',
            type: 'post',
            data: fd,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function success(data) {
                if (data.status == 'success') {
                    var wk_obj = new Timeline('#js-ballon');
                    var item_obj = new Object();
                    item_obj.sender = data.sender;
                    item_obj.created_at = formatDate(new Date(), 'YYYY/MM/DD hh:mm:ss');
                    item_obj.context = escapeHtml(context);
                    $('#js-ballon').append(wk_obj.createItem(item_obj, document.getElementById('js-user_name').value, document.getElementById('js-user_icon').value));
                    wk_obj.showVertical('#js-ballon', 500);
                } else {
                    alert('システムエラーが発生しました。復旧までしばらくお待ちください。');
                }
            },
            error: function error(xhr, textStatus, errorThrown) {
                alert('送信エラーが発生しました。復旧までしばらくお待ちください。');
            }
        }).always(function (data) {
            $('#token').val(data.token);
        });
    }
});

(function ($) {
    $.fn.timeline = function (options) {
        var param = $.extend(true, {
            'container': this.val(),
            'direction': 'vertical',
            'delay': 500,
            'timeline_list': '',
            'user_name': '',
            'user_icon': ''
        }, options);

        var wk_obj = new Timeline(param.container);
        var set_html = '';
        for (var i = 0; i < param.timeline_list.length; i++) {
            set_html += wk_obj.createItem(param.timeline_list[i], param.user_name, param.user_icon);
        }
        $(this).append(set_html);
        wk_obj.showVertical(param.container, param.delay);

        return this;
    };
})(jQuery);
