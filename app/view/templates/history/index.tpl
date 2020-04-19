{include file="include/header.tpl" title='更新履歴' systemRoot=$systemRoot gnav='outer'}
    <div id="container">
      <h2 class="title-h2">更新履歴</h2>
      <div class="col-base col-720">
      {if $totalPage > 0}
        <table class="list list-version">
          <thead class="list-head">
            <tr>
              <th class="list-col">バージョン</th>
              <th class="list-col">更新日</th>
              <th class="list-col">更新内容</th>
            </tr>
          </thead>
          <tbody>
            {foreach from=$historyList item=row}
            <tr>
              <td>{$row->getNumber()}</td>
              <td>{$row->getCreatedAt()|date_format:"%Y/%m/%d"}</td>
              <td>{$row->getContext()}</td>
            </tr>
          {/foreach}
          </tbody>
        </table>
      {else}
        <p class="msg-info">バージョン履歴情報はありません。</p>
      {/if}
      </div>
    </div>
{include file="include/footer.tpl" systemRoot=$systemRoot slideMenu='outer'}