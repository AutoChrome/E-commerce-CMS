<?php
include_once("../objects/DatabaseHandler.php");

$databaseHandler = new DatabaseHandler();

if(isset($_POST['function'])){
    if($_POST['function'] == "updateSessionQuantity"){
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if(isset($_SESSION['cart'])){
            if($_POST['quantity'] > 0){
                $cart = explode("|", $_SESSION['cart']);

                for($i = 0; $i < sizeof($cart); $i++){
                    if(explode(",", $cart[$i])[0] == $_POST['product_id']){
                        $stock = $databaseHandler->getProductQuantity($_POST['product_id']);

                        if($_POST['quantity'] <= $stock[0]['quantity']){
                            $cart[$i] = explode(",", $cart[$i])[1] . "," . $_POST['quantity'];
                        }else{
                            echo "not-enough-stock";
                        }
                    }
                }

                $_SESSION['cart'] = implode("|", $cart);
                echo "true";
            }else{
                echo "must-be-greater-than-0";
            }
        }
    }
    if($_POST['function'] == "removeSessionProduct"){
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if(isset($_SESSION['cart'])){
            $cart = explode("|", $_SESSION['cart']);
            for($i = 0; $i < sizeof($cart); $i++){
                if(explode(",", $cart[$i][0] == $_POST['product_id'])){
                    unset($cart[$i]);
                }
            }
            if(sizeof($cart) > 0){
                $_SESSION['cart'] = implode("|", $cart);
            }else{
                unset($_SESSION['cart']);
            }
            echo "true";
        }

    }
    if($_POST['function'] == "updateQuantity"){
        if($_POST['quantity'] < 1){
            echo "false";
        }else{
            $databaseHandler->updateCartQuantity($_POST['cart_id'], $_POST['quantity']);
        }
    }else if($_POST['function'] == "removeProduct"){
        if($databaseHandler->removeProductFromCart($_POST['cart_id'])){
            echo "true";
        }else{
            echo "false";
        }
    }else if($_POST['function'] == "addToBasket"){
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if(isset($_POST['quantity']) && $_POST['quantity'] > 0 && isset($_POST['id']) && $_POST['id'] > 0){
            $stock = $databaseHandler->getProductQuantity($_POST['id']);
            if($_POST['quantity'] <= $stock[0]['quantity']){
                if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == true){
                    $databaseHandler->addToCart($_SESSION['id'], $_POST['id'], $_POST['quantity']);
                }else{
                    if(isset($_SESSION['cart'])){
                        $products = explode("|", $_SESSION['cart']);
                        for($i = 0; $i < sizeof($products); $i++){
                            $data = explode(",", $products[$i]);
                            if($data[0] == $_POST['id']){
                                if($stock[0]['quantity'] >= $data[1] + $_POST['quantity']){
                                    $data[1] = $data[1] + $_POST['quantity'];
                                    $array = implode(",", $data);
                                    $products[$i] = $array;
                                    $_SESSION['cart'] = implode("|", $products);
                                    return;
                                }else{
                                    echo "not-enough-stock";
                                    return;
                                }
                            }
                        }
                        $_SESSION['cart'] = $_SESSION['cart'] .= "|" . $_POST['id'] . "," . $_POST['quantity'];
                        echo "true";
                    }else{
                        $_SESSION['cart'] = $_POST['id'] . "," . $_POST['quantity'];
                        echo "true";
                    }
                }
            }else{
                echo "not-enough-stock";
            }
        }else{
            echo "false";
        }
    }else if($_POST['function'] == "purchaseStripe"){   
        include("../Stripe/lib/StripeObject.php");
        include("../Stripe/lib/Error/Base.php");
        include("../Stripe/lib/Error/InvalidRequest.php");
        include("../Stripe/lib/ApiOperations/Request.php");
        include("../Stripe/lib/ApiOperations/Create.php");
        include("../Stripe/lib/ApiOperations/Retrieve.php");
        include("../Stripe/lib/ApiResource.php");
        include("../Stripe/lib/ApiOperations/All.php");
        include("../Stripe/lib/ApiOperations/Delete.php");
        include("../Stripe/lib/ApiOperations/NestedResource.php");
        include("../Stripe/lib/ApiOperations/Update.php");
        include("../Stripe/lib/AccountLink.php");
        include("../Stripe/lib/AlipayAccount.php");
        include("../Stripe/lib/ApplePayDomain.php");
        include("../Stripe/lib/ApplicationFee.php");
        include("../Stripe/lib/SingletonApiResource.php");
        include("../Stripe/lib/BalanceTransaction.php");
        include("../Stripe/lib/BankAccount.php");
        include("../Stripe/lib/BitcoinReceiver.php");
        include("../Stripe/lib/BitcoinTransaction.php");
        include("../Stripe/lib/Card.php");
        include("../Stripe/lib/Charge.php");
        include("../Stripe/lib/CountrySpec.php");
        include("../Stripe/lib/Coupon.php");
        include("../Stripe/lib/CreditNote.php");
        include("../Stripe/lib/Customer.php");
        include("../Stripe/lib/Discount.php");
        include("../Stripe/lib/Dispute.php");
        include("../Stripe/lib/EphemeralKey.php");
        include("../Stripe/lib/Event.php");
        include("../Stripe/lib/ExchangeRate.php");
        include("../Stripe/lib/ApplicationFeeRefund.php");
        include("../Stripe/lib/File.php");
        include("../Stripe/lib/FileLink.php");
        include("../Stripe/lib/Invoice.php");
        include("../Stripe/lib/InvoiceItem.php");
        include("../Stripe/lib/InvoiceLineItem.php");
        include("../Stripe/lib/Issuing/Card.php");
        include("../Stripe/lib/Issuing/CardDetails.php");
        include("../Stripe/lib/Issuing/Cardholder.php");
        include("../Stripe/lib/Issuing/Dispute.php");
        include("../Stripe/lib/Issuing/Transaction.php");
        include("../Stripe/lib/LoginLink.php");
        include("../Stripe/lib/Order.php");
        include("../Stripe/lib/OrderItem.php");
        include("../Stripe/lib/OrderReturn.php");
        include("../Stripe/lib/PaymentIntent.php");
        include("../Stripe/lib/PaymentMethod.php");
        include("../Stripe/lib/Payout.php");
        include("../Stripe/lib/Person.php");
        include("../Stripe/lib/Product.php");
        include("../Stripe/lib/Plan.php");
        include("../Stripe/lib/Radar/ValueList.php");
        include("../Stripe/lib/Radar/ValueListItem.php");
        include("../Stripe/lib/Recipient.php");
        include("../Stripe/lib/RecipientTransfer.php");
        include("../Stripe/lib/Refund.php");
        include("../Stripe/lib/Reporting/ReportRun.php");
        include("../Stripe/lib/Reporting/ReportType.php");
        include("../Stripe/lib/Review.php");
        include("../Stripe/lib/SKU.php");
        include("../Stripe/lib/Sigma/ScheduledQueryRun.php");
        include("../Stripe/lib/Source.php");
        include("../Stripe/lib/SourceTransaction.php");
        include("../Stripe/lib/Subscription.php");
        include("../Stripe/lib/SubscriptionItem.php");
        include("../Stripe/lib/SubscriptionSchedule.php");
        include("../Stripe/lib/SubscriptionScheduleRevision.php");
        include("../Stripe/lib/TaxId.php");
        include("../Stripe/lib/TaxRate.php");
        include("../Stripe/lib/ThreeDSecure.php");
        include("../Stripe/lib/Terminal/ConnectionToken.php");
        include("../Stripe/lib/Terminal/Location.php");
        include("../Stripe/lib/Terminal/Reader.php");
        include("../Stripe/lib/Token.php");
        include("../Stripe/lib/TopUp.php");
        include("../Stripe/lib/Transfer.php");
        include("../Stripe/lib/TransferReversal.php");
        include("../Stripe/lib/UsageRecord.php");
        include("../Stripe/lib/UsageRecordSummary.php");
        include("../Stripe/lib/WebhookEndpoint.php");
        include("../Stripe/lib/Util/Set.php");
        include("../Stripe/lib/Issuing/Authorization.php");
        include("../Stripe/lib/IssuerFraudRecord.php");
        include("../Stripe/lib/Balance.php");
        include("../Stripe/lib/Account.php");
        include("../Stripe/lib/Collection.php");
        include("../Stripe/lib/Stripe.php");
        include("../Stripe/lib/Util/RandomGenerator.php");
        include("../Stripe/lib/Util/Util.php");
        include("../Stripe/lib/Util/CaseInsensitiveArray.php");
        include("../Stripe/lib/HttpClient/ClientInterface.php");
        include("../Stripe/lib/HttpClient/CurlClient.php");
        include("../Stripe/lib/Util/RequestOptions.php");
        include("../Stripe/lib/ApiResponse.php");
        include("../Stripe/lib/ApiRequestor.php");
        include("../Stripe/lib/Checkout/Session.php");

        $dir = $_SERVER['DOCUMENT_ROOT'] . "/E-commerce-CMS/configs/config.json";
        $json = file_get_contents($dir);

        $config = json_decode($json, true);

        \Stripe\Stripe::setApiKey($config[1]['stripe-secret']);

        if(isset($_POST['products']) && sizeof($_POST['products'] > 0)){
            if(isset($_POST['shipping_id']) && $_POST['shipping_id'] > 0){
                $productQuery = "(";
                $productArray = array();

                $counter = 0;

                foreach($_POST['products'] as $product){
                    $productArray['id'.$product['product_id']] = $product['product_id'];
                    $productQuery .= ":id" . $product['product_id'] . ", ";
                }

                $productQuery = substr($productQuery, 0, -2);

                $productQuery .= ")";

                $sql = "SELECT products.name, products.cost, products.description FROM products WHERE id IN " . $productQuery;

                $result = $databaseHandler->getProductsFromId($sql, $productArray);

                $line_items = array();

                $counter = 0;

                $shipping_id = $_POST['shipping_id'];

                $shipping = $databaseHandler->getShippingCost($shipping_id);

                if(isset($_POST['coupon'])){
                    $coupon = $databaseHandler->checkCoupon($_POST['coupon']);
                }

                foreach($result as $product){
                    if($coupon != "false"){
                        array_push($line_items, array('name'=>$product['name'], 'description'=>$product['description'], 'amount'=>(($product['cost'] - ($product['cost'] * ($coupon[0]['amount'] / 100))) * 100), 'currency'=>'gbp', 'quantity'=>$_POST['products'][$counter]['quantity']));
                    }else{
                        array_push($line_items, array('name'=>$product['name'], 'description'=>$product['description'], 'amount'=>($product['cost'] * 100), 'currency'=>'gbp', 'quantity'=>$_POST['products'][$counter]['quantity']));
                    }
                    $counter++;
                }

                if($shipping['shipping_cost'] > 0){
                    array_push($line_items, array('name'=>$shipping['shipping_type'], 'description'=>$shipping['expected_delivery'], 'amount'=>($shipping['shipping_cost'] * 100), 'currency'=>'gbp', 'quantity'=>1));
                }

                if (session_status() == PHP_SESSION_NONE) {
                    session_start();
                }

                $user_id = $_SESSION['id'];

                $success_url = "http://" . $_SERVER['SERVER_NAME'] . '/E-commerce-CMS/checkoutComplete.php';
                if($coupon != "false"){
                    $session = Stripe\Checkout\Session::create([
                        'payment_method_types' => ['card'],
                        'line_items' => $line_items,
                        'client_reference_id' => $user_id . "," . $shipping_id . "," . $coupon[0]['id'],
                        'success_url' => $success_url,
                        'cancel_url' => 'https://example.com/cancel',
                    ]);
                }else{
                    $session = Stripe\Checkout\Session::create([
                        'payment_method_types' => ['card'],
                        'line_items' => $line_items,
                        'client_reference_id' => $user_id . "," . $shipping_id,
                        'success_url' => $success_url,
                        'cancel_url' => 'https://example.com/cancel',
                    ]);
                }
                $parameters = array("id" => $session['id'], "publishable" => $config[1]['stripe-publishable']);
                echo json_encode($parameters);
            }else{
                echo "no-shipping";
            }
        }else{
            echo "no-items";
        }
    }
    if($_POST['function'] == "checkCoupon"){
        if($databaseHandler->checkCoupon($_POST['coupon']) == "false"){
            echo "false";
        }
    }
    if($_POST['function'] == "rateProduct"){
        if($databaseHandler->rateProduct($_POST['id'], $_POST['rating'])){
            echo "true";
        }else{
            echo "false";
        }
    }
}
?>