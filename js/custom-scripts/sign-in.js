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
        "showDuration": "3000",
        "hideDuration": "1000",
        "timeOut": "2000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
    /* End of toaster */
});

function showSignUp(){
    var login_form = $('#log-in-form');
    var signup_form = $('#sign-in-form');

    login_form.fadeOut("slow", function(){
        signup_form.fadeIn("slow");
    });
}

function showLogIn(){
    var login_form = $('#log-in-form');
    var signup_form = $('#sign-in-form');

    signup_form.fadeOut("slow", function(){
        login_form.fadeIn("slow");
    });
}

function createUser(){
    var isValid = true;
    $('#age-young').hide();
    $('#email-taken').hide();
    $('#email-available').hide();
    $.when(validateEmail($('#email'))).done(function(isEmailValid, status, response){
        if(response == null || response['responseText'] == 'false'){
            isValid = false;
            $('#email-taken').show();
        }else{
            isValid = true;
            $('#email-available').show();
        }

        if(isValid == true){
            isValid = validatePassword($($('input[name="password"]')[1]));
        }

        var inputArray = {};
        if(isValid == true){
            isValid = validateDob();
            var day = parseInt($('select[name="dob_day"] option:selected').val(), 10);
            var month = parseInt($('select[name="dob_month"] option:selected').val(), 10);
            var year = $('input[name="dob_year"]').val();
            inputArray['dob'] = year + "-" + month + "-" + day
        }

        $('#sign-in-form').each(function(){
            $(this).find(":input[type=text]").each(function(){
                if(!$(this).hasClass("is-invalid-input")){
                    if($(this).attr("name") != "id"){
                        if($(this).attr("name") != "other_name" ){
                            if($(this).val() != ""){
                                inputArray[$(this).attr('name')] = $(this).val();
                            }else{
                                console.log($(this).attr('name'));
                                isValid = false;
                            }
                        }else{
                            if($(this).val() != ""){
                                inputArray[$(this).attr('name')] = $(this).val();
                            }
                        }
                    }
                }else{
                    isValid = false;
                }
            });
            
            $(this).find(":input[type=password]").each(function(){
                if($(this).attr("name") == "password"){
                    if(!$(this).hasClass("is-invalid-input")){
                        inputArray[$(this).attr('name')] = $(this).val();
                    }else{
                        isValid = false;
                    }
                }
            });
        });
        if(isValid == true){
            $.ajax({
                url:"scripts/userManagement.php",
                method:"POST",
                data: {"function":"create", "user":inputArray}
            }).done(function(data){
                if(data > -1){
                    toastr.success("User created!");
                    location.reload();
                }else if(data == "agefalse"){
                    $('#age-young').show();
                    toastr.error("You are not old enough. Users must be 18+ to sign up.");
                }else if(data == "invalid-dob"){
                    toastr.error("Invalid date of birth.");
                }else{
                    console.log(data);
                    toastr.error("Internal error!");
                }
            });
        }else{
            toastr.error("Form not filled in correctly. Please try again.");
        }
    });
}

function logIn(){
    var inputArray = {};
    $('#log-in-form').each(function(){
        $(this).find("input").each(function(){
            if($(this).attr("type") != "submit" && $(this).attr("type") != "checkbox"){
                inputArray[$(this).attr("name")] = $(this).val();
            }
            if($(this).attr("type") == "checkbox"){
                inputArray[$(this).attr("name")] = $(this).is(":checked");
            }
        });
    });

    $.ajax({
        url:"scripts/userManagement.php",
        method:"POST",
        data:{"function":"login", "user":inputArray}
    }).done(function(data){
        console.log(data);
        if(data == "true"){
            toastr.success("Success! Redirecting to homepage in 3 seconds...");
            setTimeout(function(){
                window.location.replace("index.php");
            }, 3000);
        }else if(data == "user-banned"){
            toastr.error("Error! You have been banned. Please contact support if you wish to appeal the ban.");
        }else if(data == "wrong-password"){
            toastr.error("Error! The password you have entered is incorrect. Please try again.");
        }else if(data == "user-not-found"){
            toastr.error("Error! User with entered E-mail not found. Please try again.");
        }else{
            toastr.error("Internal error. Please contact system administrator.");
        }
    });
}

function validateEmail(object){
    if(object.val().length > 0){
        $('#email-taken').hide();
        $('#email-available').hide();
        var emailTaken = false;
        if(!object.hasClass("is-invalid-input")){
            var email = object.val();
            return $.ajax({
                url:"scripts/userManagement.php",
                method:"POST",
                data:{"function":"validate", "email":email}
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
        $('#invalid-password').show();
        return false;
    }

    return true;
}

function validateDob(){
    var ListofDays = [31,28,31,30,31,30,31,31,30,31,30,31];
    var day = parseInt($('select[name="dob_day"] option:selected').val(), 10);
    var month = parseInt($('select[name="dob_month"] option:selected').val(), 10);
    var year = $('input[name="dob_year"]').val();

    if(day < -1 || month < -1 || parseInt(year, 1000) < -1){
        return false
    }

    if(day > ListofDays[month-1]){
        return false;
    }else{
        return true;
    }
}