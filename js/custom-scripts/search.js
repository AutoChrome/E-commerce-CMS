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

$(document).ready(function(){
    if($('[name="product-count"]').val() < 1){
        toastr.error("No products found.");
    }
});

function addProduct(id){
    var field = $($("[data-product-id='"+id+"'] :input")[0]).val();

    data = {};

    data['function'] = "addToBasket";
    data['quantity'] = field;
    data['id'] = id;

    $.ajax({
        url: "scripts/cartManagement.php",
        method:"POST",
        data:data
    }).done(function(data){
        if(data == "not-enough-stock"){
            toastr.error("Not enough in stock. Please use a lower amount or wait for more to be in stock.");
        }else{
            window.location.reload();
        }
        console.log(data);
    });
}

function searchProduct(){
    var form = $('#searchForm');

    var queries = new URLSearchParams(window.location.search);

    console.log(queries.get('product'));

    $('form#searchForm :input').each(function(){
        var input = $(this);
        var valueChanged = false;
        queries.forEach(function(value, key){
            if(key == input.attr("name")){
                if(input.val().length > 0){
                    queries.set(input.attr("name"), input.val());
                    valueChanged = true;
                }
            }
        });
        if(input.val().length > 0 && valueChanged == false){
            queries.append(input.attr("name"), input.val());
        }
        valueChanged = false;
    });

    console.log(queries.toString());
    var urlReplace = "search.php?" + queries.toString();
    window.location.href = urlReplace;
}