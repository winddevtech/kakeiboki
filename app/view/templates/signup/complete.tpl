{include file="include/header.tpl" title='ユーザー情報登録完了' systemRoot=$systemRoot gnav='inner'}
{include file="include/subcontents/gmenu.tpl" gcurrent="0"}
    <div id="container">
      <h2 class="title-h2">ユーザー情報登録完了</h2>
      <ol class="step">
        <li class="step-item step-prog">内容入力</li>
        <li class="step-span step-span-prog">&raquo;</li>
        <li class="step-item step-prog">確認</li>
        <li class="step-span step-span-prog">&raquo;</li>
        <li class="step-item step-prog">登録完了</li>
      </ol>
      <div class="complete">
        <p class="msg-success">
          ユーザー登録が完了しました。<br>登録完了メールがユーザーのEmail宛に送信されます。
        </p>
        <div class="btn-row btn-single">
          <input type="button" value="仕訳帳へ" onclick="location.href='../accounting/list'" class="btn">
        </div>
      </div>
    </div>
{include file="include/footer.tpl" systemRoot=$systemRoot slideMenu='inner'}