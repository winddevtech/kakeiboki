'use strict'
$(function() {
    $('#wrapper').after('<div id="js-modal-overlay" class="modal-overlay"></div><div id="js-modal" class="modal modal-timeline"><div class="modal-contents"><p class="modal-form__title">内容を入力してください。</p><textarea rows="10" placeholder="内容を入力してください。" name="context" id="context" class="ctl-textarea"></textarea><div class="counterRow modal-form__counterRow">あと<span id="js-counter_context">1000</span>文字入力できます。</div></div><div class="btn-row btn-multi"><input type="button" value="キャンセル" class="btn" id="js-btn-cancel"><input type="submit" value="送信" class="btn" id="js-btn-send"></div></div>');

    var $overlay = $('#js-modal-overlay');
    var $panel = $('#js-modal');
    var $sendBtn = $('#js-btn-send');

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

    $sendBtn.click(function(e) {
        var context = document.querySelector('#context').value;
        hideModal();
        document.querySelector('#context').value = '';
        document.querySelector('#counter_context').innerHTML = 1000;

        var wk_obj = new Timeline();
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

    document.querySelector('#context').addEventListener('keyup', function() {
        document.querySelector('#counter_context').innerHTML = 1000 - this.value.length;
    }, false);

});
