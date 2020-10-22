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


$('#show-password').on("click", function(){
    var input = $('#password');
    var change = $(this).children();
    if(input.attr("type") == "password"){
        input.attr("type", "text");
        change.removeClass("fa-eye-slash");
        change.addClass("fa-eye");
    }else{
        input.attr("type", "password");
        change.removeClass("fa-eye");
        change.addClass("fa-eye-slash");
    }
});
$('#show-confirm-password').on("click", function(){
    var input = $('#confirm-password');
    var change = $(this).children();
    if(input.attr("type") == "password"){
        input.attr("type", "text");
        change.removeClass("fa-eye-slash");
        change.addClass("fa-eye");
    }else{
        input.attr("type", "password");
        change.removeClass("fa-eye");
        change.addClass("fa-eye-slash");
    }
});
$('.show-password').hover(function(){
    $(this).addClass("show-password-hover");
}, function(){
    $(this).removeClass("show-password-hover");
});
$('#email').keypress(function(e){
    if(e.which == 13){
        validateEmail($('#email'));
        return false;
    } 
});

function createUser(){
    var isValid = true;
    $('#age-young').hide();
    validateEmail($('#email'));
    if(validatePassword($('#password')) == false){
        isValid = false;
    }

    var inputArray = {};
    $('#user-form').each(function(){
        $(this).find(":input[type=text]").each(function(){
            if(!$(this).hasClass("is-invalid-input")){
                if($(this).attr("id") != "id"){
                    inputArray[$(this).attr('id')] = $(this).val();
                }
            }else{
                isValid = false;
            }
        });
        $(this).find(":input[type=password]").each(function(){
            if($(this).attr("id") == "password"){
                if(!$(this).hasClass("is-invalid-input")){
                    inputArray[$(this).attr('id')] = $(this).val();
                }else{
                    isValid = false;
                }
            }
        }); 
    });
    inputArray["privileges"] = $('#privileges').val();
    if(isValid == true){
        $.ajax({
            url:"scripts/userManagement.php",
            method:"POST",
            data: {"function":"create", "user":inputArray}
        }).done(function(data){
            if(data > -1){
                toastr.success("User created!");
            }else if(data == "agefalse"){
                $('#age-young').show();
                toastr.error("User not old enough.");
            }else{
                console.log(data);
                toastr.error("Internal error!");
            }
        });
    }
}

function validateEmail(object){
    if(object.val().length > 0){
        $('#email-taken').hide();
        $('#email-available').hide();
        if(!object.hasClass("is-invalid-input")){
            var email = object.val();
            $.ajax({
                url:"scripts/userManagement.php",
                method:"POST",
                data:{"function":"validate", "email":email}
            }).done(function(data){
                if(data == "true"){
                    $('#email-available').show();
                }else{
                    $('#email-taken').show();
                }
            });
        }
    }
}

function validatePassword(object){
    if(object.val() != $('#confirm-password').val()){
        $('#invalid-password').show();
        return false;
    }
    if(object.val().length < 6){
        return false;
    }

    return true;
}