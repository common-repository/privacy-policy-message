;
(function($){
    $(function(){
        if($('.prvpmsg').length > 0){
            console.log('prvpmsg (event): Init');
            // Check Cookies
            if (typeof $.cookie('prvpmsg_cookie_message') === 'undefined'){
                //no cookie - show message
                $('.prvpmsg').show();
                console.log('prvpmsg (event): Show message');
            }
            $('.prvpmsg__btn-close','.prvpmsg').click(function(event){
                event.preventDefault();
                var expire_days = $('.prvpmsg').data('expire');
                var options = {};
                options['expires'] = expire_days;
                options['path'] = '/';
                
                // create cookie
                console.log('prvpmsg (event): Create cookie');
                $.cookie('prvpmsg_cookie_message', 1, options);
                
                // hide cookie box
                console.log('prvpmsg (event): Hide cookie');
                $(this).parent().hide();
            });
        }
    });
})(jQuery);