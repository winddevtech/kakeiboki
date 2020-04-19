{include file="include/header.tpl" title='返信状況一覧' status='login'}
    <div id="container">
      <h2 class="title-h2">返信状況一覧</h2>
      <div class="box-large">
        <div class="searchbox">
        <form method="get">
          <label for="search" class="off-left">ユーザ名検索</label>
          <input type="text" name="p" placeholder="ユーザ名検索" class="searchbox-keyword"  id="search" value="{$p}">
          <button type="submit" class="searchbox-btn"><i class="fa fa-search"></i></button>
        </form>
        </div>
      </div>
      {if $total_page > 0}
        {if $p != ''}
          {assign var='param' value='&amp;p='|cat:$p}
        {else}
          {$param = ''}
        {/if}
      <div class="box-large">
        <table class="list list-reply">
          <thead class="list-head">
            <tr>
              <th class="list-col"></th>
              <th class="list-col"><a href="?s=created_at&amp;o={$order_safe}{$param}">登録日
              {if $sort_safe == 'created_at'}{$arrow_icon}{/if}</a></th>
              <th class="list-col"><a href="?s=updated_at&amp;o={$order_safe}{$param}">最新更新日
              {if $sort_safe == 'updated_at'}{$arrow_icon}{/if}</a></th>
              <th class="list-col"><a href="?s=name&amp;o={$order_safe}{$param}">ユーザー
              {if $sort_safe == 'name'}{$arrow_icon}{/if}</a></th>
              <th class="list-col"><a href="?s=rs_id&amp;o={$order_safe}{$param}">ステータス
              {if $sort_safe == 'rs_id'}{$arrow_icon}{/if}</a></th>
              <th class="list-col"></th>
            </tr>
          </thead>
          <tbody class="accordion list-body">
          {foreach from=$reply_obj_list item=row}
            <tr class="list-row">
              <td class="list-col">{$offset + 1}</td>
              <td class="list-col">{$row->getCreatedAt()|date_format:"%Y/%m/%d"}</td>
              <td class="list-col">{if $row->getUpdatedAt() == null}未更新{else}{$row->getUpdatedAt()|date_format:"%Y/%m/%d"}{/if}</td>
              <td class="list-col">{$row->getUserId()}</td>
              <td class="list-col">{if $row->getReplyStatusId() == 1}未返信{else}返信済み{/if}</td>
              <td class="list-col">
                <input type="button" value="返信" onClick="location.href='../timeline/?contact_id={$row->getId()}'" class="btn">
              </td>
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
      <div class="box-large">
        <p class="msg-info">登録されているお問い合わせ情報はありません。</p>
      </div>
      {/if}
    </div>
{include file="include/footer.tpl" status='login' replylist='true'}
