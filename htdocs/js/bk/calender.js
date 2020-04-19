(function ( $ ) {
    $.fn.calender = function (options){
        var param = $.extend(true, {
            'date': this.val(),
            'container': 'calendar-container'
        }, options);
        var $cal_container = $('#' + param.container);
        var $loadbox = $('.loadbox');

        $loadbox.fadeIn();
        $cal_container.find('.cal-head, .cal-body').remove();

        var dateParam =  param.date.split('/');
        var dt = new Date(dateParam[0],dateParam[1], 0);
        var html_h = '<div class="cal-head"><div class="cal-item cal-item-red">sun</div><div class="cal-item">mon</div><div class="cal-item">the</div><div class="cal-item">wed</div><div class="cal-item">thu</div><div class="cal-item">fri</div><div class="cal-item cal-item-blue">sat</div></div>';
        var html_b = '';
        var week_color = '';

        //当月の日数
        function monthDays () {
            return new Date(dt.getFullYear(),dt.getMonth() + 1, 0).getDate();
        }

        //曜日の色を決める
        function decisionWeekColor(i){
            var week_color = '';
            switch (i){
                case 0:
                    week_color = ' cal-item-red';
                    break;
                case 6:
                    week_color = ' cal-item-blue';
                    break;
                default:
                    week_color = '';
            }
            return week_color;
        }

        //日付要素のhtmlを作成する
        function createHtmlStrDayItem (week_color, week_index, day = ''){
            var week_list = ['sun', 'mon', 'the', 'wed', 'thu', 'fri', 'sat'];
            return '<div class="cal-item"><span class="cal-day'+ week_color + '">' + day + '</span><span class="cal-week' + week_color + '">' + week_list[week_index] + '</span><span class="cal-num"><a href="#">1件</a></span></div>';
        }

        //日付要素のセルhtmlを作成する
        function createHtmlStrCell (i, max, flg = false) {
            var week = '', day = '';
            for (; i <= max; i++) {
                if (flg) {
                    dt.setDate(i);
                    week = dt.getDay();
                    day = i;
                } else {
                    week = i;
                    day = '';
                }
                if (week == 0) {
                    html_b += '<div class="cal-row">';
                }
                week_color = decisionWeekColor(week);
                html_b += createHtmlStrDayItem(week_color, week, day);
                if (week == 6) {
                    html_b += '</div>';
                }
            }
        }

        //当月の最終日
        var last_day = monthDays();

        //当月初日の曜日(0-6)
        dt.setDate(1);
        var firstday_week = dt.getDay();

        //初日の曜日になるまでセルを埋める
        createHtmlStrCell(0, firstday_week - 1);

        //当月の日付を設定する
        createHtmlStrCell(1, last_day, true);

        //当月最終日の曜日
        dt.setDate(last_day);
        var lastday_week = dt.getDay();

        //当月最終日は日曜日・土曜日以外か
        if (lastday_week < 6) {
            //最終週の空白セルを埋める
            createHtmlStrCell(lastday_week + 1, 6);
        }

        $loadbox.fadeOut();
        $cal_container.append(html_h + '<div class="cal-body">' + html_b + '</div>');
        $('.cal-head, .cal-body').animate({right:'0',opacity:'1.0'},800);

        return this;
    };
})(jQuery);
