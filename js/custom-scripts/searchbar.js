function submitSearch(){
    $category = $("#searchCategory").val();
    $product = $("#search").val();
    console.log($product);
    console.log($category);
    $url = "search.php?";
    if($category.length > 0){
        $url += "category=" + $category;
    }
    if($product.length > 0){
        $url += "&product=" + $product;
    }
    window.location.href = $url;
}

$("#search").keypress(function(event){
    var keycode = (event.keyCode ? event.keyCode : event.which);
    if(keycode == 13){
        submitSearch();
    }
});