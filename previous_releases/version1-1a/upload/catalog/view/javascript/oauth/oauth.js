$.ajaxSetup({beforeSend: function(xhr){
  if (xhr.overrideMimeType)
  {
    xhr.overrideMimeType("application/json");
  }
}
});

(function(d, s, id) {
    $.getJSON('/index.php?route=auth/oauth/config_fb', function (response) {
        data = response;
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/uk_UA/sdk.js#xfbml=1&version=v2.10&appId=" + data.facebook;
        fjs.parentNode.insertBefore(js, fjs);
    })

}(document, 'script', 'facebook-jssdk'));

$.ajaxSetup({beforeSend: function(xhr){
  if (xhr.overrideMimeType)
  {
    xhr.overrideMimeType("multipart/form-data");
  }
}
});

function dix_facebook() {
    FB.login(function (response) {
        $.post("/index.php?route=auth/oauth/getDataOauth",
            {
                access: response.authResponse.accessToken,
            },
            function(response3, status){
                console.log(response3);
                $(location).attr('href', '/index.php?route=auth/oauth/successSignUp');
            }).done(function() {
            //alert( "second success" );
        }).fail(function() {
    alert( "error" );
  });
        //console.log(JSON.stringify(response));
        console.log();
    }, {scope: 'email'});
    //console.log(response);
}
var googleWindow;

function dix_googlePop(pageURL, title, w, h) {
    var left = (screen.width - w) / 2;

    var top = (screen.height - h) / 4;

    googleWindow = window.open(pageURL, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);


    //closeWin();

}







