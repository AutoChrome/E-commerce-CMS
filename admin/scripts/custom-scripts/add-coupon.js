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

function createCoupon(){
    var code = $('[name="code"]').val();
    var discount = $('[name="discount"]').val();
    var usages = $('[name="usages"]').val();
    var expiry = $('[name="expiry"]').val();
    var description = $('[name="description"]').val();
    if(code.length > 0 && discount.length > 0 && usages.length > 0 && expiry.length > 0 && description.length > 0){
        var parameters = {};

        parameters['function'] = "createCoupon";
        parameters['code'] = code;
        parameters['discount'] = discount;
        parameters['usages'] = usages;
        parameters['expiry'] = expiry;
        parameters['description'] = description;

        $.ajax({
            url:"scripts/couponManagement.php",
            method:"POST",
            data:parameters
        }).done(function(data){
            if(data == "true"){
                toastr.success("Success! Coupon has been created.");
            }else if(data == "code-exist"){
                toastr.error("Error! Code already exists.");
            }else{
                toastr.error("Error!");
            }
        });
    }else{
        toastr.error("Error! Form was not filled in correctly.");
    }
}

function updateCoupon(id){
    var code = $('[name="code"]').val();
    var discount = $('[name="discount"]').val();
    var usages = $('[name="usages"]').val();
    var expiry = $('[name="expiry"]').val();
    var description = $('[name="description"]').val();
    if(code.length > 0 && discount.length > 0 && usages.length > 0 && expiry.length > 0 && description.length > 0){
        var parameters = {};

        parameters['function'] = "updateCoupon";
        parameters['id'] = id;
        parameters['code'] = code;
        parameters['discount'] = discount;
        parameters['usages'] = usages;
        parameters['expiry'] = expiry;
        parameters['description'] = description;

        $.ajax({
            url:"scripts/couponManagement.php",
            method:"POST",
            data:parameters
        }).done(function(data){
            if(data == "true"){
                toastr.success("Success! Changes hav ebeen applied.");
            }else{
                toastr.error("Error! Code already exists.");
            }
        });
    }else{
        toastr.error("Error! Form was not filled in correctly.");
    }
}