{include file="include/header.tpl" title='ユーザー情報新規登録' systemRoot=$systemRoot gnav='outer' css_font='true'}
    <div id="container">
      <h2 class="title-h2">ユーザー情報新規登録</h2>
      <ol class="step">
        <li class="step-item step-prog">内容入力</li>
        <li class="step-span">&raquo;</li>
        <li class="step-item">確認</li>
        <li class="step-span">&raquo;</li>
        <li class="step-item">登録完了</li>
      </ol>
      <div class="col-base col-630">
        <form method="POST" class="form" enctype="multipart/form-data">
          <small class="annotation">※は入力必須項目です。</small>
          <fieldset>
            <table class="table-responsive">
              <tbody>
                <tr>
                  <th><span class="required">※</span><label for="user_name">ユーザー名<span>（20文字以内）</span></label></th>
                  <td><input type="text" name="user_name" id="user_name" class="ctl-text" value="{$user_name}" placeholder="ユーザー名">{$err_username}</td>
                </tr>
                <tr>
                  <th><span class="required">※</span><label for="email">Email<span>（半角50文字以内）</span></label></th>
                  <td><input type="text" name="email" id="email" class="ctl-text" value="{$email}" placeholder="Email">{$err_email}</td>
                </tr>
                <tr>
                  <th><span class="required">※</span><label for="password">パスワード<span>（8文字以上30文字以内）</span></label></th>
                  <td><input type="password" name="password" id="password" class="ctl-password" placeholder="パスワード">{$err_password}</td>
                </tr>
                <tr>
                  <th><span class="required">※</span><label for="password_conf">確認用パスワード</label></th>
                  <td><input type="password" name="password_conf" class="ctl-password" id="password_conf" placeholder="確認用パスワード">{$err_password_conf}</td>
                </tr>
                <tr>
                  <th><span class="required">※</span><label for="display_count">一覧表示件数</label></th>
                  <td>{$select_html_str}<span class="display_count_unit">件/1ページ</span>{$err_display_count}</td>
                </tr>
                <tr>
                  <th><label for="js-upload_btn">アイコン画像</label></th>
                  <td><div class="upload"><i class="fa fa-upload upload-icon" aria-hidden="true">
                  <input type="file" name="upload-btn" id="js-upload_btn" class="upload-btn"></i>
                  <span id="js-filename" class="upload-name">ファイルを選択して下さい</span></div>
                  <canvas class="icon-canvas"></canvas>
                  <input type="hidden" name="icon_img" id="js-post_icon_img" value="{$post_icon_img}" >
                    <div class="icon-img" id="js-icon_img"><img src="{$icon_img}" width="50" height="50" alt=""></div>
                    <input type="button" value="リセット" class="btn btn-reset" id="js-icon_reset">
                    <svg id="js-progress-body" class="progress-body" viewPort="0 0 200 3" width="300" height="10" version="1.1" xmlns="http://www.w3.org/2000/svg">
                      <path class="progress-bar" d="M 0 1 L 300 1" stroke="#e0e0e0" />
                      <path id="js-progress-bar" class="progress-bar" d="M 0 1 L 300 1" stroke="#d9534f" stroke-dasharray="300" style="stroke-dashoffset: 300px;" />
                    </svg>
                    {$err_icon_img}
                  </td>
                </tr>
              </tbody>
            </table>
            <input type="hidden" name="token" value="{$token}">
          </fieldset>
          <div class="btn-row btn-single">
            <input type="submit" value="確認" class="btn" id="js-submit">
          </div>
        </form>
      </div>
    </div>
{include file="include/footer.tpl" systemRoot=$systemRoot user='true' slideMenu='outer'}