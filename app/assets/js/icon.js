"use strict";

$(function() {
    var up_file = null;

    var canvas = document.querySelector('canvas');
    var ctx = canvas.getContext('2d');
    var icon_size = 50;

    var $prog_body = $('#js-progress-body');
    var $prog_bar = $('#js-progress-bar');

    var filename = document.querySelector('#js-filename');
    var post_icon_img = document.querySelector('#js-post_icon_img');
    var icon_img = document.querySelector('#js-icon_img');
    
    if (post_icon_img.value != ''){
        filename.textContent = '';
        icon_img.classList.add('icon-img--state_active');
    }
    
    $('#js-upload_btn').change(function(event) {
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

                icon_img.textContent = null;
                canvas.width = 0;
                canvas.height = 0;
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                canvas.width = icon_size;
                canvas.height = icon_size;
                ctx.drawImage(img, 0, 0, icon_size, icon_size);

                var resize_img = document.createElement('img');
                resize_img.src = canvas.toDataURL();
                filename.textContent = up_file.name;
                icon_img.appendChild(resize_img);
                icon_img.classList.add('icon-img--state_active');
                post_icon_img.value = canvas.toDataURL();
                $prog_body.removeClass('show');
              }
            }, 100);
          }
          img.src = reader.result;
        }
        reader.readAsDataURL(up_file);
        reader.onerror = function(event) {
          err_msg();
        }
      }
      var err_msg = function() {
        alert('ファイルの読み込みに失敗しました。');
      }
    });

    $('#js-icon_reset').click(function(event) {
        filename.textContent = 'ファイルを選択して下さい';
        post_icon_img.value = '';
        icon_img.children[0].src = '../images/default.png';
        icon_img.classList.remove('icon-img--state_active');
    });
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
