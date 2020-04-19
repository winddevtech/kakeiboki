{include file="include/header.tpl" title='仮パスワード発行申請' systemRoot=$systemRoot gnav='outer'}
    <div id="container">
      <h2 class="title-h2">仮パスワード発行申請</h2>
      <div class="form-auth">
        <form method="POST" class="form form-free">
          <fieldset>
            <div class="formcontrol">
              <label for="email" class="off-left">Email</label>
              <input type="text" name="email" class="ctl-text" id="email" placeholder="Email" value="{$email}">
              {$err_email}
            </div>
            <input type="hidden" name="token" value="{$token}">
          </fieldset>
          <div class="btn-row btn-single">
            <input type="submit" value="仮パスワード発行" class="btn" id="js-submit">
          </div>
        </form>
      </div>
    </div>
{include file="include/footer.tpl" systemRoot=$systemRoot auth='true' slideMenu='outer'}