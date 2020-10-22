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
        "showDuration": "500",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
    /* End of toaster */
    noProducts();
});

$('[data-display-filter]').click(function (e){
    var span = $('[data-filter-span]');
    if($('.filter-content').is(":visible")){
        $('.filter-content').slideUp(250);
        span.removeClass();
        span.addClass("fas");
        span.addClass("fas fa-sort-down");
    }else{
        $('.filter-content').slideDown(250);
        span.removeClass();
        span.addClass("fas");
        span.addClass("fas fa-sort-up");
    }
});

$('#limit').on('change', function(){
    urlParams = new URLSearchParams(window.location.search);
    if(urlParams.has("limit")){
        urlParams.delete("limit");
    }
    urlParams.append("limit", $('#limit').val());
    window.location.replace("product-management.php?" + urlParams.toString());
});

function sortTable(object){
    var sortArray = new Array();
    resetSort(object);
    var field = object.data("value");
    var sort = object.data("sort");
    sortArray.push(JSON.parse('{"field":"'+ field +'"}'));
    sortArray.push(JSON.parse('{"sort":"'+ sort +'"}'));
    var span = object.children("span");
    var table = $('#product-table');
    if(sort == "none"){
        object.data("sort", "decs");
        span.removeClass();
        span.addClass("fas");
        span.addClass("fa-sort-down");
    }else if(sort == "decs"){
        object.data("sort", "asc");
        span.removeClass();
        span.addClass("fas");
        span.addClass("fa-sort-up");
    }else{
        object.data("sort", "none");
        span.removeClass();
    }
}

function resetSort(object){
    var resetSorts = object.parent().parent();
    for(var i = 0; i < resetSorts.children().length; i++){
        var resetItem = $(resetSorts.children()[i]).children();
        var resetItemSpan = resetItem.children();
        if(object.data("value") != resetItem.data('value')){
            resetItemSpan.removeClass();
            resetItem.data("sort", "none");
        }
    }
}

function searchProduct(object, url){
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
    window.location.replace("product-management.php?" + urlParams.toString());
}

function noProducts(){
    if($('table tbody tr').length < 1){
        toastr['error']("There was no products found with the specified query...");
    }

}