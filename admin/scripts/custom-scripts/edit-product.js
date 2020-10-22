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
        "showDuration": "1500",
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

function addTag(input){
    var tag = input.val();
    var checkTag = false;
    if(tag != ""){
        var table = $('#tag-table tbody');
        $('#tag-table > tbody > tr').each(function(i, row){
            var row = $(row).children().get(0);
            var td = $(row);
            if(td.html().toLowerCase() == tag.toLowerCase()){
                checkTag = true;
            }
        });
        if(checkTag != true){
            var markup = "<tr><td>"+ tag +"</td><td><button class='button alert' onclick='$(this).parent().parent().remove(); return false;'><i class='fas fa-trash'></i></button></td></tr>";
            table.append(markup);
            input.val('');
        }
    }
}

function updateProduct(){
    var required = $('input,textarea,select').filter('[required]:visible');
    var allRequired = true;
    required.each(function(){
        if($(this).val() == ''){
            allRequired = false;
        }
    });
    if(allRequired == true){
        var isValid = true;
        var inputArray = {};
        var formData = new FormData();
        var tags = "";
        $("#product-form").each(function(){
            $(this).find(":input[type=text]").each(function(){
                if($(this).attr('id') != "tag-input"){
                    if(!$(this).hasClass("is-invalid-input")){
                        inputArray[$(this).attr('id')] = $(this).val();
                    }else{
                        isValid = false;
                    }
                }
            });
            $(this).find(":input[type=number], textarea").each(function(){
                if(!$(this).hasClass("is-invalid-input")){
                    inputArray[$(this).attr('id')] = $(this).val();
                }else{
                    isValid = false;
                }
            });
            $(this).find(":input[type=file]").each(function(){
                if(!$(this).hasClass("is-invalid-input")){
                    if($(this).attr('id') == "thumbnail"){
                        inputArray[$(this).attr('id')] = $(this).val();
                        formData.append("image", this.files[0]);
                    }else{
                        for(var i=0; i < this.files.length; i++){
                            formData.append("gallery[]", this.files[i]);
                        }
                    }
                }else{
                    isValid = false;
                }
            });
            $('#tag-table > tbody > tr').each(function(i, row){
                var row = $(row).children().get(0);
                var td = $(row);
                tags = tags.concat(td.html(), ",");
            });
        });
        inputArray["tags"] = tags.substr(0, tags.length-1);
        inputArray["section_id"] = $('#section option:selected').val();

        formData.append("data", JSON.stringify(inputArray));
        formData.append("function", "update");
        for (var pair of formData.entries()) {
            console.log(pair[0]+ ', ' + pair[1]); 
        }

        if(isValid == true){
            $.ajax({
                url:"scripts/productManagement.php",
                method:"POST",
                contentType:false,
                processData:false,
                data: formData,
            }).done(function(data){
                console.log(data);
                toastr.success("Success! Product has been updated.");
            });
        }else{
            toastr.error("Invalid information entered! Please amend the errors in the form.");
        }
    }else{
        toastr.error("Invalid information entered! Please amend the errors in the form.");
    }
}

function deleteProduct(id){
    $.ajax({
        url:"scripts/productmanagement.php",
        method:"POST",
        data:{"function":"delete", "id":id}
    }).done(function(data){
        window.location.href = "product-management.php";
    });
}

function deleteImage(object, id){
    var image = object.val();
    $.ajax({
        url:"scripts/productmanagement.php",
        method:"POST",
        data: {"function":"deleteImage", "image":image, "id":id}
    }).done(function(data){
        console.log(data);
        if(data == "true"){
            object.parent().parent().remove();
        }
    });
}

function readURL(input) {
    input = input[0];
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#thumbnail-image').attr('src', e.target.result);
            $('#thumbnail-image').show();
        }

        reader.readAsDataURL(input.files[0]);
    }
}

$("#tag-input").keypress(function(e) {
    //Enter key
    if (e.which == 13) {
        addTag($('#tag-input'));
        return false;
    }
});