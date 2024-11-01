(function ($){
    $(function (){
        var vb;
        var options = {
            cb_post_open: function (){
                $('.strobe-overlay-close').click(function (){
                    vb.VBclose();
                });
            },
            cb_after_nav: function (){
                $('.strobe-overlay-close').click(function (){
                    vb.VBclose();
                });
            }
        };
        vb = $('.strobe-events-container .venobox').venobox(options);
    });
})(jQuery);