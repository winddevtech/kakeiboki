$(function() {
    var $overlay = $('.modal-overlay');
    var $panel = $('.modal');

    function call_modal(){
        $panel.fadeIn();
        $overlay.fadeIn();
        setPosition();
        //$(this).parent().addClass('flag');
    }
    /*$('.message-btn').click(function(e) {
        //e.preventDefault();
        $panel.fadeIn();
        $overlay.fadeIn();
        setPosition();
        $(this).parent().addClass('flag');
    });*/

    $(window).on('resize', function() {
        setPosition();
    });

    function setPosition () {
        var panelHeight = $panel.height();
        var windowHeight = $(window).height();
        $panel.css('top', (windowHeight - panelHeight) / 2);
    }

    $('#js-btn-import').click(function() {
        hideModal();
        toastAction();
    });

    $overlay.click(function() {
        hideModal();
    });

    $('#js-btn-cancel, #js-btn-return').click(function() {
        hideModal();
    });

    function hideModal () {
        $overlay.hide();
        $panel.hide();
    }

    var $toast = $('.toast-panel');

    function toastAction (){
        $toast.fadeIn();
        var timer = window.setTimeout(function(){
          $toast.fadeOut();
          window.clearTimeout(timer);
        },5000);
    }
});
