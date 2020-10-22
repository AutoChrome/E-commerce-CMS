<?php 
include_once("../objects/product.php");
include_once("scripts/functions.php");

$databaseHandler = new DatabaseHandler();
parse_str($_SERVER['QUERY_STRING'], $options);
$options = removePageOptions($options);
?>
<div class="grid-container full">
    <div class="grid-x grid-margin-x">
        <div class="cell large-12 bd product-filter">
            <button data-display-filter class="blue">
                <h2>Transaction list</h2>
            </button>
        </div>
    </div>

    <div class="grid-x filter-content">
        <div class="cell large-12 bd">

        </div>
    </div>
    <div class="grid-x grid-margin-x">
        <div class="cell large-12">
            <table class="unstriped">
                <thead onselectstart="return false;">
                    <tr>
                        <td width="20">ID</td>
                        <td width="80">Customer</td>
                        <td width="80">Shipping type</td>
                        <td width="180">Payment method</td>
                        <td width="180">Status</td>
                        <td width="180">Date</td>
                        <td width="180">Coupon</td>
                    </tr>
                </thead>
                <tbody id="transaction-table">
                    <?php
                    $transactions = $databaseHandler->getTransactions("", 10);
                    //print_r($transactions);
                    foreach($transactions as $transaction){
                        $productList = explode("|", $transaction['products']);
                        echo "<tr>";
                        echo "<td width=150>".$transaction['id']."</td>";
                        echo "<td width=350>".$transaction['email']."</td>";
                        echo "<td width=350>".$transaction['shipping_type']."</td>";
                        echo "<td width=350>".$transaction['paymentMethod']."</td>";
                        echo "<td width=350><select data-select-status><option "; if($transaction['status'] == "Processing"){ echo "selected"; } echo ">Processing</option><option "; if($transaction['status'] == "Completed"){ echo "selected"; } echo ">Completed</option><option "; if($transaction['status'] == "Shipping"){ echo "selected"; } echo ">Shipping</option></select></td>";
                        echo "<td width=350>".date("d/m/Y", strtotime($transaction['date']))."</td>";
                        echo "<td width=350>".$transaction['coupon']."</td>";
                        echo "</tr>";
                        $idList = "";
                        foreach($productList as $product){
                            $getProduct = explode(",", $product);
                            $idList .= $getProduct[0] . ", ";
                        }

                        $idList = substr($idList, 0, -2);

                        $sql = "SELECT * FROM products WHERE ID IN(". $idList .")";

                        $data = $databaseHandler->getProductsFromId($sql, null);
                        $coupon = $databaseHandler->getCoupon($transaction['coupon']);
                        echo "<tr hidden data-transaction-details='". $transaction['id'] ."'><td colspan='6'>";
                        echo "<div class='grid-x'>";
                        echo "<div class='cell large-12'>";
                        echo "<table>";
                        echo "<thead>";
                        echo "<tr>";
                        echo "<td>Name</td>";
                        echo "<td>Description</td>";
                        echo "<td>Cost</td>";
                        echo "<td>Quantity</td>";
                        echo "</tr>";
                        echo "</thead>";
                        echo "<tbody>";
                        $cost = 0;
                        for($i = 0; $i < sizeof($data); $i++){
                            $cost += $data[$i]['cost'];
                            echo "<tr>";
                            echo "<td>". $data[$i]['name'] ."</td>";
                            echo "<td>". $data[$i]['description'] ."</td>";
                            echo "<td>£". number_format($data[$i]['cost'], 2) ."</td>";
                            foreach($productList as $quantity){
                                if(explode(",", $quantity)[0] == $data[$i]['id']){
                                    echo "<td>". explode(",", $quantity)[1] ."</td>";
                                }
                            }

                            echo "</tr>";
                        }
                        echo "</tbody>";
                        echo "</table>";
                        echo "Total: £" . number_format($cost, 2) . " <sub>(Excluding shipping)</sub><br>";
                        if($coupon != null){
                            $cost = $cost  - ($cost * ($coupon[0]['amount'] / 100));
                            echo "Total after discount: £" . number_format($cost, 2) . "<br>";
                        }
                        $cost += $transaction['shipping_cost'];
                        echo "Total: £" . number_format($cost, 2) . "<br>";
                        echo "</div>";
                        echo "</div>";
                        echo "</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="grid-x grid-margin-x">
        <div class="cell small-11">
            <div class="ui pagination menu">
                <?php
                $count = $databaseHandler->countTransactions();
                $limit = 10;
                if($count > 0){
                    if(isset($_GET['limit'])){
                        $limit = $_GET['limit'];
                    }
                    $pageTotal = ceil($count[0][0]/$limit)+1;
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