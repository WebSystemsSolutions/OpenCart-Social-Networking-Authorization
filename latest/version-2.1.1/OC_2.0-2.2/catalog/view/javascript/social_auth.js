$(document).ready(function() {

});

//  social_auth

var social_auth = {

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


    },
    'instagram': function(th) {
        
        var button = th;
        
        var text_old = $(button).html();
        var text_loading = $(button).attr('data-loading-text');
        if(text_loading == ''){
            text_loading = 'Loading';
        }

        // login instagram

        $(button).html(text_loading);

        var url = '/index.php?route=module/social_auth/iframeInstagramLogin';

        var w = 500;
        var h = 600;

        var left = (screen.width - w) / 2;
        var top = (screen.height - h) / 4;


        window.open(url, 'Instagram auth', 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);


    },
    'facebook': function(th) {
        
        var button = th;
        
        var text_old = $(button).html();
        var text_loading = $(button).attr('data-loading-text');
        if(text_loading == ''){
            text_loading = 'Loading';
        }

        // Facebook instagram

        $(button).html(text_loading);

        var url = '/index.php?route=module/social_auth/iframeFacebookLogin';

        var w = 500;
        var h = 600;

        var left = (screen.width - w) / 2;
        var top = (screen.height - h) / 4;


        window.open(url, 'Facebook auth', 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);


    }
}
