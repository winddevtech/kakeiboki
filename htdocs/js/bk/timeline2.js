'use strict';

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

var tl_item_mode = Array(true, false, true, true, false, true, false);
(function ($) {
    $.fn.timeline = function (options) {
        var param = $.extend(true, {
            'container': this.val(),
            'direction': 'vertical',
            'delay': 500
        }, options);

        var Timeline = function () {
            function Timeline() {
                _classCallCheck(this, Timeline);

                this.container = container;
            }

            _createClass(Timeline, [{
                key: 'animation',
                value: function animation(direction) {
                    if (direction == 'vertical') {}
                }
            }, {
                key: 'createItem',
                value: function createItem(flg_reverse) {
                    var cls_reverse_str = '';
                    if (flg_reverse) {
                        cls_reverse_str = ' is-reverse';
                    }
                    return '<div class="ballon-item' + cls_reverse_str + '"><div class="ballon-time">2016/10/10 10:00</div><div class="ballon-image"><img src="https://placehold.jp/50x50.png" width="50" height="50" alt="" ></div><div class="ballon-text"><p>texttexttexttexttexttexttexttexttexttexttexttexttexttexttexttext</p></div></div>';
                }
            }, {
                key: 'showVertical',
                value: function showVertical(container) {
                    var j = 0;
                    var loop = function loop() {
                        $(container).find('.ballon-item:nth-child(' + (j + 1) + ')').addClass('show');
                        j++;
                        if (j == tl_item_mode.length - 1) {
                            clearTimeout(timer);
                        }
                    };
                    var timer = setInterval(loop, param.delay);
                }
            }]);

            return Timeline;
        }();

        var wk_obj = new Timeline();
        var set_html = '';
        for (var i = 0; i < tl_item_mode.length; i++) {
            set_html += wk_obj.createItem(tl_item_mode[i]);
        }
        $(this).append(set_html);
        wk_obj.showVertical(param.container);
        //const PI = 3.14;
        //let foo = [1, 2, 3];
        return this;
    };
})(jQuery);
