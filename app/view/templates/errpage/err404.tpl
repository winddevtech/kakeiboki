{if $login_flg == false}
  {include file="include/header.tpl" title='お探しのページは見つかりません。（404 Not Found）' systemRoot=$systemRoot gnav='outer'}
{else}
  {include file="include/header.tpl" title='お探しのページは見つかりません。（404 Not Found）' systemRoot=$systemRoot gnav='inner'}
  {include file="include/subcontents/gmenu.tpl" gcurrent="0"}
{/if}
  <div id="container">
    <div class="section">
      <div id="page-title">
        <h3>お探しのページは見つかりません。（404 Not Found）</h3>
      </div>
        <p>
          お探しのページはURLが間違っているか、ページが移動または削除等の理由により<br />表示することができませんでした。<br />お手数ですが、一度ログインをし直してから再度アクセスをお試し下さい。<br />それでも解決しない場合は以下のリンクよりお問い合わせ下さい。
          <br /> <a href="mailto:">お問い合わせはこちら</a>
        </p>
    </div>
  </div>
{if $login_flg == false}
  {include file="include/footer.tpl" systemRoot=$systemRoot slideMenu='outer'}
{else}
  {include file="include/footer.tpl" systemRoot=$systemRoot slideMenu='inner'}
{/if}