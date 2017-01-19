<header id="header">
    <div class="container main-nav as-flex right-aligned">
        <div class="li lang-wrapper">
            <a id="btn-language" href="#">Choose Language <span class="icon-down-open-mini"></span></a>
            <% include Translator %>
        </div>
    </div>
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
