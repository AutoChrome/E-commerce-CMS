<div class="grid-container cart-container">
    <div class="grid-x">
    </div>
    <div class="grid-x">
        <div class="cell large-12">
            <?php
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }

            if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == true){
                $cart = $databaseHandler->getCart();
                $total = 0;
                foreach($cart as $product){
                    $image = null;

                    if(isset($_GET['coupon'])){
                        $coupon = $databaseHandler->checkCoupon($_GET['coupon']);
                        if($coupon != "false"){
                            $total += (($product['products_cost'] - ($product['products_cost'] * ($coupon[0]['amount'] / 100))) * $product['quantity']);
                        }else{
                            $total += ($product['products_cost'] * $product['quantity']);
                        }
                        
                    }else{
                        $total += ($product['products_cost'] * $product['quantity']);
                    }
                       $dir = "img/products/" . $product['products_id'];
                       if(file_exists($dir . "/thumbnail.png")){
                           $image = $dir . "/thumbnail.png";
                       }else if(file_exists($dir . "/thumbnail.jpg")){
                           $image = $dir . "/thumbnail.jpg";
                       }

                       echo ' 
                    <div class="callout">
                        <div class="grid-x">
                            <div class="cell large-10">
                                <div class="grid-x">
                                    <div class="cell large-3">
                                        <img src="'.($image != null ? $image : "https://via.placeholder.com/200x150").'" class="product-image">
                                    </div>
                                    <div class="cell large-9">
                                        <big><a href="product.php?id='. $product['products_id'] .'">'. $product['name'] .'</a></big><br> 
                                        Cost: £'. number_format($product['products_cost'], 2);
                       if(isset($_GET['coupon'])){
                           if($coupon != "false"){
                               echo "<br>Discount price: £" . number_format($product['products_cost'] - ($product['products_cost'] * ($coupon[0]['amount'] / 100)), 2);
                           }
                       }
                       echo '</div>
                                </div>
                            </div>
                            <div class="cell large-2" name="product">
                                Current quantity: '. $product['quantity'] .'
                                <label>Quantity: <input type="text" value="'.$product['quantity'].'" data-cart-id="'.$product['cart_id'].'" data-cart-validation></label>
                                <input type="hidden" value="'. $product['cart_id'] .'">
                                <input name="product_id" type="hidden" value="'. $product['products_id'] .'">
                                <button onclick="updateQuantity('. $product['cart_id'] .'); return false;" class="button primary">Update</button>
                                <button class="button alert" onclick="removeProduct('. $product['cart_id'] .'); return false;">Remove</button>
                            </div>
                        </div>
                    </div>';
                       $image = null;
                       }
                       }else{
                           $total = 0;
                           $cart = $databaseHandler->getCart()['cart'];
                           if(sizeof($cart) > 0){
                               $parameters = array();
                               $idSql = "(";
                               foreach($cart as $product){
                                   $idSql .= ":id" . $product[0] . ", ";
                                   $parameters['id' . $product[0]] = $product[0];
                               }
                               $idSql = substr($idSql, 0, -2);
                               $idSql .= ")";
                               $sql = "SELECT * FROM products WHERE id IN" . $idSql;
                               $data = $databaseHandler->getProductsFromId($sql, $parameters);

                               $counter = 0;
                               foreach($data as $product){
                                   $quantity = explode(",", $cart[$counter])[1];
                                   $image = null;
                                   $total += ($product['cost'] * $product['quantity']);
                                   $dir = "img/products/" . $product['id'];
                                   if(file_exists($dir . "/thumbnail.png")){
                                       $image = $dir . "/thumbnail.png";
                                   }else if(file_exists($dir . "/thumbnail.jpg")){
                                       $image = $dir . "/thumbnail.jpg";
                                   }

                                   if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIN'] == true){
                                       echo ' 
                    <div class="callout">
                        <div class="grid-x">
                            <div class="cell large-10">
                                <div class="grid-x">
                                    <div class="cell large-3">
                                        <img src="'.($image != null ? $image : "https://via.placeholder.com/200x150").'" class="product-image">
                                    </div>
                                    <div class="cell large-9">
                                        <big><a href="product.php?id='. $product['products_id'] .'">'. $product['name'] .'</a></big><br> 
                                        Cost: £'. number_format($product['cost'], 2) .'
                                    </div>
                                </div>
                            </div>
                            <div class="cell large-2" name="product">
                                Current quantity: '. $quantity .'
                                <label>Quantity: <input type="text" value="'.$quantity .'" data-cart-validation data-cart-id="'. $product['id'] .'"></label>
                                <input type="hidden" value="">
                                <input name="product_id" type="hidden" value="'. $product['id'] .'">
                                <button class="button primary" onclick="updateSessionQuantity('. $product['id'] .'); return false;">Update</button>
                                <button class="button alert" onclick="removeSessionProduct('. $product['id'] .'); return false;">Remove</button>
                            </div>
                        </div>
                    </div>';
                                       $image = null;
                                       $counter++;
                                   }else{
                                       echo ' 
                    <div class="callout">
                        <div class="grid-x">
                            <div class="cell large-10">
                                <div class="grid-x">
                                    <div class="cell large-3">
                                        <img src="'.($image != null ? $image : "https://via.placeholder.com/200x150").'" class="product-image">
                                    </div>
                                    <div class="cell large-9">
                                        <big><a href="product.php?id='. $product['id'] .'">'. $product['name'] .'</a></big><br> 
                                        Cost: £'. number_format($product['cost'], 2) .'
                                    </div>
                                </div>
                            </div>
                            <div class="cell large-2" name="product">
                                Current quantity: '. $quantity .'
                                <label>Quantity: <input type="text" value="'.$quantity .'" data-cart-validation data-cart-id="'. $product['id'] .'"></label>
                                <input type="hidden" value="">
                                <input name="product_id" type="hidden" value="'. $product['id'] .'">
                                <button class="button primary" onclick="updateSessionQuantity('. $product['id'] .'); return false;">Update</button>
                                <button class="button alert" onclick="removeSessionProduct('. $product['id'] .'); return false;">Remove</button>
                            </div>
                        </div>
                    </div>';
                                       $image = null;
                                       $counter++;
                                   }
                               }
                           }
                       }
            ?>
        </div>
        <div class="cell large-12">
            <div class="grid-x">
                <div class="cell large-4">
                    <label>
                        Coupon code
                        <input type="text" name="coupon-input">
                        <div class="callout success" hidden>
                            asdf
                        </div>
                        <div class="callout alert" hidden>
                            sadf
                        </div>
                        <button class="button primary" onclick="addCoupon(); return false;">Add coupon</button>
                    </label>
                </div>
                <div class="cell large-12" id="payment-radio-group">
                    Payment method:
                    <label><input type="radio" id="paypal" name="paymentMethod" disabled> PayPal</label>
                    <label><input type="radio" id="stripe" name="paymentMethod"> Bank Transfer (Stripe)</label>
                </div>
                <div class="cell large-12">
                    Shipping:
                    <?php
                       $shipping = $databaseHandler->getShipping();
                       foreach($shipping as $method){
                           echo '<label><input type="radio" name="shipping" data-shipping-id="'. $method['id'] .'">'. $method['shipping_type'] .' - £'. number_format($method['shipping_cost'], 2) .' <small>Expected delivery: '. $method['expected_delivery'] .'</small></label>';
                       }
                    ?>
                </div>
                <div class="cell large-12">
                    <?php
                       echo 'Total: £' . number_format($total, 2) . ' <sub>(Excluding shipping)</sub><br>';
                    ?>
                </div>
                <div class="cell large-12">
                    <input type="hidden" name="user_id" <?php if(isset($_SESSION['id'])){echo 'value="'. $_SESSION['id'] .'"';} ?> >
                    <button class="button primary" <?php if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == true){echo 'onclick="createPurchase(); return false;"';}else{echo "disabled";}?>>Checkout</button>
                    <?php if(!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] == false){echo "<sub>You must login to proceed to checkout. All products in cart will be migrated to account upon login.</sub>";}?>
                </div>
            </div>
        </div>
    </div>
</div>