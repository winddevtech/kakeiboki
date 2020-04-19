{include file="include/header.tpl" title='お問い合わせ一覧' systemRoot=$systemRoot gnav='inner' css_font='true'}
{include file="include/subcontents/gmenu.tpl" gcurrent="8"}
    <div id="container">
      <h2 class="title-h2">お問い合わせ一覧</h2>
      {if $total_page > 0}
      <div class="section contactlist">
        <table id="lb-getlist" class="list list-contact">
          <thead class="list-head">
            <tr>
              <th class="list-col"></th>
              <th class="list-col"><a href="?s=created_at&amp;o={$order_safe}">登録日
              {if $sort_safe == 'created_at'}{$arrow_icon}{/if}</a></th>
              <th class="list-col"><a href="?s=rs_id&amp;o={$order_safe}">ステータス
              {if $sort_safe == 'updated_at'}{$arrow_icon}{/if}</a></th>
              <th class="list-col"><a href="?s=category_id&amp;o={$order_safe}">カテゴリ
              {if $sort_safe == 'category_id'}{$arrow_icon}{/if}</a></th>
              <th class="list-col"><a href="?s=context&amp;o={$order_safe}">内容
              {if $sort_safe == 'context'}{$arrow_icon}{/if}</a></th>
              <th class="list-col"></th>
            </tr>
          </thead>
          <tbody class="accordion list-body">
          {foreach from=$contact_obj_list item=row}
            <tr class="list-row">
              <td class="list-col">{$offset + 1}</td>
              <td class="list-col">{$row->getCreatedAt()|date_format:"%Y/%m/%d"}</td>
              <td class="list-col">{if $row->getReplyStatusId() == 1}問い合わせ中{else}回答済み{/if}</td>
              <td class="list-col">{$row->getCategoryName()}</td>
              <td class="list-col">{$row->getContext()}</td>
              <td class="list-col"><input type="button" value="詳細"
                  onClick="location.href='../timeline/?contact_id={$row->getId()}'" class="btn" ></td>
            </tr>
            {$offset = $offset + 1}
          {/foreach}
          </tbody>
        </table>
      </div>
      <nav class="paginationBox">
        {$pagination_str}
      </nav>
    {else}
      <div class="section">
        <p class="msg-info">登録されているお問い合わせ情報はありません。</p>
      </div>
    {/if}
  </div>
{include file="include/footer.tpl" systemRoot=$systemRoot contactlist="true" slideMenu='inner'}