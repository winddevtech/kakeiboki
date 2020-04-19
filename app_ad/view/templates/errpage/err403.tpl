{if $login_flg == true}
  {include file="include/header.tpl" title='アクセス禁止（403 Forbidden）' status='login'}
{else}
  {include file="include/header.tpl" title='アクセス禁止（403 Forbidden）' status='no_login_error'}
{/if}
  <div id="container">
    <div class="section">
      <div id="page-title">
        <h3>アクセス禁止（403 Forbidden）</h3>
      </div>
        <p>
          お探しのページはアクセス権限がないか、不正なアクセスにより<br /> 表示することができませんでした。<br />
          お手数ですが、一度ログインをし直してから再度アクセスをお試し下さい。<br /> それでも解決しない場合は以下のリンクよりお問い合わせ下さい。<br />
          <a href="mailto:">お問い合わせはこちら</a>
        </p>
    </div>
  </div>
{if $login_flg == true}
  {include file="include/footer.tpl" status='login'}
{else}
  {include file="include/footer.tpl" status='no_login_error'}
{/if}

