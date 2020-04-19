    <div class="gmenu_area" id="gmenu_area">
      <nav class="gmenu" id="js-gmenu">
        <ul class="gmenu-box">
          {if $gcurrent == 1}
          <li class="gmenu-item gcurrent"><a href="../budget/">家計入力</a></li>
          {else}
          <li class="gmenu-item"><a href="../budget/">家計入力</a></li>
          {/if}
          {if $gcurrent == 2}
          <li class="gmenu-item gcurrent"><a href="../accounting/list">仕訳帳</a></li>
          {else}
          <li class="gmenu-item"><a href="../accounting/list">仕訳帳</a></li>
          {/if}
          {if $gcurrent == 3}
          <li class="gmenu-item gcurrent"><a href="../accounting/calender">カレンダー</a></li>
          {else}
          <li class="gmenu-item"><a href="../accounting/calender">カレンダー</a></li>
          {/if}
          {if $gcurrent == 4}
          <li class="gmenu-item gcurrent"><a href="../accounting/tb">試算表</a></li>
          {else}
          <li class="gmenu-item"><a href="../accounting/tb">試算表</a></li>
          {/if}
          {if $gcurrent == 5}
          <li class="gmenu-item gcurrent"><a href="../import/">一括登録</a></li>
          {else}
          <li class="gmenu-item"><a href="../import/">一括登録</a></li>
          {/if}
          {if $gcurrent == 6}
          <li class="gmenu-item gcurrent"><a href="../edit/">ユーザー設定</a></li>
          {else}
          <li class="gmenu-item"><a href="../edit/">ユーザー設定</a></li>
          {/if}
          {if $gcurrent == 7}
          <li class="gmenu-item gcurrent"><a href="../contact/">お問い合わせ</a></li>
          {else}
          <li class="gmenu-item"><a href="../contact/">お問い合わせ</a></li>
          {/if}
          {if $gcurrent == 8}
          <li class="gmenu-item gcurrent"><a href="../contact/list">お問い合わせ一覧</a></li>
          {else}
          <li class="gmenu-item"><a href="../contact/list">お問い合わせ一覧</a></li>
          {/if}
        </ul>
      </nav>
    </div>