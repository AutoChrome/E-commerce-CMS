$(function(){
    /* Toaster */
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        "progressBar": true,
        "positionClass": "toast-bottom-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "20000",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
    /* End of toaster */
});

$('#limit').on('change', function(){
    urlParams = new URLSearchParams(window.location.search);
    if(urlParams.has("limit")){
        urlParams.delete("limit");
    }
    urlParams.append("limit", $('#limit').val());
    window.location.replace("user-management.php?" + urlParams.toString());
});

$('[data-display-filter]').click(function (e){
    var span = $('[data-filter-span]');
    if($('.filter-content').is(":visible")){
        $('.filter-content').slideUp(250);
        span.removeClass();
        span.addClass("fas fa-sort-down float-right");
    }else{
        $('.filter-content').slideDown(250);
        span.removeClass();
        span.addClass("fas fa-sort-up float-right");
    }
});

function searchUser(object, url){
    const urlParams = new URLSearchParams(window.location.search);
    var form = $(object[0]);
    var inputArray = [];
    var urlFinal = url;
    $(":input", form[0]).each(function(e){
        var input = $(this);
        if(input.prop("tagName") != "BUTTON"){
            if(input.val() != null && input.val() != "" && input.val() != "All"){
                inputArray.push([input.attr("name"), input.val()]);
            }else{
                if(urlParams.has(input.attr('name'))){
                    urlParams.delete(input.attr('name'));
                }
            }
        }
    });
    for(var i = 0; i < inputArray.length; i++){
        if(!urlParams.has(inputArray[i][0])){
            urlParams.append(inputArray[i][0], inputArray[i][1]);
        }else{
            urlParams.set(inputArray[i][0], inputArray[i][1]);
        }
    }
    window.location.replace("user-management.php?" + urlParams.toString());
}

function expandTransaction(header, object){
    var list = $('#transaction-list-' + object);
    var span = header.children().children();
    if(list.is(":visible")){
        list.slideUp(250);
        span.removeClass();
        span.addClass("fas");
        span.addClass("fas fa-sort-down");
    }else{
        list.slideDown(250);
        span.removeClass();
        span.addClass("fas");
        span.addClass("fas fa-sort-up");
    }
}

function promoteUser(id){
    $.ajax({
        url:"scripts/userManagement.php",
        method:"POST",
        data:{"function":"promote", "id":id}
    }).done(function(data){
        if(data > 0){
            location.reload();
            toastr.success("User promoted to administrator!");
        }else{
            toastr.error("Error! User doesn't exist or already is an administrator.");
        }
    });
}

function demoteUser(id){
    $.ajax({
        url:"scripts/userManagement.php",
        method:"POST",
        data:{"function":"demote", "id":id}
    }).done(function(data){
        if(data > 0){
            location.reload();
            toastr.success("User demoted to user.");
        }else{
            toastr.error("User doesn't exist or already is not an administrator.");
        }
    });
}

function banUser(id){
    $.ajax({
        url:"scripts/userManagement.php",
        method:"POST",
        data:{"function":"ban", "id":id}
    }).done(function(data){
        if(data > 0){
            location.reload();
            toastr.success("User banned.");
        }else{
            toastr.error("User doesn't exist or already is banned.");
        }
    });
}

function unbanUser(id){
    $.ajax({
        url:"scripts/userManagement.php",
        method:"POST",
        data:{"function":"unban", "id":id}
    }).done(function(data){
        if(data > 0){
            location.reload();
            toastr.success("User unbanned.");
        }else{
            toastr.error("User doesn't exist or already is banned.");
        }
    });
}