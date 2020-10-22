function acceptCookieClick(){
    $.ajax({
        url:"scripts/cookie-management.php",
        method:"POST",
        data:{"cookie_set_request":"accept-cookies"}
    }).done(function(data){
      $('#cookie_request').remove();
    });
}

function denyCookieClick(){
    $.ajax({
        url:"scripts/cookie-management.php",
        method:"POST",
        data:{"cookie_set_request":"deny-cookies"}
    }).done(function(data){
        $('#cookie_request').remove();
    });
}