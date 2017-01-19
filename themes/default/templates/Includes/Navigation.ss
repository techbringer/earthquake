<nav id="main_nav">
	<ul class="main-nav as-flex space-between">
		<% loop Menu(1) %>
			<li class="<% if LinkOrCurrent = current || $LinkOrSection = section %>current<% end_if %><% if Children %> expandable<% end_if %>">
				<a href="$Link" class="<% if LinkOrCurrent = current || $LinkOrSection = section %>current<% end_if %>">$MenuTitle.XML</a>
				<% if Children %>
				<ul class="children">
					<% loop Children %>
						<li class="<% if LinkOrCurrent = current %>current<% end_if %>"><a href="$Link" class="<% if LinkOrCurrent = current %>current<% end_if %>">$MenuTitle.XML</a></li>
					<% end_loop %>
				</ul>
				<% end_if %>
			</li>
		<% end_loop %>
	</ul>
    <button id="m-menu" class="icon-menu">Menu</button>
</nav>
