$(function() {
    var $dispTarget = $('#js-tab .tabBox');
    var $tab = $('#js-tab');
    var $tab_menu = $('#js-tab-menu');
    var $show = $dispTarget.eq(0);//初期表示タブ
    
    $dispTarget.not($show).hide();
    $tab.find('.tab-menu__item').eq(0).addClass('tab-menu__item--state_active');

    $($tab_menu).find('a').click(function() {
        $dispTarget.hide().eq($tab_menu.find('a').index(this)).show();
        $tab.find('.tab-menu__item').removeClass('tab-menu__item--state_active');
        $(this).parent('.tab-menu__item').addClass('tab-menu__item--state_active');
        return false;
    });
});
