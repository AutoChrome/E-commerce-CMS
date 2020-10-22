//Settings
function updateIni(object){
    var config = {};
    $(":input", object[0]).each(function(e){
        var input = $(this);
        if(input.prop("tagName") != "BUTTON"){
            config[input.attr("name")] = input.val();
        }
    });

    $.ajax({
        url: "scripts/functions.php",
        method: "POST",
        dataType: "text",
        data: {function:"update_ini_file", config:config},
    }).done(function(data){
        console.log(data);
    });
}

function saveLayout(){
    var primary_colour = $("[name='primary-colour']").val();
    var secondary_colour = $("[name='secondary-colour']").val();
    var button_colour = $("[name='button-colour']").val();
    var button_hover_colour = $("[name='button-hover-colour']").val();
    if(primary_colour.match(/#([a-f]|[A-F]|[0-9]){3}(([a-f]|[A-F]|[0-9]){3})?\b/) && secondary_colour.match(/#([a-f]|[A-F]|[0-9]){3}(([a-f]|[A-F]|[0-9]){3})?\b/) && button_colour.match(/#([a-f]|[A-F]|[0-9]){3}(([a-f]|[A-F]|[0-9]){3})?\b/) && button_hover_colour.match(/#([a-f]|[A-F]|[0-9]){3}(([a-f]|[A-F]|[0-9]){3})?\b/)){
        var parameters = {};
        parameters['function'] = "updateColour";
        parameters['primary-colour'] = primary_colour;
        parameters['secondary-colour'] = secondary_colour;
        parameters['button-colour'] = button_colour;
        parameters['button-hover-colour'] = button_hover_colour;
        $.ajax({
            url:"scripts/functions.php",
            method:"POST",
            data:parameters
        }).done(function(data){
            console.log(data);
        });
    }else{
        toastr.error("Fields do not match the hex colour for CSS. Please amend this.");
    }
    
}

function submitStripeDetails(){
    var parameters = {};
    parameters['function'] = "updateStripe";
    parameters['publishable-key'] = $('[name="stripe-publishable-key"]').val();
    parameters['secret-key'] = $('[name="stripe-secret-key"]').val();
    console.log(parameters);
    $.ajax({
        url:"scripts/functions.php",
        method:"POST",
        data:parameters
    }).done(function(data){
        if(data == "success"){
            toastr.success("Success! changes have been made.");
        }else{
            toastr.error("There was an error...");
        }
        console.log(data);
    });
}

function addTextArea(){
    var size = "";
    $('div[name="textSize"]').children().each(function(){
        if($(this).hasClass("selected")){
            size = $(this)[0].innerHTML;
        }
    });
    if(size == ""){
        size = "Small";
    }

    var header = $('[name="headerText"]').val();
    var text = $('[name="mainText"]').val();
    if(size.length > 0 && header.length > 0 && text.length > 0){
        var parameters = {};
        parameters['function'] = "addCustomArea";
        parameters['size'] = size;
        parameters['header'] = header;
        parameters['text'] = text;

        $.ajax({
            url:"scripts/functions.php",
            method:"POST",
            data:parameters
        }).done(function(data){
            console.log(data);
        });
    }else{
        toastr.error("Error! The form was filled incorretly.");
    }

    console.log(size);
}

//Sortable area
$( function() {
    /* Toaster */
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        "progressBar": true,
        "positionClass": "toast-bottom-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
    /* End of toaster */
    $( "#enabled-widgets-list" ).sortable({
        connectWith: "ul",
        placeholder:{element: function(){
            return $('<div class="sortable-item"><div class="grid-container full"><div class="grid-x"><div class="cell small-3"><div class="item-circle"><p>?</p></div></div><div class="cell small-9"><li><p class="sortable-item-text">Widget will be moved here.</p></li></div></div></div></div>');
        },
                     update:function(){
                         return;
                     }},
        update: function(event, ui){
            sortList('enabled-widgets-list');
        },
        stop: function(event, ui){
            sortList('enabled-widgets-list');
        },
        receive:function(event, ui){

        }
    });
    $( "#all-widgets-list" ).disableSelection();
});

function saveSortOrder(){
    var list = [];
    $('#enabled-widgets-list').children().each(function(){
        list.push($(this).data("id"));
    });
    var parameters = {};

    parameters['function'] = "updateWidgetList";
    parameters['list'] = list;
    console.log(list);
    $.ajax({
        url:"scripts/functions.php",
        method:"POST",
        data:parameters
    }).done(function(data){
        console.log(data);
    });
}

function sortList(listToSort){
    for(i = 0; i < document.getElementById(listToSort).children.length; i++){
        document.getElementById(listToSort).children[i].children[0].children[0].children[0].children[0].innerHTML = "<p>" + (i+1) + "</p>";
    }
}


function createListItem(widget_name){
    var ul = document.getElementById('enabled-widgets-list');
    var sortable_item = document.createElement("div");
    sortable_item.classList.add("sortable-item");
    var grid_container = document.createElement("div");
    grid_container.classList.add("grid-container");
    grid_container.classList.add("full");
    var div = document.createElement("div");
    div.classList.add("grid-x");
    var cell = document.createElement('div');
    cell.classList.add("cell");
    cell.classList.add("small-3");
    var iCircle = document.createElement("div");
    iCircle.classList.add("item-circle");
    var p = document.createElement("p");
    p.appendChild(document.createTextNode("" + (document.getElementById("enabled-widgets-list").children.length + 1)));
    iCircle.appendChild(p);
    cell.appendChild(iCircle);
    div.appendChild(cell);
    var cell = document.createElement('div');
    cell.classList.add("cell");
    cell.classList.add("small-5");
    var li = document.createElement("li");
    li.dataset.value = widget_name;
    li.dataset.type = "widget";
    li.appendChild(document.createTextNode(widget_name));
    cell.appendChild(li);
    div.appendChild(cell);
    var cell = document.createElement('div');
    cell.classList.add("cell");
    cell.classList.add("small-3");
    var li = document.createElement("li");
    li.appendChild(document.createTextNode("widget"));
    cell.appendChild(li);
    div.appendChild(cell);
    var cell = document.createElement('div');
    cell.classList.add("cell");
    cell.classList.add("small-1");
    var button = document.createElement("button");
    button.onclick = function(e){deleteWidget(this);};
    button.classList.add("button");
    button.classList.add("alert");
    var icon = document.createElement("i");
    icon.classList.add("fas");
    icon.classList.add("fa-trash-alt");
    button.appendChild(icon);
    cell.appendChild(button);
    div.appendChild(cell);
    grid_container.appendChild(div);
    sortable_item.appendChild(grid_container);

    ul.appendChild(sortable_item);
    var parameters = {};
    parameters['function'] = "addWidget";
    parameters['url'] = widget_name;
    $.ajax({
        "url":"scripts/functions.php",
        method:"POST",
        data:parameters
    }).done(function(data){
        console.log(data);
    });
    return;
}

function deleteWidget(widget, id){
    widget = $(widget).parent().parent().parent().parent();
    widget.remove();
    var parameters = {};
    parameters['function'] = "deleteWidget";
    parameters['id'] = id;
    $.ajax({
        "url":"scripts/functions.php",
        method:"POST",
        data:parameters
    }).done(function(data){
        console.log(data);
    });
    sortList('enabled-widgets-list');
}

function deleteCustomArea(customArea, id){
    customArea = $(customArea).parent().parent().parent().parent();
    customArea.remove();
    sortList('enabled-widgets-list');
    var parameters = {};
    parameters['function'] = "deleteWidget";
    parameters['id'] = id;
    $.ajax({
        "url":"scripts/functions.php",
        method:"POST",
        data:parameters
    }).done(function(data){
        console.log(data);
    });
}
