<% if $Menu(2) %>
    <ul class="container secondary-menu as-flex">
    <% loop Menu(2) %>
        <li class="<% if LinkOrCurrent = current %>current<% end_if %>"><a href="$Link" class="<% if LinkOrCurrent = current %>current<% end_if %>">$MenuTitle.XML</a></li>
    <% end_loop %>
    </ul>
<% end_if %>
