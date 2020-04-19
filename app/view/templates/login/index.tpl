{include file="include/header.tpl" title='ログイン' systemRoot=$systemRoot toppage='true'}
    <div id="container">
      <div class="col-base col-1200 fv">
        <div class="fv-intro">
          <img src="assets/images/fv.jpg" width="150" height="100" alt="">
        </div>
        <p>簿記のように家計簿をつけながら会計に強くなるアプリです。</p>
        <div class="fv-form">
          <form method="POST"  class="form form-login">
            <fieldset>
              <div class="formcontrol">
                <label for="email" class="hidden">Email</label>
                <input type="text" name="email" id="email" placeholder="Email" class="ctl-text"  value="{$email}">
                {$err_email}
              </div>
              <div class="formcontrol">
                <label for="password" class="hidden">パスワード</label>
                <input type="password" name="password" id="password" placeholder="パスワード" class="ctl-password">
                {$err_password}
              </div>
              <div class="formcontrol">
                <label for="auto_login"> <input type="checkbox" name="auto_login" id="auto_login" class="ctl-checkbox">
                  次回から自動ログインする
                </label>
              </div>
              <input type="hidden" name="token" value="{$token}">
            </fieldset>
            {$err_multiple}
            <div class="btn-row btn-single">
              <input type="submit" value="ログイン" class="btn" id="js-submit">
            </div>
          </form>
          <div class="link"><a class="text-brown" href="{$systemRoot}/auth/">パスワードを忘れた方はこちら</a></div>
        </div>
        <div class="fv-version">
          <a href="{$systemRoot}/history/">更新履歴</a>
        </div>
      </div>
    </div>
{include file="include/footer.tpl" systemRoot=$systemRoot toppage='true'}