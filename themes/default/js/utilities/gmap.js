(function($)
{
	$.fn.gmap = function(cbf)
    {
        var self        =   $(this),
            callback    =   cbf,
            lat         =   self.data('lat').toFloat(),
            lng         =   self.data('lng').toFloat(),
            zoom        =   Math.round(self.data('zoom').toFloat()),
            api         =   self.data('api'),
            input       =   self.data('input'),
            output      =   self.data('output'),
            map         =   new gmap(api, self.attr('id'), [{lat: lat, lng: lng}], zoom, {enabled: true, input_id: input, output_id: output});

        return map;
    };
 })(jQuery);
