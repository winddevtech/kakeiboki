{include file="include/header.tpl" title='お問い合わせタイムライン' systemRoot=$systemRoot gnav='inner' css_font='true'}
{include file="include/subcontents/gmenu.tpl" gcurrent="0"}
   <div id="container">
      <h2 class="title-h2">お問い合わせタイムライン</h2>
      <div class="section">
        <div id="js-timeline-head" class="timeline-head">
          <p class="timeline-head__label">【カテゴリ】</p>
          <p class="timeline-head__category" id="js-category_name"></p>
        </div>
      </div>
      <div class="section">
        <div class="ballon" id="js-ballon">
        </div>
        <div id="js-timeline-btn" class="timeline-btn"><input type="submit" value="内容入力" class="btn btn-middle" id="js-form_open"></div>
      </div>
    </div>
    <input type="hidden" name="contact_id" id="js-contact_id" value="{$contact_id}">
    <input type="hidden" name="token" value="" id="token">
{include file="include/footer.tpl" systemRoot=$systemRoot timeline='true' slideMenu='inner'}