$(function() {
    var up_file = null;
    var uploading = false;

    var $overlay = $('#js-modal-overlay');
    var $panel = $('#js-modal');

    $('#js-import_file').change(function(event) {
        up_file = event.target.files[0];
        $('#filename').text(up_file.name);
    });

    var preview = function(files) {
        up_file = files[0];
        if(up_file.name.split(/\.(?=[^.]+$)/)[1] == 'csv'){
            $('#filename').text(up_file.name);
            $('#js-import_file')[0].files[0] = up_file;
        }
    };

    $('#form-import').on('dragover dragenter', function() {
        $(this).addClass('hover');
        return false;
    }).on('dragleave', function() {
        $(this).removeClass('hover');
        return false;
    }).on('drop', function(event) {
        $(this).removeClass('hover');
        event.preventDefault();
        preview(event.originalEvent.dataTransfer.files);
        return false;
    });

    function importAction(up_file) {
        var errMsg = '';
        var chkObj = new Checker();
        if (up_file == null) {
            errMsg = 'インポートファイルを設定してください。';
        } else if (chkObj.chkFileFormat(up_file.name)) {
            errMsg = 'インポートファイルはcsv形式のファイルを設定してください。';
        } else if (up_file.size > 1048576) {
            errMsg = 'インポートファイルのサイズは1MB以下に設定してください。';
        }

        if (errMsg != '') {
            alert(errMsg);
            return false;
        }
        return true;
    }

    $('#js-submit').click(function() {
        var chk_result = importAction(up_file);

        if (chk_result && ! uploading && up_file) {
            uploading = true;

            var post = new FormData();
            post.append('import_file', up_file);

            $.ajax({
                url : 'confirm',
                type : 'post',
                data : post,
                contentType : false,
                processData : false,
                success : function() {
                    alert('true');
                    uploading = false;
                    up_file = null;
                    $('#filename').text('');
                },
                error : function() {
                    //alert('送信エラーが発生しました。');
                    var $overlay = $('.modal-overlay');
                    var $panel = $('.modal');
                    $panel.find('#js-error-none').hide();
                    $panel.find('#js-error-exist').show();

                    //$panel.find('#js-error-exist').show();
                    //$panel.find('#js-error-none').hide();

                    $panel.fadeIn();
                    $overlay.fadeIn();
                    var panelHeight = $panel.height();
                    var windowHeight = $(window).height();
                    $panel.css('top', (windowHeight - panelHeight) / 2);

                    uploading = false;
                }
            }).always(function(){

            });
        }
        return false;
    });
});
