<?php
parse_str($_SERVER['QUERY_STRING'], $options);
if(isset($options['category'])){
    $options['section_name'] = $options['category'];
    unset($options['category']);
}else{
    $options['section_name'] = "All";
}
$options = removePageOptions($options);
if(isset($_GET['page']) && $_GET['page'] < 1){
    $_GET['page'] = 1;
}
if(isset($_GET['category']) && isset($_GET['product'])){
    if(isset($_GET['page'])){
        $products = $databaseHandler->getProducts(10, (10*$_GET['page'])-10, $options);
    }else{
        $products = $databaseHandler->getProducts(10, 0, $options);
    }
}else if(isset($_GET['category'])){
    if(isset($_GET['page'])){
        $products = $databaseHandler->getProducts(10, (10*$_GET['page'])-10, $options);
    }else{
        $products = $databaseHandler->getProducts(10, 0, $options);
    }
}else{
    if(isset($_GET['page'])){
        $products = $databaseHandler->getProducts(10, (10*$_GET['page'])-10, $options);
    }else{
        if(isset($_GET['product'])){
            $products = $databaseHandler->getProducts(10, 0, $options);
        }else{
            $products = $databaseHandler->getProducts(10, 0, $options);
        }

    }
}

if($products[0]["status"] == "success"){
    $products = $products[1];
}

function removePageOptions($options){
    if(array_key_exists("product", $options)){
        $options['name'] = $options['product'];
        unset($options['product']);
    }
    if (array_key_exists("page", $options)) {
        unset($options['page']);
    }
    if (array_key_exists("limit", $options)) {
        unset($options['limit']);
    }
    if (array_key_exists("sortBy", $options)) {
        unset($options['sortBy']);
    }
    if (array_key_exists("direction", $options)) {
        unset($options['direction']);
    }
    return $options;
}
?>

<div class="container-full">
    <div class="grid-container full">
        <div class="grid-x grid-margin-x" style="margin-right:0px;">
            <div class="cell large-2 filters">
                <form id="searchForm">
                    <div class="grid-container full">
                        <div class="grid-x grid-padding-x">
                            <div class="medium-6 cell">
                                <label>Price minimum
                                    <input type="number" placeholder="2" name="min" <?php if(isset($_GET['min'])){ echo "value=" . $_GET['min'];}?> >
                                </label>
                            </div>
                            <div class="medium-6 cell">
                                <label>Price maximum
                                    <input type="number" placeholder="2" name="max" <?php if(isset($_GET['max'])){ echo "value=" . $_GET['max'];}?>>
                                </label>
                            </div>
                        </div>
                        <hr>
                        <!--
                        <div class="grid-x grid-padding-x">
                            <div class="medium-6 cell">
                                <label>Rating minimum
                                    <input type="number" placeholder="1" name="ratingMin">
                                </label>
                            </div>
                            <div class="medium-6 cell">
                                <label>Rating maximum
                                    <input type="number" placeholder="5" name="ratingMax">
                                </label>
                            </div>
                        </div>
                        -->
                        <div class="grid-x grid-padding-x">
                            <div class="medium-6 cell">
                                <button class="button primary" onclick="searchProduct(); return false;">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <?php echo "<input type=hidden name='product-count' value=". sizeof($products) .">";?>
            <div class="cell large-10 product-content">
                <div class="grid-x">
                    <?php
                    if(sizeof($products) > 0){
                        foreach($products as $product){
                            echo '<div class="cell large-12 product-card">';
                            echo '<div class="grid-x" data-product-id="'. $product->id .'">';
                            echo '<div class="cell large-2 product-card-image">';
                            $dir  = "img/products/" . $product->id . "/";
                            if(file_exists($dir . "thumbnail.png")){
                                echo '<a href="product.php?id='. $product->id .'"><img src="'.$dir."thumbnail.png".'"></a>';
                            }else if(file_exists($dir . "thumbnail.jpg")){
                                echo '<a href="product.php?id='. $product->id .'"><img src="'.$dir."thumbnail.jpg".'"></a>';
                            }else{
                                echo '<a href="product.php?id='. $product->id .'"><img src="https://via.placeholder.com/250x150"></a>';
                            }

                            echo '</div>';
                            echo '<div class="cell large-10 product-card-information">';
                            echo '<div class="grid-x">';
                            echo '<div class="cell large-12 product-card-title">';
                            echo '<big><a href="product.php?id='.$product->id.'">'.$product->name.'</a></big>';
                            echo '</div>';
                            echo '<div class="cell large-10 product-card-rating">';
                            $rating = $databaseHandler->getProductRating($product->id);
                            
                            if($rating != null){
                                $starCounter = 0;
                                for($i = 0; $i < round($rating[0][0]); $i++){
                                    $starCounter++;
                                    echo '<i class="fas fa-star"></i>';
                                }
                                while($starCounter < 5){
                                    echo '<i class="far fa-star"></i>';
                                    $starCounter++;
                                }
                            }
                            echo '</div>';
                            echo '<div class="cell large-12 product-card-title">';
                            echo '£' . number_format($product->cost, 2);
                            echo '</div>';
                            echo '<div class="cell large-12 product-card-title">';
                            echo 'In stock: ' . $product->quantity;
                            echo '</div>';
                            echo '<div class="cell large-1">';
                            if($product->quantity > 0){
                                echo '<label>Quantity: <input type="number" value=1></label>';
                            }else{
                                echo '<label>Quantity: <input type="number" disabled></label>';
                            }
                            echo '</div>';
                            echo '<div class="cell large-12 product-card-title">';
                            echo '<button class="button primary" '.($product->quantity > 0 ? 'onclick="addProduct('.$product->id.'); return false;"' : 'onclick="" disabled').'>'.($product->quantity > 0 ? 'Add to basket' : 'Out of stock').'</button>';
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                        }
                    }
                    ?>
                </div>
                <div class="grid-x margin">
                    <div class="ui pagination menu">
                        <?php
                        parse_str($_SERVER['QUERY_STRING'], $options);
                        if(isset($options['category'])){
                            $options['section_name'] = $options['category'];
                            unset($options['category']);
                        }else{
                            $options['section_name'] = "All";
                        }
                        if(isset($options['product'])){
                            $options['name'] = $options['product'];
                            unset($options['product']);
                        }
                        $options = removePageOptions($options);
                        $count = $databaseHandler->countProductsByName($options);
                        $limit = 10;
                        if($count > 0){
                            if(isset($_GET['limit'])){
                                $limit = $_GET['limit'];
                            }
                            $pageTotal = ceil($count/$limit)+1;
                            parse_str($_SERVER['QUERY_STRING'], $queries);
                            for($i = 1; $i < $pageTotal; $i++){
                                $queries['page'] = $i;
                                $rebuild = http_build_query($queries);
                                if(isset($_GET['page']) && $i == $_GET['page']){
                                    echo '<a href="?'.$rebuild.'" aria-current="true" aria-disabled="false" type="pageItem" class="active item">'.$i.'</a>';
                                }else{
                                    echo '<a href="?'.$rebuild.'" aria-current="false" aria-disabled="false" type="pageItem" class="item">'.$i.'</a>';
                                }
                            }
                        }else{
                            parse_str($_SERVER['QUERY_STRING'], $queries);
                            $queries['page'] = 1;
                            $rebuild = http_build_query($queries);
                            echo '<a href="?'.$rebuild.'" aria-current="true" aria-disabled="false" type="pageItem" class="active item">1</a>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>