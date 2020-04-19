{include file="include/header.tpl" title='お問い合わせフォーム' systemRoot=$systemRoot gnav='inner'}
{include file="include/subcontents/gmenu.tpl" gcurrent="7"}
    <div id="container">
      <h2 class="title-h2">お問い合わせフォーム</h2>
      <ol class="step">
        <li class="step-item step-prog">内容入力</li>
        <li class="step-span">&raquo;</li>
        <li class="step-item ">確認</li>
        <li class="step-span">&raquo;</li>
        <li class="step-item">送信完了</li>
      </ol>
      <div class="col-base col-630">
        <form method="POST">
          <small class="annotation">※全項目入力必須です</small>
          <fieldset>
            <table class="table-responsive">
              <tbody>
                <tr>
                  <th>
                    <label for="js-category_id">お問い合わせカテゴリ</label>
                  </th>
                  <td>{$category_id_select}{$err_category_id}</td>
                </tr>
                <tr>
                  <th>
                    <label for="js-context">お問い合わせ内容</label>
                  </th>
                  <td><textarea rows="10" placeholder="お問い合わせ内容を入力してください。" name="context" id="js-context" class="ctl-textarea">{$context}</textarea>
                  {$err_context}<div class="counterRow">あと<span id="js-counter_context">1000</span>文字入力できます。</div></td>
                </tr>
              </tbody>
            </table>
            <input type="hidden" name="token" value="{$token}" >
          </fieldset>
          <div class="btn-row btn-single">
            <input type="submit" value="確認" class="btn" id="js-submit" >
          </div>
        </form>
      </div>
    </div>
{include file="include/footer.tpl" systemRoot=$systemRoot contact='true' slideMenu='inner'}