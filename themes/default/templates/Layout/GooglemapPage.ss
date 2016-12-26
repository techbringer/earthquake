<div class="container padding">
    <div class="content">
        $Content
    </div>
</div>
<div class="map">
    <div id="map-wrapper">
        <%--
            DRIVING (Default) indicates standard driving directions using the road network.
            BICYCLING requests bicycling directions via bicycle paths & preferred streets.
            TRANSIT requests directions via public transit routes.
            WALKING requests walking directions via pedestrian paths & sidewalks.
        --%>
        <form id="frm-route" class="hide">
            <label for="txt-origin">From</label>
            <input type="text" id="txt-origin" autocomplete="off" placeholder="origin" />
            <label for="by-driving"><input id="by-driving" name="travel-mode" type="radio" checked value="DRIVING" />Driving</label>
            <label for="by-bike"><input id="by-bike" name="travel-mode" type="radio" value="BICYCLING" />Bicycling</label>
            <label for="by-walking"><input id="by-walking" name="travel-mode" type="radio" value="WALKING" />Walking</label>
            <button type="submit">Route</button>
        </form>
        <div id="map" style="height: 400px;" data-api="$getGoogleAPI('Map')" data-lat="$Latitude" data-lng="$Longitude" data-zoom="$ZoomRate" data-input="txt-origin" data-output="routing-output"></div>
        <div id="routing-output"></div>
    </div>
</div>
