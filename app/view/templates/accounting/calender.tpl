{include file="include/header.tpl" title='カレンダー型仕訳帳' systemRoot=$systemRoot gnav='inner'}
{include file="include/subcontents/gmenu.tpl" gcurrent="3"}
    <div id="container">
      <h2 class="title-h2">カレンダー型仕訳帳</h2>
      {if $output_date_select_html != ''}
      <div class="section">
        <div class="outputdate-container">
          <div class="outputdate-container-inner">
            出力年月：
            {$output_date_select_html}
          </div>
        </div>
      </div>
      <div class="section">
        <div class="calendar" id="calendar-container">
          <div class="loadbox"><img src="../assets/images/loading.gif" class="loadbox-image" alt=""></div>
        </div>
      </div>
      {else}
      <div class="section">
        <p class="msg-info">登録されている家計簿情報はありません。</p>
      </div>
      {/if}
    </div>
{include file="include/footer.tpl" systemRoot=$systemRoot calender="true" slideMenu='inner'}