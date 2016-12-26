<div class="as-flex wrap">
    <div class="text">
        <h2 class="block-title">$Title</h2>
        <div class="block-content">$Content</div>
    </div>
    <div class="image" style="background-image: url($Image.URL);<% if $Title == 'Brochure' %> min-height: 400px;<% end_if %>"><% if $Title == 'Brochure' %><div id="brochure-cover"><img src="/themes/default/images/brochure.png" width="1000" height="1000" /></div><% end_if %></div>
</div>
