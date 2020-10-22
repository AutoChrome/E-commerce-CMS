<?php
$json = file_get_contents("../configs/config.json");

$configs = json_decode($json, true);
include("../objects/DatabaseHandler.php");
    
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if(!isset($_SESSION['admin']) || $_SESSION['admin'] != true){
    http_response_code(404);
    die();
}
?>


<html class="no-js">
    <head>
        <title>Admin - User Manager</title>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../css/foundation.css">
        <link rel='stylesheet' type='text/css' href='css/admin.php' />
        <link rel='stylesheet' type='text/css' href='../css/main.php' />
        <link rel='stylesheet' type='text/css' href='css/widget/user-manager.css'/>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous"/>
        <link rel="stylesheet" href="../css/toastr.min.css"/>
        <link rel="stylesheet" href="../css/Semantic-UI-CSS-master/semantic.min.css"/>
    </head>

    <body>
        <div class="grid-y medium-grid-frame">
            <div class="cell medium-auto medium-cell-block-container">
                <div class="grid-x">
                    <div class="cell large-2 bd">
                        <!-- Side nav -->
                        <ul class="vertical dropdown tabs" id="admin-tabs">
                            <li class="tabs-title nav-item"><a href="main.php"><i class="fas fa-home"></i> Dashboard</a></li>
                            <li class="tabs-title nav-item is-active"><a href="user-management.php" aria-selected="true"><i class="fas fa-users-cog"></i> User Management</a></li>
                            <ul class="nested vertical menu">
                                <li class="tabs-title nav-item"><a href="add-user.php">Add user</a></li>
                            </ul>
                            <li class="tabs-title nav-item"><a href="product-management.php"><i class="fas fa-warehouse"></i> Product Management</a></li>
                            <li class="tabs-title nav-item"><a href="transaction-management.php"><i class="fas fa-receipt"></i> Transactions</a></li>
                            <li class="tabs-title nav-item"><a href="coupon-management.php"><i class="fas fa-tag"></i> Coupon Management</a></li>
                            <li class="tabs-title nav-item"><a href="settings.php"><i class="fas fa-cog"></i> Settings</a></li>
                            <li class="tabs-title nav-item"><a href="../index.php"><i class="fas fa-arrow-left"></i> Return to website</a></li>
                        </ul>
                        <!-- End of side nav -->
                    </div>
                    <div class="cell large-10 large-cell-block-y content-holder">
                        <div class="grid-x content-padding">
                            <div class="cell large-12">
                                <?php include("widgets/user-manager.php");?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
        <script src="../js/jquery-ui-1.12.1.custom/jquery-ui.js"></script>
        <script src="https://dhbhdrzi4tiry.cloudfront.net/cdn/sites/foundation.js"></script>
        <script src="../js/toastr/toastr.min.js"></script>
        <script src="scripts/custom-scripts/user-manager.js"></script>
        <script src="../css/Semantic-UI-CSS-master/semantic.min.js"></script>
        <script>
            Foundation.Abide.defaults.patterns['postcode'] = /([Gg][Ii][Rr] 0[Aa]{2})|((([A-Za-z][0-9]{1,2})|(([A-Za-z][A-Ha-hJ-Yj-y][0-9]{1,2})|(([A-Za-z][0-9][A-Za-z])|([A-Za-z][A-Ha-hJ-Yj-y][0-9][A-Za-z]?))))\s?[0-9][A-Za-z]{2})/;
            Foundation.Abide.defaults.patterns['telephone'] = /^((\(?0\d{4}\)?\s?\d{3}\s?\d{3})|(\(?0\d{3}\)?\s?\d{3}\s?\d{4})|(\(?0\d{2}\)?\s?\d{4}\s?\d{4}))(\s?\#(\d{4}|\d{3}))?$/;
            $(document).foundation();
        </script>
    </body>
</html>