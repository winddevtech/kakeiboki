  <div class="modal-overlay"></div>
  <div class="modal">
    <div class="modal-container" id="js-error-none">
        <div class="modal-contents">
          <p>データの検証が完了しました。<br>OK：<span id="js_import_ok"></span>件、NG：<span id="js_import_ng"></span>件<br>インポートボタンを押すと、OKのデータが登録されます</p>
        </div>
        <div class="btn-row btn-multi">
          <input type="button" value="キャンセル" class="btn" id="js-btn-cancel">
          <input type="submit" value="インポート" class="btn" id="js-btn-import">
        </div>
    </div>
    <div class="modal-container" id="js-error-exist">
      <div class="modal-contents">
        <p id="js-error-msg"></p>
      </div>
      <div class="btn-row btn-single">
        <input type="button" value="戻る" class="btn" id="js-btn-return">
      </div>
    </div>
  </div>
  <div class="toast-panel msg-success">
    <p><span id="js_import_result"></span>件のデータのインポートが完了しました。</p>
  </div>
