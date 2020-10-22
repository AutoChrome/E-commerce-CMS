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

if(isset($_GET['id']) && $_GET['id'] > -1){
    $result = $databaseHandler->getProduct($_GET['id']);
    if($result != null){
        $product = new Product($result['id'], $result['name'], $result['cost'], $result['description'], $result['quantity'], explode(",", $result['tags']), $result['type'], $result['section_name']);
    }else{
        $product = null;
    }
}else{
    $product = null;
}
?>


<html class="no-js">
    <head>
        <title>Admin - Edit product</title>
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
                                    <h1>Product details</h1>
                                    <div class="grid-x grid-padding-x">
                                        <div class="medium-1 cell">
                                            <label>ID
                                                <input id="id" type="text" value="<?php if($product != null){echo $product->getID();} ?>" disabled>
                                            </label>
                                        </div>
                                        <div class="medium-4 cell">
                                            <label>Name
                                                <input id="name" type="text" placeholder="Product" value="<?php if($product != null){echo $product->getName();} ?>" required>
                                            </label>
                                        </div>
                                        <div class="medium-4 cell">
                                            <label>Type
                                                <input id="type" type="text" placeholder="Component" value="<?php if($product != null){echo $product->getType();} ?>" required>
                                            </label>
                                        </div>
                                        <div class="medium-3 cell">
                                            <label>Section
                                                <select id="section">
                                                    <?php
                                                    $sections = $databaseHandler->getSections();
                                                    foreach($sections as $section){
                                                        echo "<option value=". $section['id'] .">". $section['name'] ."</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </label>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="grid-x grid-padding-x">
                                        <div class="medium-2 cell">
                                            <label>Quantity
                                                <div class="input-group">
                                                    <span class="input-group-label">
                                                        <i class="fa fa-box"></i>
                                                    </span>
                                                    <input id="quantity" class="input-group-field" type="text" placeholder="3" value="<?php if($product!=null){echo $product->getQuantity();} ?>" required>
                                                </div>
                                            </label>
                                        </div>
                                        <div class="medium-2 cell">
                                            <label>Price
                                                <div class="input-group">
                                                    <span class="input-group-label">
                                                        <i class="fa fa-pound-sign"></i>
                                                    </span>
                                                    <input id="cost" class="input-group-field" type="text" placeholder="20.22" value="<?php if($product!=null){echo $product->getCost();} ?>"  pattern="number" required>
                                                </div>
                                            </label>
                                        </div>
                                        <div class="medium-8 cell tag-table">
                                            <table class="unstriped" id="tag-table">
                                                <thead>
                                                    <tr>
                                                        <td width="1000">Tag</td>
                                                        <td>Delete</td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    if($product != null){
                                                        for($i = 0; $i < sizeof($product->getTags()); $i++){
                                                            echo "<tr><td>". $product->getTag($i) ."</td><td><button class='button alert' onclick='$(this).parent().parent().remove(); return false;'><i class='fas fa-trash'></i></button></td></tr>";
                                                        }
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="medium-8 medium-offset-4" style="padding:1rem; padding-bottom:0px;">
                                            <div class="input-group">
                                                <input class="input-group-field" type="text" id="tag-input">
                                                <div class="input-group-button">
                                                    <button class="button success" onclick="addTag($('#tag-input')); return false;">Add tag</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="grid-x grid-padding-x">
                                        <div class="medium-12 cell">
                                            <label>Description
                                                <textarea id="description" type="text"><?php if($product != null){echo $product->getDescription();} ?></textarea>
                                            </label>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="grid-x grid-padding-x">
                                        <div class="medium-6 cell">
                                            <label>Thumbnail
                                                <input type="file" accept="image/*" id="thumbnail" type="text" onchange="readURL($(this));">
                                            </label>
                                        </div>
                                        <div class="medium-6 cell">
                                            <label>Gallery images
                                                <input type="file" accept="image/*" id="gallery" type="text" multiple>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="grid-x grid-padding-x">
                                        <div class="medium-6 cell">
                                            <?php
                                            $result = glob("../img/products/" . $product->getID() . "/thumbnail.*");
                                            if(sizeof($result) > 0){
                                                echo '<img id="thumbnail-image" src="'. $result[0] .'" alt="thumbnail"/>';
                                            }else{
                                                echo '<img id="thumbnail-image" src="#" alt="thumbnail" hidden/>';
                                            }
                                            ?>

                                        </div>
                                        <div class="medium-6 cell">
                                            <h1>Current gallery</h1>
                                            <div class="grid-x grid-margin-x image-container">
                                                <?php
                                                if(file_exists("../img/products/" . $product->getId() . "/gallery")){
                                                    $gallery = array_values(array_diff(scandir("../img/products/" . $product->getId() . "/gallery"), array(".", "..")));

                                                    foreach($gallery as $image){
                                                        echo '
                                                        <div class="medium-4 cell container">
                                                            <div class="hover">
                                                                <button class="button alert rounded" onclick="deleteImage($(this), '. $product->getID() .'); return false;" value="'. $image .'"><i class="fas fa-trash"></i></button>
                                                            </div>
                                                            <img class="image" src="../img/products/'. $product->getID() .'/gallery/'. $image .'" alt="image"/>
                                                        </div>
                                                    ';
                                                    }
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="grid-x grid-padding-x">
                                        <div class="medium-2 medium-offset-10 cell">
                                            <button class="button success" onclick="updateProduct(); return false;">Save</button>
                                            <button class="button alert" data-open="delete-modal" onclick="return false;">Delete</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="reveal" id="delete-modal" data-reveal>
            <h1>Are you sure you wish to delete this product?</h1>
            <div class="grid-x">
                <div class="medium-2 cell"><button class="button alert" onclick="deleteProduct($('#id').val()); return false;">Yes</button></div>
                <div class="medium-2 cell"><button class="button primary" data-close>No</button></div>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
        <script src="../js/jquery-ui-1.12.1.custom/jquery-ui.js"></script>
        <script src="https://dhbhdrzi4tiry.cloudfront.net/cdn/sites/foundation.js"></script>
        <script src="../js/toastr/toastr.min.js"></script>
        <script src="scripts/custom-scripts/edit-product.js"></script>
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