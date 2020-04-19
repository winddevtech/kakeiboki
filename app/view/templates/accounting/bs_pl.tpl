{include file="include/header.tpl" title='賃借対照表/損益計算書' systemRoot=$systemRoot gnav='inner'}
{include file="include/subcontents/gmenu.tpl" gcurrent="0"}
    <div id="container">
      <h2 class="title-h2">賃借対照表/損益計算書</h2>
      <div class="section">
      {if $bs_pl_obj_list|@count > 0}
        <div class="outputdate-container">
          <div class="outputdate-container-inner">
            <form method="get" id="js-submit_closeing">
              出力年月：{$output_date_select_html}
            </form>
          </div>
        </div>
        <div id="js-tab" class="tab">
          <div id="js-tab-menu" class="tab-menu">
            <h3 class="tab-menu__item">
              <a href="javasclipt: void(0);">賃借対照表</a>
            </h3>
            <h3 class="tab-menu__item">
              <a href="javasclipt: void(0);">損益計算書</a>
            </h3>
          </div>
          <div class="tabBox">
            <div class="financial">
              {$sum = 0}
              {$sum_debit = 0}
              {$sum_credit = 0}
              {$sum_result = ''}
              <ul class="financial-title">
                <li>資産</li>
                <li>金額</li>
                <li>負債</li>
                <li>金額</li>
              </ul>
              <div class="financial-listbox">
                <dl class="financial-list">
                {foreach from=$bs_pl_obj_list item=row}
                  {if $row->getClassId() == 2}
                  <dt>{$row->getSubjectName()}</dt>
                  <dd>{$row->getMoney()|number_format}</dd>
                    {$sum_debit = $sum_debit + $row->getMoney()}
                  {/if}
                {/foreach}
                </dl>
                <dl class="financial-list">
                {foreach from=$bs_pl_obj_list item=row}
                  {if $row->getClassId() == 3}
                  <dt>{$row->getSubjectName()}</dt>
                  <dd>{$row->getMoney()|number_format}</dd>
                    {$sum_credit = $sum_credit + $row->getMoney()}
                  {/if}
                {/foreach}
                </dl>
              </div>
              {if $sum_debit >= $sum_credit}
                {$sum = $sum_debit - $sum_credit}
                {$sum_result = '黒字'}
              {else}
                {$sum = $sum_credit - $sum_debit}
                {$sum_result = '赤字'}
              {/if}
              <div class="outputResult">{$date}末日時点では{$sum|number_format}円の{$sum_result}でした。</div>
            </div>
          </div>
          <div class="tabBox">
            <div class="financial">
              {$sum = 0}
              {$sum_debit = 0}
              {$sum_credit = 0}
              {$sum_result = ''}
              <ul class="financial-title">
                <li>費用</li>
                <li>金額</li>
                <li>収益</li>
                <li>金額</li>
              </ul>
              <div class="financial-listbox">
                <dl class="financial-list">
                {foreach from=$bs_pl_obj_list item=row}
                  {if $row->getClassId() == 1}
                  <dt>{$row->getSubjectName()}</dt>
                  <dd>{$row->getMoney()|number_format}</dd>
                    {$sum_debit = $sum_debit + $row->getMoney()}
                  {/if}
                {/foreach}
                </dl>
                <dl class="financial-list">
                {foreach from=$bs_pl_obj_list item=row}
                  {if $row->getClassId() == 4}
                  <dt>{$row->getSubjectName()}</dt>
                  <dd>{$row->getMoney()|number_format}</dd>
                    {$sum_credit = $sum_credit + $row->getMoney()}
                  {/if}
                {/foreach}
                </dl>
              </div>
              {if $sum_debit >= $sum_credit}
                {$sum = $sum_debit - $sum_credit}
                {$sum_result = '赤字'}
              {else}
                {$sum = $sum_credit - $sum_debit}
                {$sum_result = '黒字'}
              {/if}
              <div class="outputResult">{$date}初日～末日の間は{$sum|number_format}円の{$sum_result}でした。</div>
            </div>
          </div>
        </div>
        {else}
        <div class="section">
          <p class="msg-info">登録されている家計簿情報はありません。</p>
        </div>
        {/if}
      </div>
    </div>
{include file="include/footer.tpl" systemRoot=$systemRoot bs_pl='true' slideMenu='inner'}