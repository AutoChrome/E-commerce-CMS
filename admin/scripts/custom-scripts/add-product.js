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

$("#tag-input").keypress(function(e) {
    //Enter key
    if (e.which == 13) {
        addTag($('#tag-input'));
        return false;
    }
});

function createProduct(){
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
        var clearArray = [];
        var formData = new FormData();
        var tags = "";
        $("#product-form").each(function(){
            $(this).find(":input[type=text]").each(function(){
                if($(this).attr('id') != "tag-input"){
                    if(!$(this).hasClass("is-invalid-input")){
                        inputArray[$(this).attr('id')] = $(this).val();
                        clearArray.push($(this));
                    }else{
                        isValid = false;
                    }
                }
            });
            $(this).find(":input[type=number], textarea").each(function(){
                if(!$(this).hasClass("is-invalid-input")){
                    inputArray[$(this).attr('id')] = $(this).val();
                    clearArray.push($(this));
                }else{
                    isValid = false;
                }
            });
            $(this).find(":input[type=file]").each(function(){
                if(!$(this).hasClass("is-invalid-input")){
                    if($(this).attr('id') == "thumbnail"){
                        clearArray.push($(this));
                        formData.append("image", this.files[0]);
                    }else{
                        clearArray.push($(this));
                        for(var i=0; i < this.files.length; i++){
                            formData.append("gallery["+i+"]", this.files[i]);
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
        formData.append("function", "create");

        if(isValid == true){
            $.ajax({
                url:"scripts/productManagement.php",
                method:"POST",
                contentType:false,
                processData:false,
                data: formData,
            }).done(function(data){
                console.log(data)
                if(data == "true"){
                    toastr.success("Product created successfully!");
                }else{
                    console.log(data);
                    toastr.error("Internal error!");
                }
            });
            //Clear form
            clearArray.forEach(function(e){
                reset(e);
            });
            $('#tag-table > tbody > tr').each(function(i, row){
                $(this).remove();
            });
            $("#thumbnail-image").attr("src", "");
            $("#thumbnail-image").hide();
        }else{
            toastr.error("Invalid information entered! Please amend the errors in the form.");
        }
    }else{
        toastr.error("Form not filled in correctly. Please try again.");
    }
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

window.reset = function(e){
    e.wrap('<form>').closest('form').get(0).reset();
    e.unwrap();
}

function addCategory(){
    var category = $('[name="categoryName"]').val();
    var parameters = {};
    parameters['function'] = "addCategory";
    parameters['category'] = category;
    $.ajax({
        url:"scripts/productManagement.php",
        method:"POST",
        data:parameters
    }).done(function(data){
        if(data > 0){
            toastr.success("Success! Category has been added.");
        }else if(data == "category-exist"){
            toastr.error("Error! Category already exists.");
        }else{
            console.log(data);
        }
    });
}