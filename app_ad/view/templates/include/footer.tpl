    <footer id="footer">
      <small>&copy; 2017 webdiv</small>
    </footer>
  </div>
  <nav id="slideMenu">
    <ul>
      {if $status|default:false == 'login'}
      <li class="gnav-item"><a href="../reply/list">返信一覧</a></li>
      <li class="gnav-item"><a href="../login/logout">ログアウト</a></li>
      {elseif $status|default:false == 'no_login_error'}
      <li><a href="../">ログイン</a></li>
      {/if}
      <li><a href="#">ヘルプ</a></li>
    </ul>
  </nav>
  <script src="/kakeiboki/app/assets/lib/jquery2.2.4.min.js"></script>
  <script src="/kakeiboki/app/assets/js/common.js"></script>
  {if $replylist|default:false == true}
  <script src="/kakeiboki/app/assets/js/accordion.js"></script>
  {/if}
  {if $timeline|default:false == true}
  <script src="/kakeiboki/app/assets/js/timeline.js"></script>
  {/if}
</body>
</html>