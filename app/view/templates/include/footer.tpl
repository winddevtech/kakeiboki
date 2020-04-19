    <footer id="footer">
      <small>&copy; 2017 webdiv</small>
    </footer>
  </div>
  {if $list|default:false == true}
    {include file="include/subcontents/list.tpl"}
  {/if}
  <nav id="slideMenu">
    <ul>
      {if $toppage|default:false == 'true'}
      <li><a href="{$systemRoot}/signup/">新規登録</a></li>
      {/if}
      {if $slideMenu|default:false == 'outer'}
      <li><a href="{$systemRoot}/signup/">新規登録</a></li>
      <li><a href="{$systemRoot}/">ログイン</a></li>
      {elseif $slideMenu|default:false == 'inner'}
      <li><a href="{$systemRoot}/budget/">家計入力</a></li>
      <li><a href="{$systemRoot}/accounting/list">仕訳帳</a></li>
      <li><a href="{$systemRoot}/accounting/calender">カレンダー</a></li>
      <li><a href="{$systemRoot}/accounting/tb">試算表</a></li>
      <li><a href="{$systemRoot}/import/">一括登録</a></li>
      <li><a href="{$systemRoot}/edit/">ユーザー設定</a></li>
      <li><a href="{$systemRoot}/contact/">お問い合わせ</a></li>
      <li><a href="{$systemRoot}/contact/list">お問い合わせ一覧</a></li>
      <li><a href="{$systemRoot}/login/logout/">ログアウト</a></li>
      <li><a href="{$systemRoot}/resign/">退会</a></li>
      {/if}
      <li><a href="{$systemRoot}/#">ヘルプ</a></li>
    </ul>
  </nav>
  {if $import|default:false == true}
    {include file="include/subcontents/import.tpl"}
  {/if}
  <script src="{$systemRoot}/assets/lib/jquery2.2.4.min.js"></script>
  <script src="{$systemRoot}/assets/js/common.js"></script>
  {if $toppage|default:false == 'true'}
  <script src="{$systemRoot}/assets/js/checker.js"></script>
  <script src="{$systemRoot}/assets/js/user.js"></script>
  {/if}
  {if $user|default:false == true}
  <script src="{$systemRoot}/assets/js/checker.js"></script>
  <script src="{$systemRoot}/assets/js/user.js"></script>
  <script src="{$systemRoot}/assets/js/icon.js"></script>
  {/if}
  {if $budget|default:false == true}
  <script src="{$systemRoot}/assets/js/checker.js"></script>
  <script src="{$systemRoot}/assets/js/budget.js"></script>
  <script src="{$systemRoot}/assets/lib/jquery-ui/jquery-ui.min.js"></script>
  <script>
    $(function() {
      $('.datepicker').datepicker({
        dateFormat : 'yy/mm/dd',
        showOn : 'both',
        buttonText: '<i class="fa fa-calendar" aria-hidden="true"></i>'
      });
    });
  </script>
  {/if}
  {if $contact|default:false == true}
  <script src="{$systemRoot}/assets/js/checker.js"></script>
  <script src="{$systemRoot}/assets/js/contact.js"></script>
  <script src="{$systemRoot}/assets/js/counter.js"></script>
  {/if}
  {if $import|default:false == true}
  <script src="{$systemRoot}/assets/js/checker.js"></script>
  <script src="{$systemRoot}/assets/js/import.js"></script>
  {/if}
  {if $list|default:false == true}
  <script src="{$systemRoot}/assets/js/lightbox.js"></script>
  <script src="{$systemRoot}/assets/js/accordion.js"></script>
  <script src="{$systemRoot}/assets/lib/jquery-ui/jquery-ui.min.js"></script>
  <script>
    $(function() {
      $('.datepicker').datepicker({
        dateFormat : 'yy/mm/dd',
        showOn : 'both',
        buttonText: '<i class="fa fa-calendar" aria-hidden="true"></i>'
      });
    });
  </script>
  {/if}
  {if $contactlist|default:false == true}
  <script src="{$systemRoot}/assets/js/accordion.js"></script>
  {/if}
  {if $bs_pl|default:false == true}
  <script src="{$systemRoot}/assets/js/closeing.js"></script>
  <script src="{$systemRoot}/assets/js/tab.js"></script>
  {/if}
  {if $calender|default:false == true}
  <script src="{$systemRoot}/assets/js/calender.js"></script>
  {/if}
  {if $tb|default:false == true}
  <script src="{$systemRoot}/assets/js/closeing.js"></script>
  {/if}
  {if $timeline|default:false == true}
  <script src="{$systemRoot}/assets/js/timeline.js"></script>
  {/if}
  {if $auth|default:false == true}
  <script src="{$systemRoot}/assets/js/checker.js"></script>
  <script src="{$systemRoot}/assets/js/user.js"></script>
  {/if}
</body>
</html>