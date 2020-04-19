{if $login_flg == true}
  {include file="include/header.tpl" title='サーバーエラー（500 Internal Server Error）' status='login'}
{else}
  {include file="include/header.tpl" title='サーバーエラー（500 Internal Server Error）' status='no_login_error'}
{/if}
  <div id="container">
    <div class="section">
      <div id="page-title">
        <h3>サーバーエラー（500 Internal Server Error）</h3>
      </div>
        <p>
          サーバーエラーが発生しました。<br />お手数ですが、しばらく時間をおいてから再度ご利用をお願い致します。<br />
          それでも解決しない場合は以下のリンクよりお問い合わせ下さい。<br /><a href="mailto:">お問い合わせはこちら</a>
        </p>
    </div>
  </div>
{if $login_flg == true}
  {include file="include/footer.tpl" status='login'}
{else}
  {include file="include/footer.tpl" status='no_login_error'}
{/if}

