<% if Translations %>
<ul class="translations">
<% loop Translations.Sort('Locale', 'ASC') %>
    <li class="$Locale.RFC1766">
        <a<% if $Locale.RFC1766 == $Top.ContentLocale %> class="active"<% end_if %> href="$Link" hreflang="$Locale.RFC1766" title="$Title"><% if $Locale.NativeName == 'English (NZ)' %>English<% else %>$Locale.NativeName<% end_if %></a>
    </li>
<% end_loop %>
</ul>
<% end_if %>
