{include file="include/header.tpl" title='仕訳帳' systemRoot=$systemRoot gnav='inner' css_font='true'}
{include file="include/subcontents/gmenu.tpl" gcurrent="2"}
    <div id="container">
      <h2 class="title-h2">仕訳帳</h2>
      <div class="section">
        <form method="get" class="form form-search">
          <div class="formcontrol">
            <label class="off-left">期間</label>
            <input type="text" name="start_date" id="start_date"  class="ctl-text form-item-small datepicker" value="{$start_date}" placeholder="開始日">
            ～
            <input type="text" name="end_date" id="end_date" class="ctl-text form-item-small datepicker" value="{$end_date}" placeholder="終了日">
          </div>
          <div class="formcontrol">
            <label for="use_item" class="off-left">用途</label>
            {$subject_select_html}
          </div>
          <div class="btn-row btn-single">
            <button type="submit" class="btn btn-search">検索&nbsp;<i class="fa fa-search"></i></button>
          </div>
        </form>
      </div>
      {if $msg_flg != ''}
      <div class="section">
        <p class="msg-info">選択された家計簿情報を削除しました。</p>
      </div>
      {/if}
      {if $total_page > 0}
      {assign var='param' value='&amp;start_date='|cat:$start_date|cat:'&amp;end_date='|cat:$end_date|cat:'&amp;use_item='|cat:$use_item}
      <div class="section">
        <table id="lb-getlist" class="list list-budget">
          <thead class="list-head">
            <tr>
              <th class="list-col"></th>
              <th class="list-col"><a href="?s=date&amp;o={$order_safe}{$param}">家計発生日{if $sort_safe == 'date'}{$arrow_icon}{/if}</a></th>
              <th class="list-col"><a href="?s=journal_id&amp;o={$order_safe}{$param}">用途{if $sort_safe == 'journal_id'}{$arrow_icon}{/if}</a></th>
              <th class="list-col"><a href="?s=price&amp;o={$order_safe}{$param}">金額{if $sort_safe == 'price'}{$arrow_icon}{/if}</a></th>
              <th class="list-col"><a href="?s=summary&amp;o={$order_safe}{$param}">摘要{if $sort_safe == 'summary'}{$arrow_icon}{/if}</a></th>
              <th class="list-col"></th>
              <th class="list-col"></th>
            </tr>
          </thead>
          <tbody class="accordion list-body">
          {foreach from=$budget_obj_list item=row}
            <tr class="list-row">
              <td class="list-col">{$offset + 1}</td>
              <td class="list-col">{$row->getCreationDate()|date_format:"%Y/%m/%d"}</td>
              <td class="list-col">{$row->getUseItem()}</td>
              <td class="list-col">{$row->getPrice()|number_format}</td>
              <td class="list-col">{$row->getSummary()}</td>
              <td class="list-col"><input type="button" value="変更" onClick="location.href='../budget/?budget_id={$row->getId()}'" class="btn" ></td>
              <td class="list-col"><span class="deleate_budget_id">{$row->getId()}</span><input type="button"  value="削除" class="btn lb-open"></td>
            </tr>
            {$offset = $offset + 1}
          {/foreach}
          </tbody>
        </table>
        <nav class="paginationBox">
          {$pagination_str}
        </nav>
      </div>
      {else}
      <div class="section">
        <p class="msg-info">登録されている家計簿情報はありません。</p>
      </div>
    {/if}
    </div>
{include file="include/footer.tpl" systemRoot=$systemRoot list='true' slideMenu='inner'}