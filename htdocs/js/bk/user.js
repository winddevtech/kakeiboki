//"use strict";

// ユーザー登録用
function userAction() {
    var user_name = document.getElementById('user_name').value;
    var email = document.getElementById('email').value;
    var password = document.getElementById('password').value;
    var password_conf = document.getElementById('password_conf').value;
    var errMsg = '';
    var nameMaxLength = 20;
    var emailMaxLength = 50;

    var chkObj = new Checker();
    if (user_name == '') {
        errMsg = 'ユーザー名を入力して下さい。';
    } else if (!chkObj.chkStrLen(user_name , nameMaxLength)) {
        errMsg = 'ユーザー名は20文字以内で入力してくさい。';
    } else if (email == '') {
        errMsg = 'Emailを入力して下さい。';
    } else if (!chkObj.chkStrLen(email, emailMaxLength)) {
        errMsg = 'Emailは50文字以内で入力してくさい。';
    } else if (!chkObj.chkEmailFormat(email)) {
        errMsg = 'Emailが不正です。';
    } else if (password == '') {
        errMsg = 'パスワードを入力して下さい。';
    } else if (password_conf == '') {
        errMsg = '確認用パスワードを入力して下さい。';
    } else if (!chkObj.chkPasswordLength(password)) {
        errMsg = 'パスワードの長さは8文字以上、30文字以内で入力して下さい。';
    } else if (!chkObj.chkPasswordLength(password_conf)) {
        errMsg = '確認用パスワードの長さは8文字以上、30文字以内で入力して下さい。';
    } else if (password != password_conf) {
        errMsg = 'パスワードと確認用パスワードが一致しません。';
    }

    if (errMsg != '') {
        alert(errMsg);
        return false;
    }
    return true;
}


$(function() {
    var up_file = null;
    //var uploading = false;

    //var $overlay = $('.modal-overlay');
    //var $panel = $('.modal');

    var canvas = document.querySelector('canvas');
    var ctx = canvas.getContext('2d');
    var icon_size = 50;

    var $prog_body = $('#js-progress-body');
    var $prog_bar = $('#js-progress-bar');

    $('#js-upload-btn').change(function(event) {
      up_file = event.target.files[0];
      if (!up_file){
        return false;
      }
      var reader = new FileReader();
      var img = new Image();

      if (up_file.type.match(/image\/\w+/)){
        reader.onloadend = function() {
          img.onload = function(event) {

            var i = 0;
            var pathLength = 300;
            $prog_body.addClass('show');
            $prog_bar.css('strokeDashoffset', 300);

            var loading = setInterval(function() {
              var val = pathLength * (1 - 0.1 * i);
              $prog_bar.css('strokeDashoffset', val);
              i += 1;

              if(10 < i) {
                clearInterval(loading);

                document.querySelector('#js-icon-img').textContent = null;
                canvas.width = 0;
                canvas.height = 0;
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                canvas.width = icon_size;
                canvas.height = icon_size;
                ctx.drawImage(img, 0, 0, icon_size, icon_size);

                var resize_img = document.createElement('img');
                resize_img.src = canvas.toDataURL();
                document.querySelector('#js-filename').textContent = up_file.name;
                document.querySelector('#js-icon-img').appendChild(resize_img);
                document.querySelector('#js_post_icon_img').value = canvas.toDataURL();
                $prog_body.removeClass('show');
              }
            }, 100);
          }
          img.src = reader.result;
        }
        reader.readAsDataURL(up_file);
        reader.error = function(event) {
          errMsg();
        }
      }
      var errMsg = function() {
        alert('ファイルの読み込みに失敗しました。');
      }
    });

    function base64ToBlob(base64){
    	var base64Data = base64.split(',')[1],
    		data = window.atob(base64Data),
    		buff = new ArrayBuffer(data.length),
    		arr = new Uint8Array(buff),
    		blob, i, dataLen;

    	for( i = 0, dataLen = data.length; i < dataLen; i++){
    		arr[i] = data.charCodeAt(i);
    	}
    	blob = new Blob([arr], {type: 'image/png'});
    	return blob;
    }

});
