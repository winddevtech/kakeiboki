var window_w = null; // ウィンドウ幅
var window_h = null; // ウィンドウの高さ
var lbcontents_w = null;// ライトボックスのコンテンツ幅
var lbcontents_h = null;// ライトボックスのコンテンツの高さ
var bp = 768; //ブレイクポイント

var elemImg = document.createElement('img');
elemImg.src = 'images/loading.gif';

$(function() {
    var targetBody = $('#lb-body');

    var loadingAnimeClose = function() {
        $('#lb-loading').hide();
    }

    var chgLbPositon = function() {
        // ライトボックスの位置を特定
        var scroll_top = $(document).scrollTop();

        targetBody.css({
            'top' : (window_h - lbcontents_h) / 2 + scroll_top,
            'margin-left' : -lbcontents_w / 2
        });
    }

    // ローディングアニメーション表示
    var loadingAnime = function() {
        if (!document.getElementById('lb-loading')) {
            // アニメーション画像の作成
            $('#lb-body').append('<div id="lb-loading"></div>');
            //$("#lb-loading")(elemImg);
        }
        $('#lb-loading').show();

        // アニメーション画像を画面中央へ配置
        var loading_h = $('#lb-loading').height();
        $('#lb-loading').css('top', Math.floor((window_h - loading_h) / 2));
    }

    // ライトボックスを閉じる
    $('#lb-background, #lb-close, #lb-cancelBtn').click(function() {
        loadingAnimeClose();
        $('#lb-background, #lb-body').hide();
    });

    // ライトボックスを開く
    $('#lb-getlist td .lb-open').click(function() {
        window_w = window.innerWidth;
        window_h = window.innerHeight;
        lbcontents_h = targetBody.height();
        lbcontents_w = targetBody.width();
        // $('#lb-background, #lb-body').show();
        $('#lb-background, #lb-body').fadeIn(300, 'linear');
        loadingAnime();
        chgLbPositon();

        // ライトボックスに表示するデータを設定する
        var target = $(this).parents('#lb-getlist tr').find('td');
        var targetElemLen = target.size() - 2;
        var dispTarget = $('#lb-contents').find('td');
        for (var iLoop = 1; iLoop <= targetElemLen; iLoop++) {
            dispTarget.eq(iLoop - 1).text(target.eq(iLoop).text());
        }

        $('#budget_id').val(target.find('.deleate_budget_id').text());
        
        loadingAnimeClose();
    });

    $('#lb-deleteBtn').click(function(){
        var form = document.createElement('form');
        form.action = 'delete';
        form.method = 'get';
        var ipt1 = document.getElementById('budget_id');
        form.appendChild(ipt1);
        form.submit();
    });

    $(window).on('load resize', function() {
        window_w = window.innerWidth;
        window_h = window.innerHeight;
        lbcontents_h = targetBody.height();
        lbcontents_w = targetBody.width();
        var par;

        chgLbPositon();

        if (window_w < bp) {
            $('#lb-contents').addClass('sp-mode');
            par = Math.floor(window_w / 7);
        } else {
            $('#lb-contents').removeClass('sp-mode');
            par = 100;
        }
        document.getElementById('lb-contents').style.fontSize = par + '%';
    });
});
