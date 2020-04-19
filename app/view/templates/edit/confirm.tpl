{include file="include/header.tpl" title='ユーザー情報変更内容確認' systemRoot=$systemRoot}
    <div id="container">
      <h2 class="title-h2">ユーザー情報変更内容確認</h2>
      <ol class="step">
        <li class="step-item step-prog">内容入力</li>
        <li class="step-span step-span-prog">&raquo;</li>
        <li class="step-item step-prog">確認</li>
        <li class="step-span">&raquo;</li>
        <li class="step-item">変更完了</li>
      </ol>
      <div class="col-base col-630">
        <p class="msg-info">以下の内容でユーザー情報を変更します。よろしいですか？</p>
        <table class="table-responsive">
          <tbody>
            <tr>
              <th>ユーザー名</th>
              <td>{$user_name}</td>
            </tr>
            <tr>
              <th>Email</th>
              <td>{$email}</td>
            </tr>
            <tr>
              <th>パスワード</th>
              <td>{$password}</td>
            </tr>
            <tr>
              <th>一覧表示件数</th>
              <td>{$display_count}件&nbsp;/1ページ</td>
            </tr>
            <tr>
              <th>アイコン画像</th>
              <td><div class="icon-img"><img src="{$icon_img}" width="50" height="50" class="icon" alt="{$user_name}"></div></td>
            </tr>
          </tbody>
        </table>
        <form method="POST">
          <input type="hidden" name="token" value="{$token}" />
          <div class="btn-row btn-multi">
            <input type="button" value="修正" onClick="location.href='./'" class="btn" >
            <input type="submit" value="変更"  class="btn" >
          </div>
        </form>
      </div>
    </div>
{include file="include/footer.tpl" systemRoot=$systemRoot}
