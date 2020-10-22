<?php
$dir = $_SERVER['DOCUMENT_ROOT'] . "/E-commerce-CMS/configs/database.json";
if(!file_exists($dir)){
    $dir = $_SERVER['DOCUMENT_ROOT'] . "/configs/database.json";
}
$json = file_get_contents($dir);

$config = json_decode($json, true);

include_once("objects/DatabaseHandler.php");
$databaseHandler = new DatabaseHandler();

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == true){
    $user = $databaseHandler->getUser($_SESSION['id']);
}
?>


<html class="no-js">
    <head>
        <?php
        echo '
                <title>Profile - '. $user['first_name'] . ' ' . $user['last_name'] .'</title>
        ';
        ?>
        <title></title>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/foundation.css">
        <link rel='stylesheet' type='text/css' href='css/main.php' />
        <link rel='stylesheet' type='text/css' href='css/profile.css' />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/motion-ui@1.2.3/dist/motion-ui.min.css" />
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous"/>
        <link rel="stylesheet" href="css/toastr.min.css"/>
        <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
        <script src="js/vendor/foundation.js"></script>

    </head>

    <body>
        <?php 
        if(!isset($_COOKIE['allow_cookie'])){
            include("widgets/cookie_request.php");
        }
        ?>
        <div class="container">
            <div class="header">
                <?php
                include("widgets/navigation.php");
                ?>
            </div>
            <div class="body">
                <div class="grid-container content">
                    <div class="grid-x grid-margin-x">
                        <div class="cell large-12">
                            <div class="grid-x grid-margin-x">
                                <?php
                                $orders = array_reverse($databaseHandler->getRecentOrders(array('id' => $_SESSION['id'])));
                                for($i = 0; $i < sizeof($orders); $i++){
                                    echo "<div class='cell large-4'>";
                                    echo "<div class='card card-padding'>";
                                    echo "<p>Status: ". $orders[$i]['status'] ."</p>";
                                    echo "<p>Payment method: ". $orders[$i]['paymentMethod'] ."</p>";
                                    echo "<p>Shipping: ". $orders[$i]['shipping_type'] ."</p>";
                                    echo "<p>Date purchased: ". date("d/m/Y", strtotime($orders[$i]['date'])) ."</p>";
                                    echo "<a class='button primary' href='order.php?id=". $orders[$i]['id'] ."'>View order</a>";
                                    echo "</div></div>";
                                }
                                ?>
                            </div>
                            <br><br><a class="button primary" onclick="displayTable(); return false;">View all orders</a>
                            <?php $allOrders = $databaseHandler->getOrders($_SESSION['id']); ?>
                            <table id="orderTable" hidden>
                                <thead>
                                    <tr>
                                        <td>Payment Method</td>
                                        <td>Shipping</td>
                                        <td>Date</td>
                                        <td>Status</td>
                                        <td>View order</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach($allOrders as $order){
                                        echo "<tr>";
                                        echo "<td>". $order['paymentMethod'] ."</td>";
                                        echo "<td>". $order['shipping_type'] ."</td>";
                                        echo "<td>". $order['date'] ."</td>";
                                        echo "<td>". $order['status'] ."</td>";
                                        echo "<td><a class='button primary' href='order.php?id=". $order['id'] ."'>View</a></td>";
                                        echo "</tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="cell large-12">
                            <div class="user-border">
                                <form>
                                    <div class="grid-x grid-margin-x">
                                        <div class="cell large-4">
                                            <div class="field">
                                                <label>
                                                    First name:
                                                    <input type="text" name="first_name" <?php echo "value='{$user['first_name']}'"?> >
                                                </label>
                                            </div>
                                        </div>
                                        <div class="cell large-4">
                                            <div class="field">
                                                <label>
                                                    Other name:
                                                    <input type="text" name="other_name" <?php echo "value='{$user['other_name']}'"?> >
                                                </label>
                                            </div>
                                        </div>
                                        <div class="cell large-4">
                                            <div class="field">
                                                <label>
                                                    Last name:
                                                    <input type="text" name="last_name" <?php echo "value='{$user['last_name']}'"?> >
                                                </label>
                                            </div>
                                        </div>
                                        <div class="cell large-6">
                                            <div class="field">
                                                <label>
                                                    Email:
                                                    <input type="email" name="email" <?php echo "value='{$user['email']}'"?> >
                                                </label>
                                            </div>
                                        </div>
                                        <div class="cell large-6">
                                            <div class="field">
                                                <label>
                                                    Address:
                                                    <input type="text" name="address" <?php echo "value='{$user['address']}'"?> >
                                                </label>
                                            </div>
                                        </div>
                                        <div class="cell large-4">
                                            <div class="field">
                                                <label>
                                                    Postcode:
                                                    <input type="text" name="postcode" <?php echo "value='{$user['postcode']}'"?> >
                                                </label>
                                            </div>
                                        </div>
                                        <div class="cell large-4">
                                            <div class="field">
                                                <label>
                                                    Town:
                                                    <input type="text" name="town" <?php echo "value='{$user['town']}'"?> >
                                                </label>
                                            </div>
                                        </div>
                                        <div class="cell large-4">
                                            <div class="field">
                                                <label>
                                                    Telephone:
                                                    <input type="text" name="telephone" <?php echo "value='{$user['telephone']}'"?> >
                                                </label>
                                            </div>
                                        </div>
                                        <div class="cell large-6">
                                            <div class="field">
                                                Date of birth
                                                <div class="grid-x grid-margin-x">
                                                    <div class="cell large-4">
                                                        <select name="dob_day">
                                                            <?php
    $dob = explode("-", $user['dob']);
                                                           for($i = 1; $i <= 31; $i++){
                                                               if($i < 10){
                                                                   if($dob[2] == $i){
                                                                       echo "<option value='{$i}' selected>0{$i}</option>";
                                                                   }else{
                                                                       echo "<option value='{$i}'>0{$i}</option>";
                                                                   }
                                                               }else{
                                                                   if($dob[2] == $i){
                                                                       echo "<option value='{$i}' selected>{$i}</option>"; 
                                                                   }else{
                                                                       echo "<option value='{$i}'>{$i}</option>"; 
                                                                   }

                                                               }
                                                           }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <div class="cell large-4">
                                                        <select name="dob_month">
                                                            <option>MM</option>
                                                            <option value="01" <?php if($dob[1] == "01"){echo "selected";} ?> >January</option>
                                                            <option value="02" <?php if($dob[1] == "02"){echo "selected";} ?>>February</option>
                                                            <option value="03" <?php if($dob[1] == "03"){echo "selected";} ?>>March</option>
                                                            <option value="04" <?php if($dob[1] == "04"){echo "selected";} ?>>April</option>
                                                            <option value="05" <?php if($dob[1] == "05"){echo "selected";} ?>>May</option>
                                                            <option value="06" <?php if($dob[1] == "06"){echo "selected";} ?>>June</option>
                                                            <option value="07" <?php if($dob[1] == "07"){echo "selected";} ?>>July</option>
                                                            <option value="08" <?php if($dob[1] == "08"){echo "selected";} ?>>August</option>
                                                            <option value="09" <?php if($dob[1] == "09"){echo "selected";} ?>>September</option>
                                                            <option value="10" <?php if($dob[1] == "10"){echo "selected";} ?>>October</option>
                                                            <option value="11" <?php if($dob[1] == "11"){echo "selected";} ?>>November</option>
                                                            <option value="12" <?php if($dob[1] == "12"){echo "selected";} ?>>December</option>
                                                        </select>
                                                    </div>
                                                    <div class="cell large-4">
                                                        <input name="dob_year" type="number" placeholder="YYYY" <?php echo 'value="'.$dob[0].'"' ?>>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="cell large-4">
                                            <label>Current password
                                                <input name="password" type="password">
                                            </label>
                                        </div>
                                        <div class="cell large-12">
                                            <div class="field">
                                                <label>
                                                    Member since:
                                                    <?php echo date("d/m/Y", strtotime($user['dateOfRegistry']));?>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="cell large-12">
                                            <div class="field">
                                                <button class="button primary" onclick="updateProfile(); return false;">Update profile</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <div class="field"></div>
                                <div class="field"></div>
                                <div class="field"></div>
                                <div class="field"></div>
                                <div class="field"></div>
                            </div>
                        </div>
                        <div class="cell large-6" style="margin-top:1rem;">
                            <div class="user-border">
                                <div class="grid-x grid-margin-x" style="">
                                    <h3 class="cell large-12">Update password</h3>
                                    <div class="cell large-12"><label>Current password<input type="password" name="change-current-password"></label></div>
                                    <div class="cell large-6"><label>New password<input type="password" name="change-new-password"></label></div>
                                    <div class="cell large-6"><label>Confirm password<input type="password" name="change-confirm-password"></label></div>
                                    <div class="cell large-6"><button class="button primary" onclick="updatePassword(); return false;">Submit</button></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="grid-container full footer">
                <?php include_once("widgets/footer.php"); ?>
            </div>
        </div>
        <script>
            $(document).foundation();
        </script>
        <script src="js/custom-scripts/cookie.js"></script>
        <script src="js/custom-scripts/profile.js"></script>
        <script src="js/custom-scripts/searchbar.js"></script>
        <script src="js/toastr/toastr.min.js"></script>
    </body>
</html>