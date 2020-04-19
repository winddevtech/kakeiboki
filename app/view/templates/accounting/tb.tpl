{include file="include/header.tpl" title='合計残高試算表' systemRoot=$systemRoot gnav='inner'}
{include file="include/subcontents/gmenu.tpl" gcurrent="4"}
    <div id="container">
      <h2 class="title-h2">合計残高試算表</h2>
      {if $tb_obj_list|@count > 0}
      <div class="section">
        <div class="outputdate-container">
          <div class="outputdate-container-inner">
            <form method="get" id="js-submit_closeing">
            出力年月：{$output_date_select_html}
            </form>
          </div>
        </div>
      </div>
      <div class="section">
        <table class="list list-closeing">
          <thead class="list-head">
            <tr>
              <th>借方残高</th>
              <th>借方合計</th>
              <th>勘定科目</th>
              <th>貸方合計</th>
              <th>貸方残高</th>
            </tr>
          </thead>
          <tbody>
          {$debit_balance = 0}
          {$debit_sum = 0}
          {$credit_sum = 0}
          {$credit_balance = 0}
          {foreach from=$tb_obj_list item=row}
            <tr>
              <td>{$row->getDebitBalance()|number_format}</td>
              <td>{$row->getDebitSum()|number_format}</td>
              <td class="tb-item_col">{$row->getSubjectName()}</td>
              <td>{$row->getCreditSum()|number_format}</td>
              <td>{$row->getCreditBalance()|number_format}</td>
            </tr>
            {$debit_balance = $debit_balance + $row->getDebitBalance()}
            {$debit_sum = $debit_sum + $row->getDebitSum()}
            {$credit_sum = $credit_sum + $row->getCreditSum()}
            {$credit_balance = $credit_balance + $row->getCreditBalance()}
          {/foreach}
            <tr>
              <td>{$debit_balance|number_format}</td>
              <td>{$debit_sum|number_format}</td>
              <td class="tb-item_col">合計</td>
              <td>{$credit_sum|number_format}</td>
              <td>{$credit_balance|number_format}</td>
            </tr>
          </tbody>
        </table>
        <div class="btn-row btn-single">
          <input type="button" value="決算書類表示" onclick="location.href='bs_pl?date={$date}'" class="btn" >
        </div>
      </div>
      {else}
      <div class="section">
        <p class="msg-info">登録されている家計簿情報はありません。</p>
      </div>
      {/if}
    </div>
{include file="include/footer.tpl" systemRoot=$systemRoot tb="true" slideMenu='inner'}