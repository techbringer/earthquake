<div id="block-$ID" class="block block-{$Type2Class}{$ExtraClasses}"{$Styles}<% if $Parallaxing %> data-parallax="scroll" data-image-src="<% if $Image.Width > 3000 %>$Image.SetWidth(3000).URL<% else %>$Image.URL<% end_if %>"<% end_if %>>
	<% if not $hideTitle %>
		<% if $TitleWrapper %>
			<{$TitleWrapper} class="block-title container padding"><span>$Title</span></{$TitleWrapper}>
		<% else %>
			<h2 class="block-title container padding"><span>$Title</span></h2>
		<% end_if %>
	<% end_if %>
	$Layout
	<% if $frontendEditable %>
	<div class="frontend-block-edit-wrapper" style="position: absolute; top: 0; right: 0;">
		<a class="block-edit-button" href="/admin/blocks/Block/EditForm/field/Block/item/{$ID}/edit" target="_blank">Edit</a>
	</div>
	<% end_if %>
</div>
