{include file="include/header.tpl" title='家計簿情報入力フォーム' systemRoot=$systemRoot gnav='inner' css_font='true'}
{include file="include/subcontents/gmenu.tpl" gcurrent="1"}
    <div id="container">
      <h2 class="title-h2">家計簿情報入力フォーム</h2>
      <ol class="step">
        <li class="step-item step-prog">内容入力</li>
        <li class="step-span step-span-prog">&raquo;</li>
        <li class="step-item">確認</li>
        <li class="step-span step-span-prog">&raquo;</li>
        <li class="step-item">設定完了</li>
      </ol>
      <div class="col-base col-630">
        <form method="POST">
          <small class="annotation">※全項目入力必須です</small>
          <fieldset>
            <table class="table-responsive">
              <tbody>
                <tr>
                  <th><label for="creation_date">家計発生日<span>（yyyy/mm/dd形式）</span></label></th>
                  <td><input type="text" name="creation_date" class="ctl-text form-item-small datepicker" id="creation_date" value="{$creation_date|date_format:'%Y/%m/%d'}" >{$err_creation_date}</td>
                </tr>
                <tr>
                  <th><label for="use_item_id">用途</label></th>
                  <td>{$use_item_select_html}{$err_use_item_id}</td>
                </tr>
                <tr>
                  <th><label for="price">金額<span>（1千万まで入力可）</span></label></th>
                  <td><input type="text" name="price" class="ctl-text form-item-large" id="price" placeholder="金額を入力して下さい。"  value="{$price}">{$err_price}</td>
                </tr>
                <tr>
                  <th><label for="summary">摘要<span>（30文字以内）</span></label></th>
                  <td><input type="text"  name="summary" class="ctl-text form-item-large" id="summary" placeholder="摘要を入力して下さい。" value="{$summary}" >{$err_summary}</td>
                </tr>
              </tbody>
            </table>
            {if $budget_id != ''}
            <input type="hidden" name="budget_id" value="{$budget_id}">
            {/if}
            <input type="hidden" name="token" value="{$token}">
          </fieldset>
          <div class="btn-row btn-single">
            <input type="submit" value="確認" class="btn" id="js-submit">
          </div>
        </form>
      </div>
    </div>
{include file="include/footer.tpl" systemRoot=$systemRoot budget='true' slideMenu='inner'}