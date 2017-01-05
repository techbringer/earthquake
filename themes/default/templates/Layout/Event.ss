<div class="event">
    <div class="text">
        <div class="container padding">
            <h3 class="event-title">$Date.Month $Date.Year</h3>
            <div class="event-content">$Content</div>
        </div>
    </div>
    <div class="parallax-window block block-parallaxing-block" style="min-height: $MinHeight; background-image: url(<% if $Image.Width > 3000 %>$Image.SetWidth(3000).URL<% else %>$Image.URL<% end_if %>);"<% if $Parallaxing %> data-parallax="scroll" data-image-src="<% if $Image.Width > 3000 %>$Image.SetWidth(3000).URL<% else %>$Image.URL<% end_if %>"<% end_if %>>
    </div>
</div>
