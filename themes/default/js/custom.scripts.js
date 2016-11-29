window.totalImages = 21;
window.wall = null;
$(document).ready(function(e)
{
    if ($('body').hasClass('namefinder')) {
        var loader  =   new Sprite(21000, 323),
            canvas  =   new Sprite($(window).width(), 323),
            dir     =   '/themes/default/images/panels/';

        window.wall =   canvas;
        for (var i = 1; i <= 21; i++) {
            drawImage(loader, dir + i + '.jpg', i);
        }

        $('#main').append($(canvas.canvas));
    }

});

function drawImage(canvas, src, i)
{
    var img = new Image();
    img.onload = function()
    {
        canvas.graphics.drawImage(img, (i-1) * 1000, 0);
        window.totalImages--;
        if (window.totalImages == 0) {
            //window.wall.graphics.drawImage(, 0, 0);
            wallSt(canvas.canvas);
        }
    };
    img.src = src;
}

function wallSt(canvas)
{
    window.wall.graphics.drawImage(canvas, 0, 0);
    var r   =   1,
        x   =   0;
    $(window).resize(function(e)
    {
        r = $(window).width() / (21000 - $(window).width());
        window.wall.width($(window).width());
        window.wall.graphics.drawImage(canvas, x / -r, 0);
    }).resize();

    window.addEventListener('mousemove', function(e)
    {
        x = e.pageX;
        window.wall.clear();
        window.wall.graphics.drawImage(canvas, x / -r , 0);
    }, false);
}
