'use strict';

$(function() {
    var window_w = 0; // 画面横幅
    var contents_h = 0; // コンテンツの高さ
    var $wrapper = $('#wrapper');

    //Gナビメニュー
    var $gmenu_area = $('#gmenu_area');
    var $gmenu = $('#js-gmenu');
    $gmenu.find('.gmenu-box').append('<span></span>');
    var $gmenu_gcurrent = $gmenu.find('.gcurrent');
    var $gmenu_span = $gmenu.find('span');
    var $gmenu_timer = null;
    var gmanu_span_width = 0; //Gナビメニューカレント横幅
    var gmanu_span_left = 0;  //Gナビメニューカレント左位置

    // ドロワーメニューの背景を設定
    $wrapper.after('<div id="slideMenu-background"></div><div id="slideMenu-btn"><span class="bar bar-01"></span><span class="bar bar-02"></span><span class="bar bar-03"></span></div>');

    var $slide_menu = $('#slideMenu');
    var $slide_menu_btn = $('#slideMenu-btn');
    var $slide_menu_bg = $('#slideMenu-background');

    setWindowSize();
    chgWindowSizeAction();

    $(window).on('resize', function() {
        setWindowSize();
        chgWindowSizeAction();
    });

    // 画面幅によって文字サイズとドロワーボタン表示を変更する
    function chgWindowSizeAction() {
        // 画面幅は768px未満か
        if (window_w < 768) {
            $gmenu_area.removeClass('open');
            document.getElementById('container').style.fontSize = Math.floor(window_w / 7.6) + '%';
        } else {
            $slide_menu_btn.removeClass('js--slideMenu--open');
            $slide_menu_bg.removeAttr('style');
            $('#container').removeAttr('style');//フォントサイズ
            $wrapper.removeClass('open');
            $slide_menu.removeClass('open');
        }
    }

    // ドロワーメニューボタン押下
    $slide_menu_btn.on('click', function () {
        $(this).toggleClass('js--slideMenu--open');
        toggleslideMenu();
        return false;
    });

    // ドロワーメニューの背景を押下
    $slide_menu_bg.click(function() {
        $slide_menu_btn.removeClass('js--slideMenu--open');
        toggleslideMenu();
        return false;
    });

    function setWindowSize(){
        window_w = window.innerWidth ? window.innerWidth: $(window).width();
    }
    // ドロワーメニューを開閉する
    function toggleslideMenu(){
        $slide_menu_bg.toggle();
        if(! $slide_menu_btn.hasClass('js--slideMenu--open')) {
            $slide_menu.removeClass('open');
            $wrapper.removeClass('open');
        } else {
            $slide_menu.addClass('open');
            $wrapper.addClass('open');
        }
    }

    //Gナビメニューにカレントはあるか
    if ($gmenu_area.find('.gmenu-item').hasClass('gcurrent')){
        gmanu_span_width = $gmenu_gcurrent.outerWidth();
        gmanu_span_left = $gmenu_gcurrent.position().left;
    }

    //Gナビメニューのカレント値を設定
    $gmenu_span.css({
        width: gmanu_span_width,
        left: gmanu_span_left
    });

    //Gナビメニュー起動リンクをホバー
    $('#js-gmenu-trigger').hover(function(){
      $gmenu_area.addClass('open');
      clearTimeout($gmenu_timer);
    });

    //Gナビメニューからマウスが離れる
    $gmenu_area.mouseleave(function(){
        $gmenu_span.stop().animate({
            width: gmanu_span_width,
            left: gmanu_span_left
        },'fast');
        $gmenu_timer = setTimeout(function(){
           $gmenu_area.removeClass('open');
        },3000);
    });

    //Gナビメニューのマウスオーバー中のカレントリンク値を設定
    $gmenu.find('a').mouseover(function(){
        $gmenu_span.stop().animate({
          width: $(this).outerWidth(),
          left: $(this).position().left
        },'fast');
    });
});
