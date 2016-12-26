(function($)
{
	$.fn.typeSearch = function(cbf)
    {
        var self        =   $(this),
            callback    =   cbf,
            endpoint    =   $(this).data('endpoint'),
            container   =   $($(this).data('result-container')),
            ajax        =   null;

        $(this).keyup(function(e)
        {
            var search  =   $.trim($(this).val());
            if (ajax) ajax.abort();
            ajax = null;
            if (search.length > 0) {

                ajax    =   $.post(
                                endpoint,
                                {
                                    search: search
                                },
                                function(data)
                                {
                                    ajax = null;
                                    callback(data);
                                }
                            );
            } else if (search.length == 0){
                container.html('');
            }
        });
    };
 })(jQuery);
