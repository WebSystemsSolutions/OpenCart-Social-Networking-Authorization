$(document).ready(function() {

});

//  social_auth

var social_auth = {

    'facebook': function(th) {

        var button = th;
        
        var text_old = $(button).html();
        var text_loading = $(button).attr('data-loading-text');
        if(text_loading == ''){
            text_loading = 'Loading';
        }

        // login Facebook

        $(button).html(text_loading);

        FB.login(function(response) {
            if (response.authResponse) {

                $.getJSON('/index.php?route=module/social_auth/ajaxFacebookLogin', response.authResponse, function (data) {

                    if(data.status){
                        if(data.redirect){
                            window.location.href = data.redirect;
                        } else {
                            document.location.reload(true);
                        }
                    } else {
                        document.location.reload(true);
                    }
                    $(button).html(text_old);
                });

            } else {
             console.log('User cancelled login or did not fully authorize.');
             $(button).html(text_old);
            }
            
            
            
        }, {scope: 'email'});
        
    },
    'googleplus': function(th) {
        
        var button = th;
        
        var text_old = $(button).html();
        var text_loading = $(button).attr('data-loading-text');
        if(text_loading == ''){
            text_loading = 'Loading';
        }

        // login googleplus

        $(button).html(text_loading);

        var googleplus_url = '/index.php?route=module/social_auth/iframeGoogleLogin';

        var w = 500;
        var h = 600;

        var left = (screen.width - w) / 2;
        var top = (screen.height - h) / 4;


        window.open(googleplus_url, 'googleplus auth', 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);


    }
}
