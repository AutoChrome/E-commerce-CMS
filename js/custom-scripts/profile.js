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

function updateProfile(){
    var parameters = {};

    parameters['first_name'] = $('input[name="first_name"]').val();
    parameters['other_name'] = $('input[name="other_name"]').val();
    parameters['last_name'] = $('input[name="last_name"]').val();
    parameters['email'] = $('input[name="email"]').val();
    parameters['address'] = $('input[name="address"]').val();
    parameters['postcode'] = $('input[name="postcode"]').val();
    parameters['town'] = $('input[name="town"]').val();
    parameters['telephone'] = $('input[name="telephone"]').val();
    parameters['password'] = $('input[name="password"]').val();
    var check = validateUserData(parameters['first_name'], parameters['other_name'], parameters['last_name'], parameters['email'], parameters['address'], parameters['postcode'], parameters['town'], parameters['telephone']);
    if(check == true){
        if(validateDob()){
            parameters['dob'] = $('input[name="dob_year"]').val() + "-" + parseInt($('select[name="dob_month"] option:selected').val(), 10) + "-" + parseInt($('select[name="dob_day"] option:selected').val(), 10);
            var data = {};

            data['function'] = "update";
            data['data'] = parameters;

            $.ajax({
                url:"scripts/userManagement.php",
                method:"POST",
                data:data
            }).done(function(data){
                if(data == "true"){
                    toastr.success("Success! Profile updated. Refreshing page in 3 seconds.");
                    setTimeout(function(){
                        location.reload();
                    }, 3000);
                }else{
                    if(data == "incorrect-password"){
                        toastr.error("Error! Incorrect password was entered.");
                    }
                    if(data == "incorrect-date"){
                        toastr.error("Error! Incorrect date was entered.");
                    }
                }
                console.log(data);
            });
        }
    }else{
        if(check == "incorrect-email"){
            toastr.error("Error! Incorrect email format. Please enter a correct format.");
        }
        console.log(check);
    }
}

function updatePassword(){
    var currentPassword = $('[name="change-current-password"]').val();
    var newPassword = $('[name="change-new-password"]').val();
    var confirmPassword = $('[name="change-confirm-password"]').val();

    if(currentPassword.length > 0 && newPassword.length > 0 && confirmPassword.length > 0){
        if(newPassword == confirmPassword){
            if(newPassword.length > 5){
                var data = {};

                data['function'] = "changePassword";
                data['currentPassword'] = currentPassword;
                data['newPassword'] = newPassword;
                $.ajax({
                    url:"scripts/userManagement.php",
                    method:"POST",
                    data:data
                }).done(function(data){
                    if(data > 0){
                        toastr.success("Success! Profile updated. Refreshing page in 3 seconds.");
                        setTimeout(function(){
                            location.reload();
                        }, 3000);
                    }else{
                        if(data == "incorrect-password"){
                            toastr.error("Error! Incorrect password was entered.");
                        }
                    }
                    console.log(data);
                });
            }else{
                toastr.error("Error! Password must contain at least 6 characters.");
            }
        }else{
            toastr.error("Error! Password and confirm password do not match.");
        }
    }else{
        toastr.error("Error! All fields must be filled in.");
    }
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

function validateUserData(first_name, other_name, last_name, email, address, postcode, town, telephone){
    var emailRegex = /^(?:(?:[\w`~!#$%^&*\-=+;:{}'|,?\/]+(?:(?:\.(?:"(?:\\?[\w`~!#$%^&*\-=+;:{}'|,?\/\.()<>\[\] @]|\\"|\\\\)*"|[\w`~!#$%^&*\-=+;:{}'|,?\/]+))*\.[\w`~!#$%^&*\-=+;:{}'|,?\/]+)?)|(?:"(?:\\?[\w`~!#$%^&*\-=+;:{}'|,?\/\.()<>\[\] @]|\\"|\\\\)+"))@(?:[a-zA-Z\d\-]+(?:\.[a-zA-Z\d\-]+)*|\[\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}\])$/;
    var postcodeRegex = /([Gg][Ii][Rr] 0[Aa]{2})|((([A-Za-z][0-9]{1,2})|(([A-Za-z][A-Ha-hJ-Yj-y][0-9]{1,2})|(([A-Za-z][0-9][A-Za-z])|([A-Za-z][A-Ha-hJ-Yj-y][0-9][A-Za-z]?))))\s?[0-9][A-Za-z]{2})/;
    var telephoneRegex = /^\s*((0044[ ]?|0)[ ]?20[ ]?[7,8]{1}?[ ]?[1-9]{1}[0-9]{2}[ ]?[0-9]{4})|((0044[ ]?|0[1-8]{1})[0-9]{1,2}[ ]?[1-9]{1}[0-9]{2}[ ]?([0-9]{6}|[0-9]{5}|[0-9]{4}))|(0[1-8]{1}[0-9]{3}[ ]?[1-9]{1}[0-9]{2}[ ]?[0-9]{2,3})|(0800[ ]?([1-9]{3}[ ]?[1-9]{4}|[1-9]{6}|[1-9]{4}))|(09[0-9]{1}[ ]?[0-9]{1}[ ]?([1-9]{4}|[1-9]{6}|[1-9]{3}[ ]?[1-9]{4}))\s*$/;
    if(first_name.length > 0){
        if(other_name.length > 0){
            if(last_name.length > 0){
                if(email.length > 0 && email.match(emailRegex)){
                    if(address.length > 0){
                        if(postcode.length > 0 && postcode.match(postcodeRegex)){
                            if(town.length > 0){
                                if(telephone.match(telephoneRegex)){
                                    return true;
                                }else{
                                    return "incorrect-telephone";
                                }
                            }else{
                                return "incorrect-town";
                            }
                        }else{
                            return "incorrect-postcode";
                        }
                    }else{
                        return "incorrect-address";
                    }
                }else{
                    return "incorrect-email";
                }
            }else{
                return "incorrect-last-name";
            }
        }else{
            return "incorrect-other-name";
        }
    }else{
        return "incorrect-first-name";
    }
}

function displayTable(){
    var table = $('#orderTable');

    if(table.is(":visible")){
        table.hide();
    }else{
        table.show();
    }
}