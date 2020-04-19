{include file="include/header.tpl" title='家計簿記管理システム' top="true"}
    <div id="container">
      <div class="box-small">
        <h2 class="login-title_ad">家計簿記管理システム</h2>
        <form method="POST" name="login" class="form form-login">
          <fieldset>
            <div class="formcontrol">
              <label for="login_id">ID</label>
              <input type="text" name="login_id" id="login_id" class="ctl-text" placeholder="ID" value="{$login_id}" >
              {$err_login_id}
            </div>
            <div class="formcontrol">
              <label for="password">パスワード</label>
              <input type="password" name="password" id="password" class="ctl-password" placeholder="パスワード" >
              {$err_password}
            </div>
            <input type="hidden" name="token" value="{$token}" >
          </fieldset>
          <div class="btn-row btn-single">
            <input type="submit" value="ログイン" class="btn" id="js-submit" >
          </div>
        </form>
      </div>
    </div>
{include file="include/footer.tpl" top="true"}