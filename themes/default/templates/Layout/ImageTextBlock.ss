<div class="as-flex wrap">
    <div class="text<% if $SplitContent %> split<% end_if %>">
        <h2 class="block-title">$Title</h2>
        <div class="block-content">$Content</div>
        <% if $ExtraContent %>
            <div class="block-extra-content">$ExtraContent</div>
        <% end_if %>
    </div>
    <div class="image<% if $ImageFullHeight %> full-height<% end_if %>"<% if $ImageFullHeight %> data-padding-top="$PaddingTop"<% end_if %> style="background-image: url($Image.URL);<% if $Title == 'Brochure' || $Title == '小册子' || $Title == '手冊' || $Title == 'ご案内冊子' || $Title == '안내 책자' || $Title == 'แผ่นพับ' %> min-height: 400px;<% end_if %>"><% if $Title == 'Brochure' || $Title == '小册子' || $Title == '手冊' || $Title == 'ご案内冊子' || $Title == '안내 책자' || $Title == 'แผ่นพับ' %><div id="brochure-cover"><img src="/themes/default/images/brochure.png" width="1000" height="1000" /></div><% end_if %></div>
</div>
