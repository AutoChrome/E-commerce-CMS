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
        <title>Admin - Dashboard</title>
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
    </head>

    <body>
        <div class="grid-y medium-grid-frame">
            <div class="cell medium-auto medium-cell-block-container">
                <div class="grid-x">
                    <div class="cell medium-2 bd">
                        <!-- Side nav -->
                        <ul class="vertical dropdown tabs" id="admin-tabs">
                            <li class="tabs-title nav-item is-active"><a href="main.php" aria-selected="true"><i class="fas fa-home"></i> Dashboard</a></li>
                            <li class="tabs-title nav-item"><a href="user-management.php"><i class="fas fa-users-cog"></i> User Management</a></li>
                            <li class="tabs-title nav-item"><a href="product-management.php"><i class="fas fa-warehouse"></i> Product Management</a></li>
                            <li class="tabs-title nav-item"><a href="transaction-management.php"><i class="fas fa-receipt"></i> Transactions</a></li>
                            <li class="tabs-title nav-item"><a href="coupon-management.php"><i class="fas fa-tag"></i> Coupon Management</a></li>
                            <li class="tabs-title nav-item"><a href="settings.php"><i class="fas fa-cog"></i> Settings</a></li>
                            <li class="tabs-title nav-item"><a href="../index.php"><i class="fas fa-arrow-left"></i> Return to website</a></li>
                        </ul>
                        <!-- End of side nav -->
                    </div>
                    <div class="cell medium-10 medium-cell-block-y">
                        <!--
<div class="tabs-content" data-tabs-content="admin-tabs">

<div class="tabs-panel is-active" id="dashboard">

</div>
<div class="tabs-panel" id="user_management">

</div>
<div class="tabs-panel" id="product_management">
<?php //include("widgets/product-manager.php")?>
</div>
<div class="tabs-panel" id="transactions">
stuff
</div>
<div class="tabs-panel" id="settings">
<ul class="tabs" data-tabs id="settings-tabs">
<li class="tabs-title nav-item is-active"><a href="#panel1" aria-selected="true">Website settings</a></li>
<li class="tabs-title nav-item show-for-large hide-for-small"><a data-tabs-target="panel2" href="#panel2">Layout</a></li>
</ul>
<div class="tabs-content" data-tabs-content="example-tabs">
<div class="tabs-panel is-active" id="panel1">
<p>Vivamus hendrerit arcu sed erat molestie vehicula. Sed auctor neque eu tellus rhoncus ut eleifend nibh porttitor. Ut in nulla enim. Phasellus molestie magna non est bibendum non venenatis nisl tempor. Suspendisse dictum feugiat nisl ut dapibus.</p>
</div>
<div class="tabs-panel" id="panel2">
<?php //include("widgets/sortable.php"); ?>
</div>
</div>
</div>
</div>
-->
                    </div>
                </div>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
        <script src="../js/jquery-ui-1.12.1.custom/jquery-ui.js"></script>
        <script src="https://dhbhdrzi4tiry.cloudfront.net/cdn/sites/foundation.js"></script>
        <script src="../js/toastr/toastr.min.js"></script>
        <script>
            $(document).foundation();
        </script>
        <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
        <script src="../js/jquery-ui-1.12.1.custom/jquery-ui.js"></script>
        <script src="https://dhbhdrzi4tiry.cloudfront.net/cdn/sites/foundation.js"></script>
        <script src="../js/toastr/toastr.min.js"></script>
        <script src="../css/Semantic-UI-CSS-master/semantic.min.js"></script>
    </body>
</html>