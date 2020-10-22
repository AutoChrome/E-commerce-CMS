<?php
$dir = $_SERVER['DOCUMENT_ROOT'] . "/E-commerce-CMS/objects/DatabaseHandler.php";
if(!file_exists($dir)){
    $dir = $_SERVER['DOCUMENT_ROOT'] . "/objects/DatabaseHandler.php";
}
include_once($dir);
$databaseHandler = new DatabaseHandler();

include_once("scripts/functions.php");

parse_str($_SERVER['QUERY_STRING'], $options);
$options = removePageOptions($options);

if(isset($_GET['page']) && isset($_GET['limit'])){
    $user_list = $databaseHandler->getUsersSort($_GET['limit'], ($_GET['page']-1) * $_GET['limit'], $options);
}else if(isset($_GET['page'])){
    $user_list = $databaseHandler->getUsersSort(9, ($_GET['page']-1) * 9, $options);
}else if(isset($_GET['limit'])){
    $user_list = $databaseHandler->getUsersSort($_GET['limit'], 0, $options);
}else{
    $user_list = $databaseHandler->getUsersSort(9, 0, $options);
}
?>
<div class="grid-container full">
    <div class="grid-x">
        <div class="cell large-2">
            <a class="button success" href="add-user.php">Add user</a>
        </div>
    </div>
    <div class="grid-x grid-margin-x">
        <div class="cell large-12 bd user-filter">
            <button data-display-filter class="blue">
                <h2>Filters <span><i class="fas fa-sort-down float-right" data-filter-span></i></span></h2>
            </button>
        </div>
    </div>

    <div class="grid-x filter-content">
        <div class="cell large-12 bd">
            <form data-abide onsubmit="searchUser($(this), '<?php parse_str($_SERVER['QUERY_STRING'], $queries); echo http_build_query($queries); ?>')" novalidate>
                <div class="grid-container full">
                    <div class="grid-x">
                        <div class="cell large-4">
                            <label>
                                First name
                                <input name="first_name" id="filterFirstName" placeholder="First name" type="text" value="<?php if(isset($_GET['first_name'])){echo $_GET['first_name'];}?>">
                            </label>
                        </div>
                        <div class="cell large-4">
                            <label>
                                Last name
                                <input name="last_name" type="text" placeholder="Last name"><?php if(isset($_GET['last_name'])){echo $_GET['last_name'];}?>
                            </label>
                        </div>
                        <div class="cell large-4">
                            <label>
                                Other name
                                <input name="other_name" placeholder="Other name" id="filterLastName" type="text" pattern="alpha" value="<?php if(isset($_GET['other_name'])){echo $_GET['other_name'];} ?>">
                            </label>
                        </div>
                    </div>
                    <div class="grid-x">
                        <div class="cell large-6">
                            <label>
                                Email address
                                <input name="email" id="filterEmail" placeholder="example@example.com" type="text" pattern="email" value="<?php if(isset($_GET['email'])){echo $_GET['email'];}?>">
                            </label>
                        </div>
                        <div class="cell large-6">
                            <label>
                                Privileges
                                <select name="privileges">
                                    <option>All</option>
                                    <option value="0">User</option>
                                    <option value="1">Admin</option>
                                </select>
                            </label>
                        </div>
                    </div>
                    <div class="grid-x">
                        <div class="cell large-4">
                            <label>
                                Address
                                <input name="address" id="filterAddress" placeholder="9 example road" type="text" value="<?php if(isset($_GET['address'])){echo $_GET['address'];}?>">
                            </label>
                        </div>
                        <div class="cell large-4">
                            <label>
                                Postcode
                                <input name="postcode" id="filterPostcode" type="text" pattern="postcode" placeholder="TE9 3ET" value="<?php if(isset($_GET['postcode'])){echo $_GET['postcode'];}?>">
                            </label>
                        </div>
                        <div class="cell large-4">
                            <label>
                                Town/City
                                <input name="town" id="filterTown" type="text" placeholder="Town/City" value="<?php if(isset($_GET['town'])){echo $_GET['town'];}?>">
                            </label>
                        </div>
                    </div>
                    <div class="grid-x">
                        <div class="cell large-3">
                            <label>
                                Date of birth (Minimum)
                                <input name="dobmin" id="filterDOBMin" placeholder="02/01/1990" type="text" pattern="date" value="<?php if(isset($_GET['dobmin'])){echo $_GET['dobmin'];}?>">
                            </label>
                        </div>
                        <div class="cell large-3">
                            <label>
                                Date of birth (Maximum)
                                <input name="dobmax" id="filterDOBMax" placeholder="02/05/1990" type="text" pattern="date" value="<?php if(isset($_GET['dobmax'])){echo $_GET['dobmax'];}?>">
                            </label>
                        </div>
                        <div class="cell large-3">
                            <label>
                                Date of registry (Minimum)
                                <input name="dormin" id="filterDORMin" type="text" pattern="date" placholder="TE9 3ET" value="<?php if(isset($_GET['postcode'])){echo $_GET['postcode'];}?>">
                            </label>
                        </div>
                        <div class="cell large-3">
                            <label>
                                Date of registry (Maximum)
                                <input name="dormax" id="filterDORMax" type="text" pattern="date" placholder="TE9 3ET" value="<?php if(isset($_GET['postcode'])){echo $_GET['postcode'];}?>">
                            </label>
                        </div>
                        <div class="cell large-4">
                            <label>
                                Banned status
                                <select name="privileges">
                                    <option>All</option>
                                    <option value="0">Unbanned</option>
                                    <option value="1">Banned</option>
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
        <div class="cell large-12 bd" style="padding:1rem;">
            <div class="grid-x grid-margin-x">
                <?php
                if($options > 0){
                    $users = $user_list[1];
                }else{
                    $users = $databaseHandler->getUsers(9, 0);
                }
                foreach($users as $user){
                    if($user['privileges'] == 0){
                        $header = "<h2>User</h2>";
                        $button = '<button class="button primary" onclick="promoteUser('. $user['id'] .'); return false;">Promote to admin</button>';
                    }else if($user['privileges'] == 1){
                        $header = "<h2>Admin</h2>";
                        $button = '<button class="button primary" onclick="demoteUser('. $user['id'] .'); return false;">Demote to user</button>';
                    }
                    if($user['banned_status'] == 0){
                        $banned_status = "Not banned";
                        $banned_button = '<button class="button alert" onclick="banUser('. $user['id'] .');">Ban user</button>';
                    }else{
                        $banned_status = "Banned";
                        $banned_button = '<button class="button alert" onclick="unbanUser('. $user['id'] .');">Unban user</button>';
                    }
                    $dob = explode("-", $user['dob']);
                    $dateOfRegistry = explode("-", $user["dateOfRegistry"]);
                    echo '
                    <div class="large-4 cell">
                        <div class="card card-rounded">
                            <div class="card-section card-top card-header">
                                '. $header .'
                            </div>
                            <div class="card-section card-mid">
                                <div class="grid-x grid-margin-x">
                                    <div class="large-6 cell">
                                        <div class="field">First name:</div>
                                        <div class="response">'. $user['first_name'] .'</div>
                                        <div class="field">Last name: </div>
                                        <div class="response">'. $user['last_name'] .'</div>
                                        <div class="field">Address: </div>
                                        <div class="response">'. $user['address'] .'</div>
                                        <div class="field">Postcode: </div>
                                        <div class="response">'. $user['postcode'] .'</div>
                                        <div class="field">Town: </div>
                                        <div class="response">'. $user['town'] .'</div>
                                        <div class="field">Date of birth: </div>
                                        <div class="response">'. $dob[2] . "/" . $dob[1] . "/" . $dob[0] .'</div>
                                    </div>
                                    <div class="large-6 cell">
                                        <div class="field">Date of registry: </div>
                                        <div class="response">' . $dateOfRegistry[2] . '/' . $dateOfRegistry[1] . '/' . $dateOfRegistry[0] . '</div>
                                        <div class="field">Email:</div>
                                        <div class="response">'. $user['email'] .'</div>
                                        <div class="field">ID:</div>
                                        <div class="response">'. $user['id'] .'</div>
                                        <div class="field">Banned status:</div>
                                        <div class="response">'. $banned_status .'</div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-section card-bot">
                                <div class="grid-x grid-margin-x">
                                    <div class="large-3 cell">
                                        '. $button .'
                                    </div>
                                    <div class="large-3 cell">
                                        '. $banned_button .'
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    ';
                }
                ?>
            </div>
        </div>
    </div>
    <div class="grid-x grid-margin-x">
        <div class="cell small-11">
            <div class="ui pagination menu">
                <?php
                $count = $databaseHandler->countUsers($options);
                $limit = 9;
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
                    <option <?php if(isset($_GET['limit']) && $_GET['limit'] == 9){echo "selected='selected'";}?> value="9">9</option>
                    <option <?php if(isset($_GET['limit']) && $_GET['limit'] == 27){echo "selected='selected'";}?> value="27">27</option>
                    <option <?php if(isset($_GET['limit']) && $_GET['limit'] == 54){echo "selected='selected'";}?> value="54">54</option>
                    <option <?php if(isset($_GET['limit']) && $_GET['limit'] == 99){echo "selected='selected'";}?> value="99">99</option>
                </select>
            </label>
        </div>
    </div>
</div>