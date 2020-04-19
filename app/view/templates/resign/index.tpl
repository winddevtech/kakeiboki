{include file="include/header.tpl" title='退会確認' systemRoot=$systemRoot}
    <div id="container">
      <h2 class="title-h2">退会確認</h2>
      <div class="col-base col-630">
        <p class="msg-info">
          本当に退会してよろしいですか？<br>退会すると、登録されたユーザー情報は消去されます。
        </p>
        <form method="POST">
          <input type="hidden" name="token" value="{$token}" >
          <div class="btn-row btn-multi">
            <input type="button" value="退会しない" onclick="location.href='../accounting/list'" class="btn">
            <input type="submit" value="退会する" class="btn">
          </div>
        </form>
      </div>
    </div>
{include file="include/footer.tpl" systemRoot=$systemRoot}