<header id="header">
	<div class="container padding">
		<a href="/" id="logo" rel="start">
        <% if $SiteConfig.Title == 'Oi Manawa Canterbury earthquake national memorial' %>
            Oi Manawa <br />Canterbury earthquake national memorial
        <% else %>
            $SiteConfig.Title
        <% end_if %>
        </a>
		<% include Navigation %>
	</div>
</header>
