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

function addProduct(id){
    var field = $('[data-product-id="'+ id +'"]').val();

    data = {};

    data['function'] = "addToBasket";
    data['quantity'] = field;
    data['id'] = id;

    console.log(data);

    $.ajax({
        url: "scripts/cartManagement.php",
        method:"POST",
        data:data
    }).done(function(data){
        if(data == "not-enough-stock"){
            toastr.error("Not enough in stock. Please use a lower amount or wait for more to be in stock.");
        }else{
            location.reload();
        }
        console.log(data);
    });
}

function rateProduct(id){
    var rating = $('[name="rating-input"]').val();
    var parameters = {};
    parameters['function'] = "rateProduct";
    parameters['id'] = id;
    parameters['rating'] = rating;
    if(rating > 0 && rating < 6){
        $.ajax({
           url:"scripts/cartManagement.php",
            method:"POST",
            data:parameters
        }).done(function(data){
            if(data == "true"){
                toastr.success("Success! Rating has been submitted.");
            }
        });
    }else{
        toastr.error("Error! Invalid rating submitted, rating must be between 1 and 5.");
    }
}