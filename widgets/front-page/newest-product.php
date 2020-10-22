<?php
$dir = $_SERVER['DOCUMENT_ROOT'] . "/E-commerce-CMS/widgets/Widget.php";
include_once("objects/DatabaseHandler.php");
require_once($dir);
class NewestProduct implements Widget{
    function __construct(){

    }

    function draw(){
        $databaseHandler = new DatabaseHandler();
        $data = $databaseHandler->getLatestProducts();
        echo
            '
    <div class="grid-container">
        <div class="grid-x">
            <div class="cell text-center">
                <h2>Our Newest Products</h2>
                <hr>
            </div>
        </div>
    </div>
    <div class="grid-container">
        <div class="grid-x grid-padding-x small-up-2 medium-up-3">
        ';
        foreach($data as $product){
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
    }
}

$newest_product = new NewestProduct();
$newest_product->draw();
?>