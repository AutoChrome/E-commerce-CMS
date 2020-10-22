<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<div class="grid-container full product-border">
    <div class="grid-x">
        <div class="cell large-10">
            <div class="grid-container full">
                <div class="grid-x">
                    <div class="cell large-4">
                        <div class="grid-x">
                            <div class="cell large-12">
                                <?php
                                if(file_exists("img/products/". $_GET['id'] . "/thumbnail.png")){
                                    echo "<img src='img/products/".$_GET['id']."/thumbnail.png'>";
                                }else if(file_exists("img/products/". $_GET['id'] . "/thumbnail.jpg")){
                                    echo "<img class='product-thumbnail' src='img/products/".$_GET['id']."/thumbnail.jpg'>";
                                }else{
                                    echo "<img src='https://via.placeholder.com/400' class='product-widget-image'>";
                                }
                                ?>
                            </div>
                            <div class="cell large-12 gallery">
                                <div class="grid-x grid-margin-x" style="">
                                    <?php
                                    $path = "img/products/" . $product->id . "/gallery/";
                                    if(file_exists($path)){
                                        $dir = array_values(array_diff(scandir($path), array('.', '..')));
                                        if(sizeof($dir) > 0){
                                            foreach($dir as $image){
                                                echo "<div class='cell large-3 gallery-margin'><img class='product-image' src='".$path . $image ."'></div>";
                                            }
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="cell large-8" >
                        <?php
                        //print_r($product);
                        echo "<big style='font-size:34px'>" . $product->name ."</big>";
                        ?>
                        <br>
                        <?php 
                        $rating = $databaseHandler->getProductRating($_GET['id']);
                        if($rating[0][0] > 0){
                            $ratingCounter = 0;
                            for($i = 0; $i < round($rating[0][0]); $i++){
                                echo '<i class="fas fa-star"></i>';
                                $ratingCounter++;
                            }
                            while($ratingCounter < 5){
                                echo '<i class="far fa-star"></i>';
                                $ratingCounter++;
                            }
                        }else{
                            for($i = 0; $i < 5; $i++){
                                echo '<i class="far fa-star"></i>';
                            }
                        }
                        ?>
                        <br>
                        <label>Leave a rating: <br><input type="number" name="rating-input" max=5 style="width:65px;"></label><br><button class="button primary" <?php if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == true){echo "onclick='rateProduct(". $_GET['id'] ."); return false;'";}else{echo "disabled";} ?> >Submit</button>
                        <hr>
                        <br>
                        <?php echo "£" . number_format($product->cost, 2)?>
                        <br>
                        <div class="callout large">
                            <?php echo $product->description?>
                        </div>
                        <br>
                    </div>
                    <div class="cell large-4 gallery">
                    </div>
                </div>
            </div>
        </div>
        <div class="cell large-2" style="padding:1rem;">
            In stock: <?php $stock = $databaseHandler->getProductStock($_GET['id']); echo $stock[0]['quantity'];?>
            <label>Quantity: <input type=number value=1 <?php echo "data-product-id='". $_GET['id'] ."'"?> ></label>
            <button class="button primary" <?php echo "onclick='addProduct(". $_GET['id'] ."); return false;'"?> >Add to basket</button>
        </div>
    </div>
</div>