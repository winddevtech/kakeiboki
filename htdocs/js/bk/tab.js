/**
 * タブ動作
 */

$(function() {
    var current = 0; //初期表示位置

    var dispTarget = $(".tab .tabBox");
    var show = dispTarget.eq(current);//初期表示タブ
    dispTarget.not(show).hide();
    $(".tab").find(".tabMenu").eq(current).addClass("current");

    $(".menu a").click(function() {
        dispTarget.hide().eq($(".menu").find("a").index(this)).show();
        $(".tab").find(".tabMenu").removeClass("current");
        $(this).parent(".tabMenu").addClass("current");
        return false;
    });
});
