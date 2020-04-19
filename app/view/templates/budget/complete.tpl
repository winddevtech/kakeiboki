{include file="include/header.tpl" title='家計簿情報設定完了' systemRoot=$systemRoot gnav='inner'}
{include file="include/subcontents/gmenu.tpl" gcurrent="1"}
    <div id="container">
      <h2 class="title-h2">家計簿情報設定完了</h2>
      <ol class="step">
        <li class="step-item step-prog">内容入力</li>
        <li class="step-span step-span-prog">&raquo;</li>
        <li class="step-item step-prog">確認</li>
        <li class="step-span step-span-prog">&raquo;</li>
        <li class="step-item step-prog">設定完了</li>
      </ol>
      <div class="col-base col-630">
        <p class="msg-success">家計簿情報を設定しました。</p>
        <div class="btn-row btn-multi">
          <input type="button" value="設定を続ける" onclick="location.href='./'" class="btn" >
          <input type="button" value="仕訳帳へ" onclick="location.href='../accounting/list'" class="btn" >
        </div>
      </div>
    </div>
{include file="include/footer.tpl" systemRoot=$systemRoot}