<?php
$dir = $_SERVER['DOCUMENT_ROOT'] . "/E-commerce-CMS/configs/navigation.json";
$databaseDir = $_SERVER['DOCUMENT_ROOT'] . "/E-commerce-CMS/objects/databaseHandler.php";
$json = file_get_contents($dir);
include_once($databaseDir);
$databaseHandler = new DatabaseHandler();

$navConfig = json_decode($json, true)[0];

$dir = $_SERVER['DOCUMENT_ROOT'] . "/E-commerce-CMS/configs/database.json";
$json = file_get_contents($dir);

$config = json_decode($json, true);

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<div class="title-bar" data-responsive-toggle="navigation" data-hide-for="large" style="display:none;">
    <button class="menu-icon" type="button" data-toggle="navigation"></button>
    <div class="title-bar-title">Menu</div>
</div>

<div class="top-bar" id="navigation">
    <?php
    if($navConfig['logo']['type'] == "image" || $navConfig['logo']['type'] == "both"){
        echo '<img src="https://via.placeholder.com/250x50">';
    }
    ?>
    <div class="top-bar-left">
        <ul class="dropdown menu" data-dropdown-menu>
            <?php
            if($navConfig['logo']['type'] == "text" || $navConfig['logo']['type'] == "both"){
                echo '<li class="menu-text"><a href="index.php">'. $config['site_name'] .'</a></li>';
            }
            ?>
            <li class="menu-text"><a href="search.php">Product list</a></li>
        </ul>
    </div>
    <?php
    if($navConfig['searchBar'] == "display"){
        $sections = $databaseHandler->getSections();
        echo '
            <div class="top-bar-mid">
                <div class="flex-container">
                    <div class="input-group">
                        <select id="searchCategory" class="select-css">';
        echo "<option>All</option>";
        foreach($sections as $section){
            echo "<option value='". $section['name'] ."'>". $section['name'] ."</option>";
        }
        echo '
                        </select>
                        <input id="search" class="input-group-field" type="text" placeholder="Product..."'. (isset($_GET['product']) ? 'value="'.$_GET['product'].'"' : "") .'>
                        <button class="button primary" style="margin-bottom:0px;" onclick="submitSearch(); return false;"><i class="fas fa-search"></i></button>
                    </div>
                </div>
            </div>
        ';
    }
    ?>
    <div class="top-bar-right">
        <ul class="dropdown menu" data-dropdown-menu>
            <?php
            $quantity = 0;
            $cart = $databaseHandler->getCart();
            if(isset($cart['type']) && $cart['type'] == "session"){
                foreach($cart['cart'] as $product){
                    $result = explode(",", $product);
                    $quantity += $result[1];
                }
            }else{
            }

            echo '<li><a href="cart.php"><i class="fas fa-shopping-basket"></i><sup> ';if($quantity > 9){echo "9+";}else{echo $quantity;} echo '</sup> Shopping list</a></li>';
            if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == 1){
                echo '<li><a href="profile.php"><i class="fas fa-user"></i> Profile</a></li>';
                echo '<li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>';
            }else{
                echo '<li><a href="sign-in.php"><i class="fas fa-sign-in-alt"></i> Login/register</a></li>';
            }
            ?>
        </ul>
    </div>
</div>