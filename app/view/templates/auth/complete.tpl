{include file="include/header.tpl" title='仮パスワード発行完了' systemRoot=$systemRoot gnav='outer'}
    <div id="container">
      <h2 class="title-h2">仮パスワード発行完了</h2>
      <div class="complete">
        <p class="msg-success">
          仮パスワードが発行されました。<br>通知メールが送信されますのでご確認ください。<br>仮パスワードの有効期限は発行から24時間です。
        </p>
        <div class="btn-row btn-single">
          <input type="button" value="ログイン画面へ" onclick="location.href='../'" class="btn">
        </div>
      </div>
    </div>
{include file="include/footer.tpl" systemRoot=$systemRoot slideMenu='outer'}