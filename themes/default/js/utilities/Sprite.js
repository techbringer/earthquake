var Sprite = function(w,h)
{
    var self        =   this;

    this.canvas     =   $('<canvas />')[0];
    this.graphics   =   this.canvas.getContext('2d');

    this.width      =   function(n)
                        {
                            if (n != null && n != undefined) {
                                self.canvas.width = n;
                            }

                            return self.canvas.width;
                        };

    this.height     =   function(n)
                        {
                            if (n != null && n != undefined) {
                                self.canvas.height = n;
                            }

                            return self.canvas.height;
                        };

    this.clear      =   function()
                        {
                            self.graphics.clearRect(0, 0, self.width(), self.height());
                        };

    this.canvas.width = w != null && w != undefined ? w : 100;
    this.canvas.height = h != null && h != undefined ? h : 100;


    return this;
};
