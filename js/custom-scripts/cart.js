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

    var typingTimer;
    var doneTypingInterval = 1000;
    var couponInput = $('[name="coupon-input"]');
    couponInput.keydown(function(){
        clearTimeout(typingTimer);
        typingTimer = setTimeout(checkCouponCode, doneTypingInterval);
    });
});

$('[data-cart-validation]').keypress(function(e){
    var ignore_key_codes = [97, 98, 99, 100, 101, 102, 103, 104, 105, 106, 107, 108, 109, 110, 111, 112, 113, 114, 115, 116, 117, 118, 119, 120, 121, 122];

    if($.inArray(e.keyCode, ignore_key_codes) >= 0){
        e.preventDefault();
    }else{

    }
});

function checkCouponCode(){
    var couponInput = $('[name="coupon-input"]');
    if(couponInput.val().length > 0){
        var parameters = {};

        parameters['function'] = "checkCoupon";
        parameters['coupon'] = couponInput.val();
        $.when(
            $.ajax({
                url:"scripts/cartManagement.php",
                method:"POST",
                data:parameters
            })).then(function(data){
            if(data != "false"){
                return true;
            }else{
                return false;
            }
        });
    }
}


function addCoupon(){
    var couponCode = $('[name="coupon-input"]').val();
    var parameters = {};
    parameters['function'] = "checkCoupon";
    parameters['coupon'] = couponCode;

    $.when(
        $.ajax({
            url:"scripts/cartManagement.php",
            method:"POST",
            data:parameters
        })).then(function(data){
        console.log(data);
        if(data != "false"){
            document.location.search = "?coupon=" + couponCode;
        }else{
            toastr.error("Error! Coupon does not exist, is expired or has been used.");
        }
    });
}

function updateSessionQuantity(product_id){
    var parameters = {};

    parameters['function'] = "updateSessionQuantity";
    parameters['product_id'] = product_id;
    parameters['quantity'] = $('[data-cart-id="'+ product_id +'"]').val();
    $.ajax({
        url:"scripts/cartManagement.php",
        method:"POST",
        data:parameters
    }).done(function(data){
        if(data == "true"){
            location.reload();
        }else{
            if(data == "must-be-greater-than-0"){
                toastr.error("Quantity must be greater than 0.");
            }
            if(data == "not-enough-stock"){
                toastr.error("Not enough in stock.");
            }
        }
        console.log(data);
    });

}

function removeSessionProduct(product_id){
    var parameters = {};

    parameters['function'] = "removeSessionProduct";
    parameters['product_id'] = product_id;
    $.ajax({
        url:"scripts/cartManagement.php",
        method:"POST",
        data:parameters
    }).done(function(data){
        if(data == "true"){
            location.reload();
        }
        console.log(data);
    });
}

function updateQuantity(cart_id){
    var parameters = {};
    var quantity = $('[data-cart-id="'+cart_id+'"]').val();
    parameters['function'] = "updateQuantity";
    parameters['cart_id'] = cart_id;
    parameters['quantity'] = quantity;
    $.ajax({
        url:"scripts/cartManagement.php",
        method:"POST",
        data:parameters
    }).done(function(data){
        console.log(data);
        if(data > 0){
            location.reload();
        }else if(data == "not-enough-stock"){
            toastr.error("We do not have that much in stock. Please try again later.");
        }else{
            toastr.error("Quantity must not be the same and must be greater than 0.");
        }
    });
}

function removeProduct(cart_id){
    var parameters = {};
    parameters['function'] = "removeProduct";
    parameters['cart_id'] = cart_id;
    $.ajax({
        url:"scripts/cartManagement.php",
        method:"POST",
        data:parameters
    }).done(function(data){
        if(data == "true"){
            location.reload();
        }else{
            toastr.error("Product not found. Please refresh your page.");
        }
    });
}

function createPurchase(){
    var parameters = {};
    var products = [];
    if($('#stripe').is(":checked")){
        parameters['function'] = "purchaseStripe";
        $('[name=product]').each(function(){
            var addProduct = {};
            var quantity = $($(this).children()[0]).children().val();
            var product_id = $($(this).children()[2]).val();

            addProduct['product_id'] = product_id;
            addProduct['quantity'] = quantity;

            products.push(addProduct);
        });
        parameters['products'] = products;
        const urlParams = new URLSearchParams(window.location.search);
        const myParam = urlParams.get('coupon');
        parameters['coupon'] = myParam;
        var shipping = $("input:radio[name='shipping']:checked").attr("data-shipping-id");
        parameters['shipping_id'] = shipping;
        $.ajax({
            url:"scripts/cartManagement.php",
            method:"POST",
            data:parameters
        }).done(function(data){
            if(data != "no-items"){
                if(data != "no-shipping"){
                    var jsonObject = JSON.parse(data);
                    var stripe = Stripe(jsonObject.publishable);

                    stripe.redirectToCheckout({
                        sessionId: jsonObject.id,
                    }).then(function (result) {
                        // If `redirectToCheckout` fails due to a browser or network
                        // error, display the localized error message to your customer
                        // using `result.error.message`.
                    });
                }else{
                    toastr.error("You currently have not selected a shipping method!");
                }
            }else{
                toastr.error("You currently have no items in your basket!");
            }
            console.log(data);
        });
    }else{
        //PayPal
    }
}