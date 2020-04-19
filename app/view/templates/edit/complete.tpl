{include file="include/header.tpl" title='ユーザー情報変更完了' gnav='inner' systemRoot=$systemRoot}
{include file="include/subcontents/gmenu.tpl" gcurrent="6"}
    <div id="container">
      <h2 class="title-h2">ユーザー情報変更完了</h2>
      <ol class="step">
        <li class="step-item step-prog">内容入力</li>
        <li class="step-span step-span-prog">&raquo;</li>
        <li class="step-item step-prog">確認</li>
        <li class="step-span step-span-prog">&raquo;</li>
        <li class="step-item step-prog">変更完了</li>
      </ol>
      <div class="complete">
        <p class="msg-success">ユーザー情報の変更が完了しました。<br>変更完了メールが登録されたEmail宛に送信されます。</p>
        <div class="btn-row btn-multi">
          <input type="button" value="仕訳帳へ" onclick="location.href='../accounting/list'" class="btn" />
        </div>
      </div>
    </div>
{include file="include/footer.tpl" slideMenu='inner' systemRoot=$systemRoot}