window.totalImages = 21;
window.wall = null;
window.wallX = 0;
window.doodle = false;
window.personID = null;
window.theName = null;

window.vision_sets = {
    unscaled:   {
                    canvas_width: 21000,
                    canvas_height: 323,
                    panel_width: 1000,
                    scale_factor: 1,
                    directory: '/themes/default/images/panels/'
                },
    scaled:     {
                    canvas_width: 8400,
                    canvas_height: 129,
                    panel_width: 400,
                    scale_factor: 0.4,
                    directory: '/themes/default/images/resized/'
                }
};

/**
 * change window.vision_sets.scaled to window.vision_sets.unscaled,
 * if you want to display things in their original size
 **/
window.canvas_width     =   window.vision_sets.scaled.canvas_width;
window.canvas_height    =   window.vision_sets.scaled.canvas_height;
window.panel_width      =   window.vision_sets.scaled.panel_width;
window.scale_factor     =   window.vision_sets.scaled.scale_factor;
window.dir              =   window.vision_sets.scaled.directory;

window.addEventListener('popstate', function(e)
{
    window.name_to_rect = e.state;
    $(window).resize();
});

$(document).ready(function(e)
{
    $('#m-menu').click(function(e)
    {
        e.preventDefault();
        e.stopPropagation();
        $('.main-nav').toggleClass('open');
        $('#main_nav-sticky-wrapper').height($('#main_nav').outerHeight());
    });

    $('iframe').each(function(i, el)
    {
        $(this).parent().addClass('iframe-container');
    });

    $('.main-nav a').mouseenter(function(e)
    {
        $('#main_nav-sticky-wrapper').height($('#main_nav').outerHeight());
    });

    if (!isMobile) {
        $('body').addClass('not-mobile');
    }

    $('#main_nav').sticky().on('sticky-start', function()
    {

    }).on('sticky-end', function()
    {
        console.log("Ended");
    });

    $('#btn-language').click(function(e)
    {
        e.preventDefault();
    });
    if ($('body').hasClass('page-type-name-finder-page')) {
        var loader  =   new Sprite(window.canvas_width, window.canvas_height),
            canvas  =   new Sprite($(window).width(), window.canvas_height),
            url     =   location.pathname + (QueryString && QueryString.name ? ('?name=' + QueryString.name) : '');

        history.replaceState(window.name_to_rect, document.title, url);
        window.wall =   canvas;
        for (var i = 1; i <= 21; i++) {
            drawImage(loader, window.dir + i + '.jpg', i);
        }

        $('#the-wall').append($(canvas.canvas));

        // beingLazy(loader.canvas);
    }

    if ($('#map').length > 0) {
        var map = $('#map').gmap();
        $('#frm-route').submit(function(e)
        {
            e.preventDefault();
            e.stopPropagation();
            var src     =   null,
                dest    =   new google.maps.LatLng($('#map').data('lat'), $('#map').data('lng')),
                mode    =   $(this).find('input[name="travel-mode"]:checked').val();
            if ($.trim($('#txt-origin').val()).length == 0) {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function(geoloc)
                    {
                        src = new google.maps.LatLng(geoloc.coords.latitude, geoloc.coords.longitude);
                        map.route(src, dest, mode);
                    }, function(error)
                    {
                        alert('Your browser doesn\'t allow us to locate your location, so you will have to manually input the address.');
                    });
                } else {
                    alert('Please input the address');
                }
            } else {
                src = new google.maps.LatLng($('#txt-origin').data('lat'), $('#txt-origin').data('lng'));
                map.route(src, dest, mode);
            }
        });
    }

    $('#name-searcher').typeSearch(function(data)
    {
        try {
            data = JSON.parse(data);
            if (typeof(data) === 'object' && data.length > 0) {
                $('#found-names').html('');
                data.forEach(function(item)
                {
                    var li  =   $('<li />'),
                        a   =   $('<a />');
                    a.addClass('the-name').attr('href', '/visit-us/names-on-the-memorial/?name=' + item.slag).css('text-transform', 'capitalize');
                    a.data('slag', item.slag);
                    a.data('x', item.rect.x);
                    a.data('y', item.rect.y);
                    a.data('width', item.rect.width);
                    a.data('height', item.rect.height);
                    a.html(item.title);
                    li.append(a).appendTo($('#found-names'));
                    if (location.pathname == '/visit-us/names-on-the-memorial/' || location.pathname == '/visit-us/names-on-the-memorial') {
                        a.click(function(e)
                        {
                            e.preventDefault();
                            var me = $(this);
                            window.name_to_rect = {
                                x: me.data('x'),
                                y: me.data('y'),
                                width: me.data('width'),
                                height: me.data('height')
                            };
                            $(window).resize();
                            history.pushState(window.name_to_rect, me.html(), location.pathname + '?name=' + me.data('slag'));
                            $('#name-searcher').val('');
                            $('#found-names').html('');
                        });
                    }
                });
            } else if (data.length == 0) {
                $('#found-names').html('<li>- no result -</li>');
            }
        } catch(e) {
            trace(e);
        }
    });

});

// function beingLazy()
// {
//     $('.the-name').click(function(e)
//     {
//         e.preventDefault();
//         if (window.doodle) {
//             window.personID = $(this).data('id');
//             window.theName = $(this).html();
//             trace(window.personID);
//         } else {
//             var self = $(this);
//             window.name_to_rect = {
//                 x: self.data('x'),
//                 y: self.data('y'),
//                 width: self.data('width'),
//                 height: self.data('height')
//             };
//             $(window).resize();
//             history.pushState(window.name_to_rect, self.html(), location.pathname + '?name=' + self.data('slag'));
//         }
//     });
// }

function drawImage(canvas, src, i)
{
    var img = new Image();
    img.onload = function()
    {
        canvas.graphics.drawImage(img, (i-1) * window.panel_width, 0);
        window.totalImages--;
        if (window.totalImages == 0) {
            //window.wall.graphics.drawImage(, 0, 0);
            InitWall(canvas.canvas);
            InitVision(canvas.canvas);
        }
    };
    img.src = src;
}

function InitWall(canvas)
{
    window.wall.graphics.drawImage(canvas, 0, 0);
    var r   =   1,
        x   =   0;
    $(window).resize(function(e)
    {
        r = $('#the-wall').width() / (window.canvas_width - $('#the-wall').width());
        $('#the-vision').css('transform', 'translateX(0)');
        window.wall.width($('#the-wall').width());
        window.wallX = x / -r;

        if (window.name_to_rect) {
            if (window.name_to_rect.x > $('#the-wall').outerWidth() * 0.5 ) {
                window.wallX = window.name_to_rect.x * -window.scale_factor + $('#the-wall').outerWidth() * 0.5 - window.name_to_rect.width * window.scale_factor * 0.5;

                if (window.canvas_width + window.wallX < $('#the-wall').outerWidth()) {
                    window.wallX = $('#the-wall').outerWidth() - window.canvas_width;
                }

                if (window.wallX > 0) {
                    window.wallX = 0;
                }

                var n = (window.wallX / (window.canvas_width - $('#the-wall').outerWidth())) * ($('#the-street').outerWidth() - $('#the-vision').outerWidth());
                $('#the-vision').css('transform', 'translateX(' + Math.abs(n) + 'px)');
            }
        }

        drawRect(canvas);
    }).resize();

    if (window.doodle) {
        var canDrag =   false,
            px      =   0,
            py      =   0,
            tx      =   0,
            ty      =   0;

        window.wall.canvas.addEventListener('mousedown', function(e)
        {
            canDrag = true;
            px = e.pageX;
            py = e.pageY;
            drawRect(canvas);
        }, false);

        window.addEventListener('mousemove', function(e)
        {
            if (!canDrag) return;
            tx = e.pageX - px;
            ty = e.pageY - py;
            window.wall.clear();
            window.wall.graphics.drawImage(canvas, window.wallX, 0);
            window.wall.graphics.beginPath();
            window.wall.graphics.rect(px - $(window.wall.canvas).offset().left, py - $(window.wall.canvas).offset().top,tx,ty);
            window.wall.graphics.stroke();
            window.wall.graphics.closePath();
        }, false);

        window.addEventListener('mouseup', function(e)
        {
            if (!canDrag) return;
            canDrag = false;
            if (!window.personID) return;
            //trace(Math.floor(px - $(window.wall.canvas).offset().left - window.wallX) + ', ' + Math.abs(tx));

            var rowNum  =   1,
                lcY     =   Math.floor(py - $(window.wall.canvas).offset().top);

            if (lcY >= 80) {
                rowNum = 2;
            }

            if (lcY >= 140) {
                rowNum = 3;
            }

            if (lcY >= 200) {
                rowNum = 4;
            }

            if (confirm(window.theName + '\n x: ' + Math.floor(px - $(window.wall.canvas).offset().left - window.wallX) + ', width: ' + Math.abs(tx) + ', row: ' + rowNum )) {
                var dataTo  =   {
                                    id: window.personID,
                                    x: Math.floor(px - $(window.wall.canvas).offset().left - window.wallX),
                                    width: Math.abs(tx),
                                    inRow: rowNum
                                };
                $.post(
                    location.pathname,
                    dataTo,
                    function(data)
                    {
                        $('a[data-id="' + dataTo.id + '"]').remove();
                        data = JSON.parse(data);
                        data.x = parseInt(data.x);
                        data.width = parseInt(data.width);
                        window.name_to_rect = data;
                    }
                );
                window.personID = null;
            }

        }, false);
    }
}

function InitVision(canvas)
{
    var street          =   $('#the-street'),
        vision          =   $('#the-vision'),
        wall            =   $('#the-wall'),
        canDrag         =   false,
        x               =   0,
        downHandler     =   function(e)
                            {
                                canDrag = true;
                                x = (e.touches ? e.touches[0].pageX : e.pageX) - street.offset().left;
                                if ($(e.target).is('#the-street')) {
                                    var visionX = x - vision.outerWidth() * 0.5;
                                    visionX = visionX >= 0 ? visionX : 0;
                                    visionX = x + vision.outerWidth() * 0.5 <= street.width() ? visionX : street.width() - vision.outerWidth();
                                    vision.css('transform', 'translateX(' + visionX + 'px)');
                                    dragHandler(e);
                                }
                            },
        dragHandler     =   function(e)
                            {
                                if (!canDrag) return;
                                x = (e.touches ? e.touches[0].pageX : e.pageX) - street.offset().left;
                                var visionX =   x - vision.outerWidth() * 0.5,
                                    r       =   (wall.width() - vision.outerWidth()) / (window.canvas_width - wall.width());
                                visionX = visionX >= 0 ? visionX : 0;
                                visionX = x + vision.outerWidth() * 0.5 <= street.width() ? visionX : street.width() - vision.outerWidth();
                                vision.css('transform', 'translateX(' + visionX + 'px)');
                                window.wallX = visionX / -r;
                                drawRect(canvas);
                            },
        upHandler     =     function(e)
                            {
                                if (x < vision.outerWidth() * 0.5) {
                                    x = vision.outerWidth() * 0.5;
                                }

                                if (x > street.width() - vision.outerWidth() * 0.5) {
                                    x = street.width() - vision.outerWidth() * 0.5;
                                }

                                if (!canDrag) return;
                                canDrag = false;
                            };

    $(window).resize(function(e)
    {
        var length  =   (42 * (wall.width() / window.canvas_width)).toFixed(2).toFloat();
        vision.html(length + 'M');
    }).resize();

    street[0].addEventListener('mousedown', downHandler, false);
    street[0].addEventListener('touchstart', downHandler, false);
    window.addEventListener('mousemove', dragHandler, false);
    window.addEventListener('touchmove', dragHandler, false);
    window.addEventListener('mouseup', upHandler, false);
    window.addEventListener('touchend', upHandler, false);

    $('.arrow-button').click(function(e)
    {
        e.preventDefault();
        if ($(this).is('#btn-click-to-left')) {
            x-= vision.outerWidth() * 0.5;
        } else {
            x+= vision.outerWidth() * 0.5;
        }


        var visionX =   x - vision.outerWidth() * 0.5,
            r       =   (wall.width() - vision.outerWidth()) / (window.canvas_width - wall.width());
        visionX = visionX >= 0 ? visionX : 0;
        visionX = x + vision.outerWidth() * 0.5 <= street.width() ? visionX : street.width() - vision.outerWidth();
        vision.css('transform', 'translateX(' + visionX + 'px)');
        window.wallX = visionX / -r;
        drawRect(canvas);
    });
}

function drawRect(canvas)
{
    window.wall.clear();
    window.wall.graphics.drawImage(canvas, window.wallX, 0);
    if (window.name_to_rect) {
        window.wall.graphics.beginPath();
        window.wall.graphics.lineWidth = "1.5";
        window.wall.graphics.strokeStyle = "#000000";
        window.wall.graphics.rect(window.name_to_rect.x * window.scale_factor + window.wallX , window.name_to_rect.y * window.scale_factor, window.name_to_rect.width * window.scale_factor, window.name_to_rect.height * window.scale_factor);
        window.wall.graphics.stroke();
        window.wall.graphics.closePath();
    }
}
