<?php
$json = file_get_contents("../configs/config.json");

$configs = json_decode($json, true);
include("../objects/DatabaseHandler.php");
include("../objects/product.php");

$databaseHandler = new DatabaseHandler();

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if(!isset($_SESSION['admin']) || $_SESSION['admin'] != true){
    http_response_code(404);
    die();
}

$coupon = $databaseHandler->getCoupon($_GET['id']);
?>


<html class="no-js">
    <head>
        <title>Admin - Edit coupon</title>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../css/foundation.css">
        <link rel='stylesheet' type='text/css' href='../css/main.php' />
        <link rel='stylesheet' type='text/css' href='css/admin.php' />
        <link rel='stylesheet' type='text/css' href='css/widget/product-manager.css'/>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/motion-ui@1.2.3/dist/motion-ui.min.css" />
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous"/>
        <link rel="stylesheet" href="../css/toastr.min.css"/>
        <link rel="stylesheet" href="../css/Semantic-UI-CSS-master/semantic.min.css"/>
        <style>
            .button.success{
                color:white;
            }
            .button.success:hover{
                color:#fff;
            }
            .button.success:active{
                color:#fff;
            }
            .image-container{
                height:250px;
                overflow-y: scroll;
            }
            .hover{
                opacity:0;
                transition: .5s ease;
                float:right;
            }
            .rounded{
                border-radius:50%;
            }
            .container:hover .image{
            }

            .container:hover .hover{
                opacity: 1;
            }
        </style>
    </head>

    <body>
        <div class="grid-y medium-grid-frame">
            <div class="cell medium-auto medium-cell-block-container">
                <div class="grid-x">
                    <div class="cell medium-2 bd">
                        <!-- Side nav -->
                        <ul class="vertical dropdown tabs" id="admin-tabs">
                            <li class="tabs-title nav-item"><a href="main.php"><i class="fas fa-home"></i> Dashboard</a></li>
                            <li class="tabs-title nav-item"><a href="user-management.php"><i class="fas fa-users-cog"></i> User Management</a></li>
                            <li class="tabs-title nav-item is-active"><a href="product-management.php"><i class="fas fa-warehouse"></i> Product Management</a></li>
                            <li class="tabs-title nav-item"><a href="transaction-management.php"><i class="fas fa-receipt"></i> Transactions</a></li>
                            <li class="tabs-title nav-item"><a href="coupon-management.php" aria-selected="true"><i class="fas fa-tag"></i> Coupon Management</a></li>
                            <ul class="nested vertical menu">
                                <li class="tabs-title nav-item"><a href="add-coupon.php">Add coupon</a></li>
                            </ul>
                            <li class="tabs-title nav-item"><a href="settings.php"><i class="fas fa-cog"></i> Settings</a></li>
                            <li class="tabs-title nav-item"><a href="../index.php"><i class="fas fa-arrow-left"></i> Return to website</a></li>
                        </ul>
                        <!-- End of side nav -->
                    </div>
                    <div class="cell medium-10 medium-cell-block-y content-holder">
                        <div class="content-padding">
                            <form id="product-form" class="bd" data-abide>
                                <div class="grid-container fluid">
                                    <h1>Product details</h1>
                                    <div class="grid-x grid-padding-x">
                                        <div class="medium-1 cell">
                                            <label>ID
                                                <input id="id" type="text" value="<?php echo $coupon[0]['id'];?>" disabled>
                                            </label>
                                        </div>
                                        <div class="medium-4 cell">
                                            <label>Code
                                                <input id="code" name="code" type="text" placeholder="SALE2019" value="<?php echo $coupon[0]['code']; ?>">
                                            </label>
                                        </div>
                                    </div>
                                    <div class="grid-x grid-padding-x">
                                        <div class="medium-4 cell">
                                            <label>Percent discount
                                                <input id="discount" name="discount" type="number" placeholder="5" value="<?php echo $coupon[0]['amount']; ?>">
                                            </label>
                                        </div>
                                        <div class="medium-4 cell">
                                            <label>Usages
                                                <input id="usages" name="usages" type="number" placeholder="0" value="<?php echo $coupon[0]['usages']; ?>">
                                                <hint>0 = unlimited uses for a coupon.</hint>
                                            </label>
                                        </div>
                                        <div class="medium-4 cell">
                                            <label>Expiry
                                                <input id="expiry" name="expiry" type="date" value="<?php echo $coupon[0]['expiry'];?>">
                                            </label>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="grid-x grid-padding-x">
                                        <div class="medium-12 cell">
                                            <label>Description
                                                <textarea id="description" name="description" type="text"><?php echo $coupon[0]['description'];?></textarea>
                                            </label>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="grid-x grid-padding-x">
                                        <div class="medium-2 medium-offset-10 cell">
                                            <button class="button success" onclick="updateCoupon(<?php echo $coupon[0]['id']; ?>); return false;">Create</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
        <script src="../js/jquery-ui-1.12.1.custom/jquery-ui.js"></script>
        <script src="https://dhbhdrzi4tiry.cloudfront.net/cdn/sites/foundation.js"></script>
        <script src="../js/toastr/toastr.min.js"></script>
        <script src="scripts/custom-scripts/add-product.js"></script>
        <script>
            $(document).foundation();
        </script>
        <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
        <script src="../js/jquery-ui-1.12.1.custom/jquery-ui.js"></script>
        <script src="https://dhbhdrzi4tiry.cloudfront.net/cdn/sites/foundation.js"></script>
        <script src="../js/toastr/toastr.min.js"></script>
        <script src="../css/Semantic-UI-CSS-master/semantic.min.js"></script>
        <script src="scripts/custom-scripts/add-coupon.js"></script>
    </body>
</html>