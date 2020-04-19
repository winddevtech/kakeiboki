{include file="include/header.tpl" title='入力内容確認' systemRoot=$systemRoot}
    <div id="container">
      <h2 class="title-h2">入力内容確認</h2>
      <ol class="step">
        <li class="step-item step-prog">内容入力</li>
        <li class="step-span step-span-prog">&raquo;</li>
        <li class="step-item step-prog">確認</li>
        <li class="step-span step-span-prog">&raquo;</li>
        <li class="step-item">設定完了</li>
      </ol>
      <div class="col-base col-630">
        <p class="msg-info">以下の内容で家計簿情報を{$edit_mode}します。よろしいですか？</p>
        <div class="section">
          <table class="table-responsive">
            <tbody>
              <tr>
                <th>家計発生日</th>
                <td>{$creation_date|date_format:'%Y/%m/%d'}</td>
              </tr>
              <tr>
                <th>用途</th>
                <td>{$use_item_name}</td>
              </tr>
              <tr>
                <th>金額</th>
                <td>{$price|number_format}</td>
              </tr>
              <tr>
                <th>摘要</th>
                <td>{$summary}</td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="section">
          <small>仕訳結果</small>
          <table class="table-responsive">
            <tbody>
              <tr class="table-tr-item2">
                <th>借方</th>
                <td>{$debit_name}</td>
                <th>貸方</th>
                <td>{$credit_name}</td>
              </tr>
            </tbody>
          </table>
        </div>
        <form method="POST">
          <input type="hidden" name="token" value="{$token}">
          <div class="btn-row btn-multi">
            <input type="button" value="修正" onClick="location.href='./'" class="btn">
            <input type="submit" value="{$edit_mode}" class="btn">
          </div>
        </form>
      </div>
    </div>
{include file="include/footer.tpl" systemRoot=$systemRoot}