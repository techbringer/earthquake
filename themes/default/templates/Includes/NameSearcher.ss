<div class="name-searcher">
    <input type="text" class="text" id="name-searcher" data-endpoint="/name-search" data-result-container="#found-names" placeholder="<% if $Top.ContentLocale == 'en-NZ' %>Search<% end_if %><% if $Top.ContentLocale == 'ja-JP' %>検索<% end_if %><% if $Top.ContentLocale == 'ko-KR' %>수색<% end_if %><% if $Top.ContentLocale == 'th-TH' %>ค้นหา<% end_if %><% if $Top.ContentLocale == 'zh-Hans' %>搜索<% end_if %><% if $Top.ContentLocale == 'zh-Hant' %>檢索<% end_if %>" />
    <ul id="found-names"></ul>
</div>
