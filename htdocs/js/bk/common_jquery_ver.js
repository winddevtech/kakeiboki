'use strict';
/* ドロワーメニュー & 共通 */

$(function() {
    /*var $wrapper = $('#wrapper');
    var $slide_menu = $('#slideMenu');
    var $slide_menu_btn = $('#slideMenu-btn');
    var $slide_menu_bg = $('#slideMenu-background');*/
    var window_w = 0; // 画面横幅
    var contents_h = 0; // コンテンツの高さ
    //Gナビメニュー
    var $gmenu_area = $('#gmenu_area');
    var $gmenu_gcurrent = $('#js-gmenu .gcurrent');
    var $gmenu_span = $('#js-gmenu span');
    var $gmenu_timer = null;

    setWindowSize();
    chgWindowSizeAction();

    if (window_w < 768) {
    }

    $(window).on('resize', function() {
        setWindowSize();
        chgWindowSizeAction();
    });

    // 画面幅によって文字サイズとドロワーボタン表示を変更する
    function chgWindowSizeAction() {
        // 画面幅は768px未満か
        if (window_w < 768) {
            $('#slideMenu-btn').show();
            $gmenu_area.removeClass('open');
            document.getElementById('container').style.fontSize = Math.floor(window_w / 7.6) + '%';
        } else {
            $('#slideMenu-btn').hide().removeClass('js--slideMenu--open');
            $('#slideMenu-background').removeAttr('style');
            $('#container').removeAttr('style');//フォントサイズ
            $('#wrapper').removeClass('open');
            $('#slideMenu').removeClass('open');
            $('body').removeClass('open');
        }
    }

    // ドロワーメニューの背景を設定
    $('#wrapper').after('<div id="slideMenu-background"></div><div id="slideMenu-btn"><span class="bar bar-01"></span><span class="bar bar-02"></span><span class="bar bar-03"></span></div>');

    // ドロワーメニューボタン押下
    $('#slideMenu-btn').on('click', function () {
        $(this).toggleClass('js--slideMenu--open');
        toggleslideMenu();
        return false;
    });

    // ドロワーメニューの背景を押下
    $('#slideMenu-background').click(function() {
        $('#slideMenu-btn').removeClass('js--slideMenu--open');
        toggleslideMenu();
        return false;
    });

    function setWindowSize(){
        window_w = window.innerWidth ? window.innerWidth: $(window).width();
    }
    // ドロワーメニューを開閉する
    function toggleslideMenu(){
        $('#slideMenu-background').toggle();
        if(! $('#slideMenu-btn').hasClass('js--slideMenu--open')) {
            $('#slideMenu').removeClass('open');
            $('#wrapper').removeClass('open');
        } else {
            $('#slideMenu').addClass('open');
            $('#wrapper').addClass('open');
        }
    }

    //Gメニューの動作
    if ($gmenu_area.find('.gmenu-item').hasClass('gcurrent')){
        $gmenu_span.css({
          width: $gmenu_gcurrent.outerWidth(),
          left: $gmenu_gcurrent.position().left
        });
    }
    $('#js-gmenu-trigger').hover(function(){
      $gmenu_area.addClass('open');
      clearTimeout($gmenu_timer);
    });
    $gmenu_area.mouseleave(function(){
        $gmenu_span.stop().animate({
            width: $gmenu_gcurrent.outerWidth(),
            left: $gmenu_gcurrent.position().left
        },'fast');
        $gmenu_timer = setTimeout(function(){
           $gmenu_area.removeClass('open');
        },3000);
    });
    $('#js-gmenu a').mouseover(function(){
        $gmenu_span.stop().animate({
          width: $(this).outerWidth(),
          left: $(this).position().left
        },'fast');
    });
});
