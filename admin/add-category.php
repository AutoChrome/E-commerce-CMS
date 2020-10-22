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
?>


<html class="no-js">
    <head>
        <title>Admin - Manage sections</title>
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
                            <li class="tabs-title nav-item is-active"><a href="product-management.php" aria-selected="true"><i class="fas fa-warehouse"></i> Product Management</a></li>
                            <ul class="nested vertical menu">
                                <li class="tabs-title nav-item"><a href="add-product.php">Add product</a></li>
                                <li class="tabs-title nav-item"><a href="add-category.php">Manage categories</a></li>
                            </ul>
                            <li class="tabs-title nav-item"><a href="transaction-management.php"><i class="fas fa-receipt"></i> Transactions</a></li>
                            <li class="tabs-title nav-item"><a href="coupon-management.php"><i class="fas fa-tag"></i> Coupon Management</a></li>
                            <li class="tabs-title nav-item"><a href="settings.php"><i class="fas fa-cog"></i> Settings</a></li>
                            <li class="tabs-title nav-item"><a href="../index.php"><i class="fas fa-arrow-left"></i> Return to website</a></li>
                        </ul>
                        <!-- End of side nav -->
                    </div>
                    <div class="cell medium-10 medium-cell-block-y content-holder">
                        <div class="content-padding">
                            <form id="product-form" class="bd" data-abide>
                                <div class="grid-container fluid">
                                    <h1>Category details</h1>
                                    <div class="grid-x grid-margin-x grid-padding-x">
                                        <div class="medium-1 cell">
                                            <label>ID
                                                <input id="id" type="text" value="Auto" disabled>
                                            </label>
                                        </div>
                                        <div class="medium-4 cell">
                                            <label>Name
                                                <input id="name" name="categoryName" type="text" placeholder="Category" required>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="grid-x grid-padding-x">
                                    <div class="medium-2 medium-offset-10 cell">
                                        <button class="button success" onclick="addCategory(); return false;">Create</button>
                                    </div>
                                </div>
                            </form>
                            <div class="grid-x">
                                <div class="cell large-12">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Name</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $sections = $databaseHandler->getSections();
                                            foreach($sections as $section){
                                                echo "<tr>";
                                                echo "<td>". $section['id'] ."</td>";
                                                echo "<td>". $section['name'] ."</td>";
                                                echo "</tr>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
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
        <script src="scripts/custom-scripts/add-product.js"></script>
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