(function ( $ ) {
    $.fn.closeing = function (options){
        var param = $.extend(true, {
            'date': this.val(),
            'container': 'closeing-container'
        }, options);
        var $container = $('#' + param.container);
        var $loadbox = $('.loadbox');

        $loadbox.fadeIn();
        $container.find('#js-closeing').remove();

        var dateParam =  param.date.split('/');
        var html_h = '<thead><tr><th>借方残高</th><th>借方合計</th><th>勘定科目</th><th>貸方合計</th><th>貸方残高</th></tr></thead>';
        var html_b = '';

        //日付要素のセルhtmlを作成する
        function createHtmlCloseingBody () {
            html_b = '<tbody>';

            for (var i = 0; i < 10; i++) {
                html_b += '<tr>';
                html_b += '<td class="text-right">' + 'Z,ZZZ,ZZZ' + '</td>';
                html_b += '<td class="text-right">' + 'Z,ZZZ,ZZZ' + '</td>';
                html_b += '<td>' + 'XXXXXXXXXX' + '</td>';
                html_b += '<td class="text-right">' + 'Z,ZZZ,ZZZ' + '</td>';
                html_b += '<td class="text-right">' + 'Z,ZZZ,ZZZ' + '</td>';
                html_b += '</tr>';
            }

            html_b += '</tbody>';
        }

        //当月の日付を設定する
        createHtmlCloseingBody();

        $loadbox.fadeOut();
        $container.append('<table id="js-closeing" class="closeing">' + html_h + html_b + '</table>');
        $('#js-closeing').animate({bottom:'0',opacity:'1.0'},800);

        return this;
    };
})(jQuery);
