$(document).ready(function(){
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
    
    $('#transaction-table tr').click(function(){
        var id = $($(this).children()[0])[0].innerHTML;
        var detailsPanel = $('[data-transaction-details='+id+']');
        if(detailsPanel.is(":visible")){
            detailsPanel.slideUp(250);
        }else{
            detailsPanel.slideDown(250);
        }
    });

    $('[data-select-status]').on("change", function(){
        var id = $(this).parent().parent().children()[0].innerHTML;
        var status = $(this).val();
        var parameters = {};

        parameters['id'] = id;
        parameters['status'] = status;
        parameters['function'] = "updateStatus";

        $.ajax({
            url:"scripts/transactionManagement.php",
            method:"POST",
            data:parameters
        }).done(function(data){
            if(data == "true"){
                toastr.success("Success! Transaction has been updated.");
            }
        });
    });

    $('[data-select-status]').on("click", function(){
        return false;
    });
});