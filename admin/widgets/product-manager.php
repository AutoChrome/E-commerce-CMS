<?php 
include_once("../objects/product.php");
include_once("scripts/functions.php");

$databaseHandler = new DatabaseHandler();
parse_str($_SERVER['QUERY_STRING'], $options);
$options = removePageOptions($options);

if(isset($_GET['page']) && isset($_GET['limit'])){
    if(isset($_GET['sortBy']) && isset($_GET['direction'])){
        $product_list = $databaseHandler->getProductsSort($_GET['limit'], ($_GET['page']-1) * $_GET['limit'], $_GET['sortBy'], $_GET['direction'], $options);
    }else{
        $product_list = $databaseHandler->getProducts($_GET['limit'], ($_GET['page']-1) * $_GET['limit'], $options);
    }
}else if(isset($_GET['page'])){
    if(isset($_GET['sortBy']) && isset($_GET['direction'])){
        $product_list = $databaseHandler->getProductsSort(10, ($_GET['page']-1) * 10, $_GET['sortBy'], $_GET['direction'], $options);
    }else{
        $product_list = $databaseHandler->getProducts(10, ($_GET['page']-1) * 10, $options);
    }
}else if(isset($_GET['limit'])){
    if(isset($_GET['sortBy']) && isset($_GET['direction'])){
        $product_list = $databaseHandler->getProductsSort($_GET['limit'], 0 * $_GET['limit'], $_GET['sortBy'], $_GET['direction'], $options);
    }else{
        $product_list = $databaseHandler->getProducts($_GET['limit'], 0 * $_GET['limit'], $options);
    }
}else{
    if(isset($_GET['sortBy']) && isset($_GET['direction'])){
        $product_list = $databaseHandler->getProductsSort(10, 0 * 10, $_GET['sortBy'], $_GET['direction'], $options);
    }else{
        $product_list = $databaseHandler->getProducts(10, 0 * 10, $options);
    }
}
?>
<div class="grid-container full">
    <div class="grid-x grid-margin-x">
        <div class="large-2 cell">
            <button class="button success"><a href="add-product.php" style="color:white;">Add product</a></button>
        </div>
    </div>
    <div class="grid-x grid-margin-x">
        <div class="cell large-12 bd product-filter">
            <button data-display-filter class="blue">
                <h2>Filters <span><i class="fas fa-sort-down" data-filter-span></i></span></h2>
            </button>
        </div>
    </div>

    <div class="grid-x filter-content">
        <div class="cell large-12 bd">
            <form data-abide novalidate onsubmit="searchProduct($(this), '<?php parse_str($_SERVER['QUERY_STRING'], $queries); echo http_build_query($queries); ?>')">
                <div data-abide-error class="alert callout" style="display: none;">
                    <p><i class="fi-alert"></i> There are some errors in your form.</p>
                </div>
                <div class="grid-container full">
                    <div class="grid-x">
                        <div class="cell large-4">
                            <label>
                                Name
                                <input name="name" id="filterName" aria-describedby="example4Error" type="text" value="<?php if(isset($_GET['name'])){echo $_GET['name'];}?>">
                                <span id="filterNameError" class="form-error">This field cannot contain numbers.</span>
                            </label>
                        </div>
                        <div class="cell large-4">
                            <label>
                                Description
                                <textarea name="description" placeholder="Some description of a product..."><?php if(isset($_GET['description'])){echo $_GET['description'];}?></textarea>
                                <span id="filterDescriptionError" class="form-error">This field cannot contain numbers.</span>
                            </label>
                        </div>
                        <div class="cell large-4">
                            <label>
                                Type
                                <input name="type" id="filterType" aria-describedby="example4Error" type="text" pattern="alpha" value="<?php if(isset($_GET['type'])){echo $_GET['type'];} ?>">
                                <span id="filterTypeError" class="form-error">This field cannot contain numbers.</span>
                            </label>
                        </div>
                    </div>
                    <div class="grid-x grid-margin-x">
                        <div class="cell large-2">
                            <label>
                                Min. £
                                <input name="min" id="filterMinCost" aria-describedby="example4Error" type="text" pattern="currency" value="<?php if(isset($_GET['min'])){echo $_GET['min'];}?>">
                                <span id="filterMinError" class="form-error">This field cannot contain numbers.</span>
                            </label>
                        </div>
                        <div class="cell large-2">
                            <label>
                                Max. £
                                <input name="max" id="filterMaxCost" aria-describedby="example4Error" type="text" pattern="number" value="<?php if(isset($_GET['max'])){echo $_GET['max'];}?>">
                                <span id="filterMaxError" class="form-error">This field cannot contain numbers.</span>
                            </label>
                        </div>
                        <div class="cell large-2">
                            <label>
                                Quantity Min
                                <input name="qmin" id="filterMinQuantity" aria-describedby="example4Error" type="text" pattern="number" value="<?php if(isset($_GET['qmin'])){echo $_GET['qmin'];}?>">
                                <span id="filterMaxError" class="form-error">This field cannot contain numbers.</span>
                            </label>
                        </div>
                        <div class="cell large-2">
                            <label>
                                Quantity max
                                <input name="qmax" id="filterMaxQuantity" aria-describedby="example4Error" type="text" pattern="number" value="<?php if(isset($_GET['qmax'])){echo $_GET['qmax'];}?>">
                                <span id="filterMaxError" class="form-error">This field cannot contain numbers.</span>
                            </label>
                        </div>
                        <div class="cell large-4">
                            <label>
                                Section
                                <select name="section_id">
                                    <?php
                                    echo "<option>All</option>";
                                    $sections = $databaseHandler->getSections();
                                    foreach($sections as $section){
                                        echo "<option value='".$section['id']."'>".$section['name']."</option>";
                                    }
                                    ?>
                                </select>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="grid-container full">
                    <div class="grid-x grid-margin-x">
                        <fieldset class="cell large-1">
                            <button class="button" type="submit" value="Submit">Submit</button>
                        </fieldset>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="grid-x grid-margin-x">
        <div class="cell large-12">
            <table class="unstriped">
                <thead onselectstart="return false;">
                    <th width="80"><a <?php echo generateURL("id");?> data-value="id" data-sort="none" onclick="">ID <?php echo generateSpan("id");?></a></th>
                    <th width="80"><a <?php echo generateURL("name"); ?> data-value="name" onclick="">Name <?php echo generateSpan("name");?></a></th>
                    <th width="80"><a <?php echo generateURL("cost"); ?> data-value="cost" onclick="">Cost <?php echo generateSpan("cost");?></a></th>
                    <th width="200"><a data-value="description" onclick="return false;">Description <span><i class=""></i></span></a></th>
                    <th width="200"><a data-value="thumbnail" onclick="return false;">Thumbnail <span><i class=""></i></span></a></th>
                    <th width="120"><a <?php echo generateURL("quantity"); ?> data-value="quantity" onclick="">Quantity <?php echo generateSpan("quantity");?></a></th>
                    <th width="200"><a onclick="return false;">Tags</a></th>
                    <th width="80"><a <?php echo generateURL("type"); ?> data-value="type" onclick="">Type <?php echo generateSpan("type");?></a></th>
                    <th width="90"><a <?php echo generateURL("section"); ?> data-value="type" onclick="">Section <?php echo generateSpan("section");?></a></th>
                    <th width="80"><a onclick="return false;">Manage</a></th>
                </thead>
                <tbody id="product-table">
                    <?php
                    if($product_list[0]['status'] == "success"){
                        if(sizeof($product_list[1]) > 0){
                            for($i = 0; $i < sizeof($product_list[1]); $i++){
                                if(sizeof(glob("../img/products/" . $product_list[1][$i]->id . "/thumbnail.*")) > 0){
                                    $result = glob("../img/products/" . $product_list[1][$i]->id . "/thumbnail.*");
                                }else{
                                    $result[0] = "https://via.placeholder.com/500x500";
                                }
                                $tags = $product_list[1][$i]->tags;
                                echo "<tr class='table-expand-row' data-open-details value='". $product_list[1][$i]->id ."'>";
                                echo "<td>". $product_list[1][$i]->id ."</td>";
                                echo "<td>". $product_list[1][$i]->name ."</td>";
                                echo "<td>£". number_format($product_list[1][$i]->cost, 2) ."</td>";
                                echo "<td>". $product_list[1][$i]->description ."</td>";
                                echo "<td><img src='". $result[0] ."' alt='thumbnail' class='image'/></td>";
                                echo "<td>". $product_list[1][$i]->quantity ."</td>";
                                echo "<td>";
                                for($x = 0; $x < sizeof($tags); $x++){
                                    echo "<a class='ui tag label'>". $tags[$x] ."</a>";
                                }
                                echo "</td>";
                                echo "<td>". $product_list[1][$i]->type ."</td>";
                                echo "<td>". $product_list[1][$i]->section ."</td>";
                                echo "<td><a href='edit-product.php?id=". $product_list[1][$i]->id ."'>Edit</a></td>";
                                echo "</tr>";
                            }
                        }
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
                $count = $databaseHandler->countProducts($options);
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
        <div class="cell small-1">
            Display
            <label>
                <select id="limit">
                    <option <?php if(isset($_GET['limit']) && $_GET['limit'] == 10){echo "selected='selected'";}?> value="10">10</option>
                    <option <?php if(isset($_GET['limit']) && $_GET['limit'] == 25){echo "selected='selected'";}?> value="25">25</option>
                    <option <?php if(isset($_GET['limit']) && $_GET['limit'] == 50){echo "selected='selected'";}?> value="50">50</option>
                    <option <?php if(isset($_GET['limit']) && $_GET['limit'] == 100){echo "selected='selected'";}?> value="100">100</option>
                </select>
            </label>
        </div>
    </div>
</div>