{include file="include/header.tpl" title='入力内容確認' systemRoot=$systemRoot}
    <div id="container">
      <h2 class="title-h2">入力内容確認</h2>
      <ol class="step">
        <li class="step-item step-prog">内容入力</li>
        <li class="step-span step-span-prog">&raquo;</li>
        <li class="step-item step-prog">確認</li>
        <li class="step-span">&raquo;</li>
        <li class="step-item">送信完了</li>
      </ol>
      <div class="col-base col-630">
        <p class="msg-info">以下の内容を送信します。よろしいですか？</p>
        <table class="table-responsive">
          <tbody>
            <tr>
              <th>お問い合わせカテゴリ</th>
              <td>{$category_value}</td>
            </tr>
            <tr>
              <th>お問い合わせ内容</th>
              <td>{$context}</td>
            </tr>
          </tbody>
        </table>
        <form method="POST">
          <input type="hidden" name="token" value="{$token}" />
          <div class="btn-row btn-multi">
            <input type="button" value="修正" onClick="location.href='./'" class="btn" />
            <input type="submit" value="送信" class="btn" />
          </div>
        </form>
      </div>
    </div>
{include file="include/footer.tpl" systemRoot=$systemRoot}