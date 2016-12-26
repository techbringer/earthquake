<footer id="footer">
	<div class="container as-flex space-around padding wrap">
        <% loop $MenuSet('Footer').MenuItems %>
            <a href="$Link" class="$LinkingMode" <% if IsNewWindow %>target="_blank"<% end_if %>>$MenuTitle</a>
        <% end_loop %>
	</div>
</footer>
