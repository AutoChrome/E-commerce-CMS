<?php 
include_once("../objects/product.php");
include_once("scripts/functions.php");

$databaseHandler = new DatabaseHandler();
parse_str($_SERVER['QUERY_STRING'], $options);
$options = removePageOptions($options);

if(isset($_GET['page'])){
    $list = $databaseHandler->getCouponList("", 10, $_GET['page']);
}else{
    $list = $databaseHandler->getCouponList("", 10, 0);
}

?>
<div class="grid-container full">
    <div class="grid-x grid-margin-x">
        <div class="large-2 cell">
            <button class="button success"><a href="add-coupon.php" style="color:white;">Add coupon</a></button>
        </div>
    </div>
    <div class="grid-x grid-margin-x">
        <div class="cell large-12 bd product-filter">
            <button class="blue">
                <h2>Coupon list</h2>
            </button>
        </div>
    </div>

    <div class="grid-x grid-margin-x">
        <div class="cell large-12">
            <table class="unstriped">
                <thead onselectstart="return false;">
                    <th width="80"><a>ID</a></th>
                    <th width="240"><a>Code</a></th>
                    <th width="240"><a>Description</a></th>
                    <th width="80"><a>Amount</a></th>
                    <th width="80"><a>Usages</a></th>
                    <th width="240"><a>Expiry</a></th>
                    <th width="240"><a>Created</a></th>
                    <th width="240"><a>Edit</a></th>
                </thead>
                <tbody id="product-table">
                    <?php
                    foreach($list as $coupon){
                        echo "<tr>";
                        echo "<td>". $coupon['id'] ."</td>";
                        echo "<td>". $coupon['code'] ."</td>";
                        echo "<td>". $coupon['description'] ."</td>";
                        echo "<td>". $coupon['amount'] ."</td>";
                        if($coupon['usages'] == 0){
                            echo "<td>&#8734;</td>";
                        }else{
                            echo "<td>". $coupon['usages'] ."</td>";
                        }
                        echo "<td>". date("d/m/Y", strtotime($coupon['expiry'])) ."</td>";
                        echo "<td>". date("d/m/Y", strtotime($coupon['created'])) ."</td>";
                        echo "<td><a href='edit-coupon.php?id=". $coupon['id'] ."' class='button primary'>Edit</a></td>";
                        echo "</tr>";
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
                $count = $databaseHandler->countCoupons()[0][0];
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