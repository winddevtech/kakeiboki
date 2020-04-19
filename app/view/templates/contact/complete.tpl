{include file="include/header.tpl" title='お問い合わせ完了' systemRoot=$systemRoot gnav='inner'}
{include file="include/subcontents/gmenu.tpl" gcurrent="7"}
    <div id="container">
      <h2 class="title-h2">お問い合わせ完了</h2>
      <ol class="step">
        <li class="step-item step-prog">内容入力</li>
        <li class="step-span step-span-prog">&raquo;</li>
        <li class="step-item step-prog">確認</li>
        <li class="step-span step-span-prog">&raquo;</li>
        <li class="step-item step-prog">送信完了</li>
      </ol>
      <div class="complete">
        <p class="msg-success">
          お問い合わせありがとうございます。<br />お問い合わせから10日以内にご連絡させて頂きます。
        </p>
        <div class="btn-row btn-single">
          <input type="button" value="お問い合わせ一覧へ" onclick="location.href='list'" class="btn" />
        </div>
      </div>
    </div>
{include file="include/footer.tpl" systemRoot=$systemRoot slideMenu='inner'}