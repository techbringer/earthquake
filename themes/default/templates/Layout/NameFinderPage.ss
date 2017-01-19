<!-- this -->
<% if $NameRect %>
<script>
window.name_to_rect = $NameRect;
</script>
<% end_if %>
<div class="container wall">
    <div class="as-flex right-aligned vertical-centred margin-bottom">
        <div class="desc"><p>To see where the name of your loved one is on the Memorial Wall type their name into the search box above.</p></div>
        <% include NameSearcher %>
    </div>
    <div id="the-wall" style="margin-bottom: 20px;"></div>
    <div id="the-street" style="cursor: pointer; background-color: #ccc;">
        <div id="the-vision" style="border: 2px solid red; height: 40px; background-color: #fff; width: 120px; transition: all 0.1s; line-height: 36px; text-align: center; user-select: none; -webkit-user-select: none; cursor: pointer;"></div>
    </div>
    <div class="relative">
        <button id="btn-click-to-left" class="arrow-button">‹</button>
        <button id="btn-click-to-right" class="arrow-button">›</button>
    </div>
    <%-- <div class="as-flex">
        <% loop $People %>
            <a class="the-name" style="margin: 0 0.5em;" href="$Top.Link?name={$Slag}" data-id="$ID" data-slag="$Slag" data-x="$x" data-y="$y" data-width="$width" data-height="$height">$Title</a>
        <% end_loop %>
    </div> --%>
    $Content
</div>
