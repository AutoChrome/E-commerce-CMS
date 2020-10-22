<?php

if(isset($_COOKIE['products'])){
    $tagList = explode("|", $_COOKIE['products']);
    if(sizeof($tagList >= 3)){
        shuffle($tagList);
        $tagArray = array("tag1" => "%" . $tagList[0] . "%", "tag2" => "%" . $tagList[1] . "%", "tag3" => "%" . $tagList[3] . "%");
        $sql = "SELECT * FROM products WHERE tags LIKE :tag1 OR tags LIKE :tag2 OR tags LIKE :tag3 LIMIT 6";
        $result = $databaseHandler->getProductsFromId($sql, $tagArray);

        echo
            '
    <div class="grid-container">
        <div class="grid-x">
            <div class="cell text-center">
                <h2>Recommended Products</h2>
                <hr>
            </div>
        </div>
    </div>
    <div class="grid-container">
        <div class="grid-x grid-padding-x small-up-2 medium-up-3">
        ';
        foreach($result as $product){
            echo '<div class="cell">';
            echo '<div class=""card card-padding>';
            if(file_exists("img/products/" . $product['id'] . "/thumbnail.jpg")){
                echo '<img class="thumbnail" src="img/products/' . $product['id'] . '/thumbnail.jpg">';
            }else if(file_exists("img/products/" . $product['id'] . "/thumbnail.png")){
                echo '<img class="thumbnail" src="img/products/' . $product['id'] . '/thumbnail.png">';
            }else{
                echo '<img class="thumbnail" src="https://placehold.it/300x400">';                       
            }
            echo '<h5>'. $product['name'] .'</h5>';
            echo '<p>£'. number_format($product['cost'], 2) .'</p>';
            echo '<a class="button primary" href="product.php?id='. $product['id'] .'">View product</a>';
            echo '</div>';
            echo '</div>';
        }
        echo '
        </div>
    </div>
    ';
    }else{
        echo "<h1>We currently do not have any recommendations for you yet... Please search for some products!</h1>";
    }
}else{
        echo "<h1>We currently do not have any recommendations for you yet... Please search for some products!</h1>";
}
?>