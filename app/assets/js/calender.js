$(function() {
    var $loadbox = $('.loadbox');
    $loadbox.fadeIn();
    
    if (document.getElementById('js-calender')){
        getCalender();
    }
      
    $('#js-calender').change(function (){
        $loadbox.fadeIn();
        getCalender();
    });
        
    function getCalender(){
        var fd = new FormData();
        fd.append('search_date', document.getElementById('js-calender').value);

        $.ajax({
            url : 'changeCalender',
            type : 'post',
            data : fd,
            contentType : false,
            processData : false,
            dataType : 'json',
            success : function(data) {
                $loadbox.fadeOut();
                if (data.status == 'success'){
                    $('#js-calender').calender({
                        'date': document.getElementById('js-calender').value,
                        'calender_list': data.calender_list
                    });
                } else {
                    alert('システムエラーが発生しました。復旧までしばらくお待ちください。');
                }
            },
            error : function(xhr, textStatus, errorThrown) {
                //パラメータ初期化
                alert('送信エラーが発生しました。システム復旧までしばらくお待ちください。');
            }
        }).always(function(data){
        });
    }
    return false;
});

(function ( $ ) {
    $.fn.calender = function (options){
        var param = $.extend(true, {
            'container': 'calendar-container',
            'date': this.val(),
            'calender_list': ''
        }, options);
        var $cal_container = $('#' + param.container);
        
        $cal_container.find('.cal-head, .cal-body').remove();
        
        var dateParam =  param.date.split('/');
        var calender_list =  param.calender_list;
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
        function createHtmlStrDayItem (week_color, week_index, day, item_count, item_date){
            if (! day) {
                day = '';
            }
            var week_list = ['sun', 'mon', 'the', 'wed', 'thu', 'fri', 'sat'];
            return '<div class="cal-item"><span class="cal-day'+ week_color + '">' + day + '</span><span class="cal-week' + week_color + '">' + week_list[week_index] + '</span><span class="cal-num"><a href="list?start_date=' + item_date + '&amp;end_date=' + item_date + '">' + item_count + '</a></span></div>';
        }

        //日付要素のセルhtmlを作成する
        function createHtmlStrCell (i, max, flg, marge_list) {
            var week = '', day = '', item_count = '', item_date = '';
            if (! flg) {
                flg = false;
            }
            if (! marge_list) {
                marge_list = '';
            }
            for (; i <= max; i++) {
                if (flg) {
                    dt.setDate(i);
                    week = dt.getDay();
                    day = i;
                    if (marge_list[i - 1] == '') {
                        item_count = '';
                        item_date = '';
                    }else{
                        item_count = marge_list[i - 1][1] + '件';
                        item_date = marge_list[i - 1][0];
                    }
                } else {
                    week = i;
                }
                if (week == 0) {
                    html_b += '<div class="cal-row">';
                }
                week_color = decisionWeekColor(week);
                html_b += createHtmlStrDayItem(week_color, week, day, item_count, item_date);
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
        
        //当月の日別毎に家計簿データを設定する
        var marge_list = new Array ();
        var day_str = '';
        var list_index = 0;
        for (var i = 1; i <= last_day; i++){
            if (list_index < calender_list.length) {
                day_str = param.calender_list[list_index][0].substr(8,2);
            }else{
                day_str = '';
            }
            
            if (parseInt(day_str) == i) {
                marge_list.push(param.calender_list[list_index]);
                list_index++;
            }else{
                marge_list.push('');
            }
        }
        
        
        //当月の日付を設定する
        createHtmlStrCell(1, last_day, true, marge_list);

        //当月最終日の曜日
        dt.setDate(last_day);
        var lastday_week = dt.getDay();

        //当月最終日は日曜日・土曜日以外か
        if (lastday_week < 6) {
            //最終週の空白セルを埋める
            createHtmlStrCell(lastday_week + 1, 6);
        }

        $cal_container.append(html_h + '<div class="cal-body">' + html_b + '</div>');
        $('.cal-head, .cal-body').animate({right:'0',opacity:'1.0'},800);

        return this;
    };
})(jQuery);
