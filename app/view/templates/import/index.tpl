{include file="include/header.tpl" title='家計簿情報インポート設定' systemRoot=$systemRoot gnav='inner' css_font='true'}
{include file="include/subcontents/gmenu.tpl" gcurrent="5"}
    <div id="container">
      <h2 class="title-h2">家計簿情報インポート設定</h2>
      <div class="col-base col-630">
        <form method="POST" enctype="multipart/form-data" class="form form-import"  id="form-import" action="confirm">
          <p>インポートするCSVファイルをドラッグ＆ドロップ、<br />またはCSVファイルを選択してくさい。</p>
          <div class="form-control">
            <i class="fa fa-upload form-upload-btn" aria-hidden="true"><input type="file" name="import_file" id="js-import_file"></i><span id="filename">ファイルを選択して下さい。</span>
          </div>
          <div class="form-control">
            <label for="headerflg"><input type="hidden" name="headerflg" value="0">
            <input type="checkbox" name="headerflg" id="headerflg" value="1" class="ctl-checkbox">
              一行目をヘッダ行として処理する</label>
          </div>
          <input type="hidden" name="token" value="{$token}" id="token">
          <div class="btn-row btn-single">
            <input type="submit" value="データ検証" class="btn" id="js-submit">
          </div>
        </form>
        <div class="download">
          <a href="../download/?id=1">テンプレートファイルを利用する</a>
        </div>
      </div>
    </div>
{include file="include/footer.tpl" systemRoot=$systemRoot import='true' slideMenu='inner'}
