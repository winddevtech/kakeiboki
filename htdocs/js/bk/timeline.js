'use strict'

var tl_item_mode = Array(true,false,true, true, false, true, false);

var j = 0;
const map  =  new WeakMap();
class Timeline {
    constructor(container) {
      let p = map.get(container);
      if (!p) {
        p = {};
        map.set(p,container);
      }
    }

    animation(direction){
        if (direction == 'vertical'){

        }
    }
    addItem(){

    }
    createItem (flg_reverse){
        var cls_reverse_str = '';
        if (flg_reverse) {
            cls_reverse_str = ' is-reverse';
        }
        return '<div class="ballon-item' + cls_reverse_str + '"><div class="ballon-time">2016/10/10 10:00</div><div class="ballon-image"><img src="https://placehold.jp/50x50.png" width="50" height="50" alt="" ></div><div class="ballon-text"><p>texttexttexttexttexttexttexttexttexttexttexttexttexttexttexttext</p></div></div>';
    }
    showVertical (container, delay){
        var loop = function(){
            document.querySelector(container + ' .ballon-item:nth-child(' + (j+1) + ')').classList.add('show');
            j++;
            if (j == document.querySelector(container).children.length) {
                clearTimeout(timer);
            }
        }
       var timer = setInterval(loop, delay);
    }
}

$('#wrapper').after('<div id="js-modal-overlay" class="modal-overlay"></div><div id="js-modal" class="modal modal-timeline"><div class="modal-contents"><p class="modal-form__title">返信内容を入力してください。</p><textarea rows="10" placeholder="返信内容を入力してください。" name="context" id="js-context" class="ctl-textarea"></textarea><div class="counterRow modal-form__counterRow">あと<span id="counter_context">1000</span>文字入力できます。</div></div><div class="btn-row btn-multi"><input type="button" value="キャンセル" class="btn" id="js-btn-cancel"><input type="submit" value="返信" class="btn" id="js-btn-reply"></div></div>');

var $overlay = $('#js-modal-overlay');
var $panel = $('#js-modal');

document.querySelector('#js-reply').addEventListener('click', function(e) {
    $overlay.fadeIn();
    $panel.fadeIn();
    setPosition();
    e.preventDefault();
}, false);

$('#js-btn-cancel').click(function(e) {
    hideModal();
    document.querySelector('#context').value = '';
    document.querySelector('#counter_context').innerHTML = 1000;
    e.preventDefault();
});

$('#js-btn-reply').click(function(e) {
    var context = document.querySelector('#context').value;
    hideModal();
    document.querySelector('#context').value = '';
    document.querySelector('#counter_context').innerHTML = 1000;

    var wk_obj = new Timeline('#js-ballon');
    $('#js-ballon').append(wk_obj.createItem(false));
    wk_obj.showVertical('#js-ballon', 500);

    e.preventDefault();
});

$(window).on('resize', function() {
    setPosition();
});

$overlay.click(function(e) {
    hideModal();
    e.preventDefault();
});

function setPosition() {
    var panelHeight = $panel.height();
    var windowHeight = $(window).height();
    $panel.css('top', (windowHeight - panelHeight) / 2);
}

function hideModal() {
    $overlay.fadeOut();
    $panel.fadeOut();
}

document.querySelector('#js-context').addEventListener('keyup', function() {
    document.querySelector('#counter_context').innerHTML = 1000 - this.value.length;
}, false);

(function ( $ ) {
    $.fn.timeline = function (options){
        var param = $.extend(true, {
            'container': this.val(),
            'direction': 'vertical',
            'delay': 500
        }, options);



        var wk_obj = new Timeline(param.container);
        var set_html = '';
        for (var i = 0; i < tl_item_mode.length; i++){
            set_html += wk_obj.createItem(tl_item_mode[i]);
        }
        $(this).append(set_html);
        wk_obj.showVertical(param.container, param.delay);
        //const PI = 3.14;
        //let foo = [1, 2, 3];
        return this;
    };
})(jQuery);
