'use strict';

$(function() {
    //家計簿一覧のリスト開閉
    var $accordion = $('.accordion > tr > td:nth-child(1)'); //アコーディオンリスト項目
    var window_w = null;
    var bp = 768; //ブレイクポイント

    $accordion.click(function (){
        if (window_w < bp) {
            var index = $accordion.index(this);

            if ($accordion.eq(index).hasClass('js-acco-open')) {
                $accordion.eq(index).removeClass('js-acco-open').addClass('js-acco-close').siblings('td').slideToggle();
            } else {
                $accordion.eq(index).removeClass('js-acco-close').addClass('js-acco-open').siblings('td').slideToggle();
            }
        }
    });

    initAccodion();

    $(window).resize(function(){
        initAccodion();
    });

    //アコーディオン初期化
    function initAccodion(){
        window_w = window.innerWidth ? window.innerWidth: $(window).width();

        if (bp <= window_w) {
            $accordion.removeAttr('class');
            $('.accordion > tr > td').removeAttr('style');
        }else{
            $accordion.addClass('js-acco-open');
        }
    }
});
