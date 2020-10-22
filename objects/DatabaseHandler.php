<?php
class DatabaseHandler{
    var $host;
    var $port;
    var $username;
    var $password;
    var $database;
    var $site_name;
    var $canConnect;
    var $errorList;

    function __construct(){
        $dir = $_SERVER['DOCUMENT_ROOT'] . "/E-commerce-CMS/configs/database.json";
        if(!file_exists($dir)){
            $dir = $_SERVER['DOCUMENT_ROOT'] . "/configs/database.json";
        }
        $json = file_get_contents($dir);
        $config = json_decode($json, true);
        $this->host = $config['host'];
        $this->port = $config['port'];
        $this->username = $config['username'];
        $this->password = $config['password'];
        $this->database = $config['database'];
        $this->site_name = $config['site_name'];
    }

    //-------------------- Admin panel --------------------//
    //Product management
    function getProducts($limit, $offset, $options){
        $product_list = array();
        //Check if options has been used

        if(isset($options['section_name']) && $options['section_name'] == "All"){
            unset($options['section_name']);
        }

        if(sizeof($options) > 0 && is_array($options)){
            $getVariable = $this->generateVariable($options, "products");
            //Dynamically assign variable
            $optionArray = $getVariable[0];
            $optionList = $getVariable[1];
            $optionTagList = $getVariable[2];
            $optionList = substr($optionList, 0, -4);
            $optionTagList = substr($optionTagList, 0, -4);

            //Prepared statement & execution
            if(isset($options['name'])){
                if(strlen($optionTagList) > 0){
                    $sql = "(SELECT products.id, products.name, products.cost, products.description, products.quantity, products.tags, products.type, sections.name AS section_name FROM products INNER JOIN sections ON products.section_id = sections.id WHERE ". $optionList .") UNION (SELECT products.id, products.name, products.cost, products.description, products.quantity, products.tags, products.type, sections.name AS section_name FROM products INNER JOIN sections ON products.section_id = sections.id WHERE ". $optionTagList ." AND products.tags LIKE :name) LIMIT ". $limit ." OFFSET ". $offset;
                }else{
                    $sql = "(SELECT products.id, products.name, products.cost, products.description, products.quantity, products.tags, products.type, sections.name AS section_name FROM products INNER JOIN sections ON products.section_id = sections.id WHERE ". $optionList .") UNION (SELECT products.id, products.name, products.cost, products.description, products.quantity, products.tags, products.type, sections.name AS section_name FROM products INNER JOIN sections ON products.section_id = sections.id WHERE products.tags LIKE :name) LIMIT ". $limit ." OFFSET ". $offset;
                }
            }else{
                $sql = "(SELECT products.id, products.name, products.cost, products.description, products.quantity, products.tags, products.type, sections.name AS section_name FROM products INNER JOIN sections ON products.section_id = sections.id WHERE ". $optionList .") LIMIT ". $limit ." OFFSET ". $offset;
            }

            try{
                if($this->port != ""){
                    $connection = new PDO('mysql:host='.$this->host.';port='.$this->port.';dbname='.$this->database, $this->username, $this->password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
                }else{
                    $connection = new PDO('mysql:host='.$this->host.';dbname='.$this->database, $this->username, $this->password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
                }

                $stmt = $connection->prepare($sql);
                $stmt->execute($optionArray);
                $data = $stmt->fetchAll();

                //Get result of the query
                foreach($data as $result){
                    $productResult = &$result;
                    $product = new Product($productResult['id'], $productResult['name'], $productResult['cost'], $productResult['description'], $productResult['quantity'], explode(",", $productResult['tags']), $productResult['type'], $productResult['section_name']);
                    array_push($product_list, $product);
                }
                //Close connection
                $connection = null;
            }catch(PDOException $e){
                $product_list = array("status", "error");
                return $product_list;
            }
        }else{

            $sql = "SELECT products.id, products.name, products.cost, products.description, products.quantity, products.tags, products.type, sections.name AS section_name FROM `products` INNER JOIN sections ON products.section_id = sections.id LIMIT ". $limit ." OFFSET ". $offset .";";

            $connection = new mysqli($this->host, $this->username, $this->password, $this->database);

            $get = $connection->query($sql);
            for($i = 0; $i < $get->num_rows; $i++){
                $result = $get->fetch_array(MYSQLI_ASSOC);
                $product = new Product($result['id'], $result['name'], $result['cost'], $result['description'], $result['quantity'], explode(",", $result['tags']), $result['type'], $result['section_name']);
                array_push($product_list, $product);
            }
            $connection = null;
        }
        $product_list = array(array("status"=>"success"), $product_list);
        return $product_list;
    }

    function getProductsSort($limit, $offset, $sort, $direction, $options){
        if($sort == "section"){
            $sort = "section_name";
        }
        $product_list = array();
        if($this->sortingValidation($limit, $offset, $sort, $direction)){
            if(sizeof($options) > 0){
                $getVariable = $this->generateVariable($options, "products");
                //Dynamically assign variable
                $optionArray = $getVariable[0];
                $optionList = $getVariable[1];
                $param_type = $getVariable[2];
                $optionList = substr($optionList, 0, -4);
                //Prepared statement & execution
                $sql = "SELECT products.id, products.name, products.cost, products.description, products.quantity, products.tags, products.type, sections.name AS section_name FROM `products` INNER JOIN sections ON products.section_id = sections.id WHERE ". $optionList ." ORDER BY ". $sort ." ". $direction ." LIMIT ". $limit ." OFFSET ". $offset .";";
                try{
                    if($this->port != ""){
                        $connection = new PDO('mysql:host='.$this->host.';port='.$this->port.';dbname='.$this->database, $this->username, $this->password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
                    }else{
                        $connection = new PDO('mysql:host='.$this->host.';dbname='.$this->database, $this->username, $this->password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
                    }
                    $stmt = $connection->prepare($sql);
                    $stmt->execute($optionArray);
                    $data = $stmt->fetchAll();
                    //Get result of the query
                    foreach($data as $result){
                        $productResult = &$result;
                        $product = new Product($productResult['id'], $productResult['name'], $productResult['cost'], $productResult['description'], $productResult['quantity'], explode(",", $productResult['tags']), $productResult['type'], $productResult['section_name']);
                        array_push($product_list, $product);
                    }

                    //Close connection
                    $connection = null;
                }catch(PDOException $e){
                    $product_list = array("status", "error");
                    return $product_list;
                }
            }else{
                $sql = "SELECT products.id, products.name, products.cost, products.description, products.quantity, products.tags, products.type, sections.name AS section_name FROM `products` INNER JOIN sections ON products.section_id = sections.id ORDER BY ". $sort ." ". $direction ." LIMIT ". $limit ." OFFSET ". $offset .";";

                if($this->port != ""){
                    $connection = new PDO('mysql:host='.$this->host.';port='.$this->port.';dbname='.$this->database, $this->username, $this->password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
                }else{
                    $connection = new PDO('mysql:host='.$this->host.';dbname='.$this->database, $this->username, $this->password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
                }

                $stmt = $connection->prepare($sql);
                $stmt->execute();
                $data = $stmt->fetchAll();
                foreach($data as $result){
                    $productResult = &$result;
                    $product = new Product($productResult['id'], $productResult['name'], $productResult['cost'], $productResult['description'], $productResult['quantity'], explode(",", $productResult['tags']), $productResult['type'], $productResult['section_name']);
                    array_push($product_list, $product);
                }
                $connection = null;
            }

            $product_list = array(array("status"=>"success"), $product_list);
            return $product_list;
        }
    }

    function countProducts($options){
        if(sizeof($options) > 0){
            $getVariable = $this->generateVariable($options, "products");
            $optionArray = $getVariable[0];
            $optionList = $getVariable[1];
            $optionList = substr($optionList, 0, -4);
            $sql = "SELECT COUNT(id) AS Total FROM products WHERE ". $optionList .";";

            //Prepared statement & execution
            $connection = new PDO('mysql:host='.$this->host.';dbname='.$this->database, $this->username, $this->password);
            $stmt = $connection->prepare($sql);
            $stmt->execute($options);
            $data = $stmt->fetchAll();

            //Get result of the query
            //Close connection
            $connection = null;
            return $data[0]['Total'];
        }else{
            $sql = "SELECT COUNT(id) AS Total FROM `e_commerce_database`.`products`;";

            $connection = new PDO('mysql:host='.$this->host.';dbname='.$this->database, $this->username, $this->password);
            $stmt = $connection->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetchAll();
            $connection = null;
            return $data[0]['Total'];
        }
    }

    function countCoupons(){
        $sql = "SELECT COUNT(id) FROM coupon";

        $connection = new PDO('mysql:host='.$this->host.';dbname='.$this->database, $this->username, $this->password);
        $stmt = $connection->prepare($sql);
        $stmt->execute();
        $data = $stmt->fetchAll();

        return $data;
    }

    function countTransactions(){
        $sql = "SELECT COUNT(id) FROM transactions";

        $connection = new PDO('mysql:host='.$this->host.';dbname='.$this->database, $this->username, $this->password);
        $stmt = $connection->prepare($sql);
        $stmt->execute();
        $data = $stmt->fetchAll();

        return $data;
    }

    function countProductsByName($options){
        //Check if options has been used

        if(isset($options['section_name']) && $options['section_name'] == "All"){
            unset($options['section_name']);
        }

        if(sizeof($options) > 0 && is_array($options)){
            $getVariable = $this->generateVariable($options, "products");
            //Dynamically assign variable
            $optionArray = $getVariable[0];
            $optionList = $getVariable[1];
            $optionList = substr($optionList, 0, -4);

            //Prepared statement & execution
            if(isset($options['name'])){
                $sql = "(SELECT products.id, products.name, products.cost, products.description, products.quantity, products.tags, products.type, sections.name AS section_name FROM products INNER JOIN sections ON products.section_id = sections.id WHERE ". $optionList .") UNION (SELECT products.id, products.name, products.cost, products.description, products.quantity, products.tags, products.type, sections.name AS section_name FROM products INNER JOIN sections ON products.section_id = sections.id WHERE products.tags LIKE :name)";
            }else{
                $sql = "(SELECT products.id, products.name, products.cost, products.description, products.quantity, products.tags, products.type, sections.name AS section_name FROM products INNER JOIN sections ON products.section_id = sections.id WHERE ". $optionList .")";
            }
            try{
                if($this->port != ""){
                    $connection = new PDO('mysql:host='.$this->host.';port='.$this->port.';dbname='.$this->database, $this->username, $this->password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
                }else{
                    $connection = new PDO('mysql:host='.$this->host.';dbname='.$this->database, $this->username, $this->password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
                }

                $stmt = $connection->prepare($sql);
                $stmt->execute($optionArray);
                $data = $stmt->rowCount();
                //Close connection
                $connection = null;
            }catch(PDOException $e){
                return 0;
            }
        }else{

            $sql = "SELECT products.id, products.name, products.cost, products.description, products.quantity, products.tags, products.type, sections.name AS section_name FROM `products` INNER JOIN sections ON products.section_id = sections.id";

            $connection = new PDO('mysql:host='.$this->host.';dbname='.$this->database, $this->username, $this->password);
            $stmt = $connection->prepare($sql);
            $stmt->execute();

            $data = $stmt->rowCount();

            $connection = null;
        }
        return $data;
    }

    function getProductRating($id){
        $parametersArray = array("id" => $id);
        $sql = "SELECT AVG(ratings.score) FROM ratings WHERE product_id = :id";

        $connection = new PDO('mysql:host='.$this->host.';dbname='.$this->database, $this->username, $this->password);
        $stmt = $connection->prepare($sql);
        $stmt->execute($parametersArray);

        $data = $stmt->fetchAll();

        return $data;
    }

    function getLatestProducts(){
        $sql = "SELECT * FROM products ORDER BY id DESC LIMIT 6";

        $connection = new PDO('mysql:host='.$this->host.';dbname='.$this->database, $this->username, $this->password);
        $stmt = $connection->prepare($sql);
        $stmt->execute();

        $data = $stmt->fetchAll();

        return $data;
    }

    function getProductStock($id){
        $parameters = array('id' => $id);

        $sql = "SELECT products.quantity FROM products WHERE id = :id";

        $connection = new PDO('mysql:host='.$this->host.';dbname='.$this->database, $this->username, $this->password);
        $stmt = $connection->prepare($sql);
        $stmt->execute($parameters);

        $data = $stmt->fetchAll();

        return $data;
    }

    function getProduct($id){
        $idArray = array();

        array_push($idArray, $id);
        $sql = "SELECT products.id, products.name, products.cost, products.description, products.quantity, products.tags, products.type, sections.name AS section_name FROM `products` INNER JOIN sections ON products.section_id = sections.id WHERE products.id = ?";

        $connection = new PDO('mysql:host='.$this->host.';dbname='.$this->database, $this->username, $this->password);
        $stmt = $connection->prepare($sql);
        $stmt->execute($idArray);
        $data = $stmt->fetchAll();
        $connection = null;
        if(!empty($data)){
            return $data[0];
        }else{
            return null;
        }

    }

    function rateProduct($id, $rating){
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if(isset($_SESSION['id'])){
            $user_id = $_SESSION['id'];
        }else{
            echo "user-not-logged-in";
            return;
        }

        $parameters = array('user_id' => $user_id, 'product_id' => $id);

        $sql = "SELECT * FROM ratings WHERE user_id = :user_id AND product_id = :product_id";

        $connection = new PDO('mysql:host='.$this->host.';dbname='.$this->database, $this->username, $this->password);
        $stmt = $connection->prepare($sql);
        $stmt->execute($parameters);

        if($stmt->rowCount() > 0){
            $data = $stmt->fetchAll();
            $parameters = array('id' => $data[0]['id'], 'score' => $rating);
            $sql = "UPDATE ratings SET score = :score WHERE id = :id";
            $stmt = $connection->prepare($sql);
            $stmt->execute($parameters);

            if($stmt->rowCount() > 0){
                return true;
            }else{
                return false;
            }
        }else{
            $sql = "INSERT INTO ratings(product_id, user_id, score) VALUES(:product_id, :user_id, :score)";
            $parameters = array("product_id" => $id, "user_id" => $user_id, "score" => $rating);
            $stmt = $connection->prepare($sql);
            $stmt->execute($parameters);

            if($stmt->rowCount() > 0){
                return true;
            }else{
                return false;
            }

        }

    }

    function sortingValidation($limit, $offset, $sort, $direction){
        $validSorting = array("id", "name", "cost", "quantity", "type", "section_name");
        $validDirection = array("asc", "desc");
        $validLimit = array(10, 25, 50, 100);
        if(!in_array($sort, $validSorting)){
            return false;
        }
        if(!in_array($direction, $validDirection)){
            return false;
        }
        if(!in_array($limit, $validLimit)){
            return false;
        }
        return true;
    }

    function updateProduct($product){
        unset($product['thumbnail']);
        $sql = "UPDATE products SET name = :name, cost = :cost, description = :description, quantity = :quantity, tags = :tags, type = :type, section_id = :section_id WHERE id = :id";

        $connection = new PDO('mysql:host='.$this->host.';dbname='.$this->database, $this->username, $this->password);
        $stmt = $connection->prepare($sql);
        $stmt->execute($product);

        $sql = "UPDATE archive_products name = :name, cost = :cost, description = :description, quantity = :quantity, tags = :tags, type = :type, section_id = :section_id WHERE id = :id";
        $stmt = $connection->prepare($sql);
        $stmt->execute($product);
    }

    function createProduct($data){
        unset($data['id']);

        $sql = "INSERT INTO products (name, cost, description, quantity, tags, type, section_id) VALUES (:name, :cost, :description, :quantity, :tags, :type, :section_id);";

        $connection = new PDO('mysql:host='.$this->host.';dbname='.$this->database, $this->username, $this->password);
        $stmt = $connection->prepare($sql);
        $stmt->execute($data);

        $id = $connection->lastInsertId();

        $sql = "INSERT INTO archive_products (id, name, cost, description, quantity, tags, type, section_id) VALUES (:id, :name, :cost, :description, :quantity, :tags, :type, :section_id);";
        $stmt2 = $connection->prepare($sql);
        $data['id'] = $id;
        $stmt2->execute($data);

        return $id;
    }

    function createCoupon($code, $description, $amount, $usages, $expiry){
        $parameters = array('code' => "%" . $code . "%");
        $sql = "SELECT * FROM coupon WHERE code LIKE :code";

        $connection = new PDO('mysql:host='.$this->host.';dbname='.$this->database, $this->username, $this->password);
        $stmt = $connection->prepare($sql);
        $stmt->execute($parameters);

        if($stmt->rowCount() > 0){
            echo "code-exist";
        }else{
            $sql = "INSERT INTO coupon(code, description, amount, usages, expiry, created) VALUES(:code, :description, :amount, :usages, :expiry, :created)";
            $parameters = array('code' => $code, 'description' => $description, "amount" => $amount, "usages" => $usages, "expiry" => $expiry, "created" => date("Y-m-d", time()));

            $stmt = $connection->prepare($sql);
            $stmt->execute($parameters);

            if($connection->lastInsertId() > 0){
                echo "true";
            }else{
                echo "false";
            }
        }
    }

    function updateCoupon($id, $code, $description, $amount, $usages, $expiry){
        $connection = new PDO('mysql:host='.$this->host.';dbname='.$this->database, $this->username, $this->password);

        $sql = "UPDATE coupon SET code = :code, description = :description, amount = :amount, usages = :usages, expiry = :expiry WHERE id = :id";
        $parameters = array('id' => $id, 'code' => $code, 'description' => $description, "amount" => $amount, "usages" => $usages, "expiry" => $expiry);

        $stmt = $connection->prepare($sql);
        $stmt->execute($parameters);

        if($stmt->rowCount() > 0){
            echo "true";
        }else{
            echo "false";
        }
    }

    function addCategory($category){
        $sql = "SELECT * FROM sections WHERE name LIKE :category";

        $parameters = array('category' => "%".$category."%");

        $connection = new PDO('mysql:host='.$this->host.';dbname='.$this->database, $this->username, $this->password);
        $stmt = $connection->prepare($sql);
        $stmt->execute($parameters);

        if($stmt->rowCount() == 0){
            $sql = "INSERT INTO sections(name) VALUES(:category)";

            $parameters['category'] = $category;

            $stmt = $connection->prepare($sql);
            $stmt->execute($parameters);

            echo $connection->lastInsertId();
        }else{
            echo "category-exist";
        }
    }

    function deleteProduct($id){
        $sql = "DELETE FROM products WHERE id = :id";

        $connection = new PDO('mysql:host='.$this->host.';dbname='.$this->database, $this->username, $this->password);
        $stmt = $connection->prepare($sql);
        $stmt->execute($id);

        echo "true";
        $connection = null;
    }

    function getProductQuantity($id){
        $parameters = array("id" => $id);

        $sql = "SELECT products.quantity FROM products WHERE id = :id";

        $connection = new PDO('mysql:host='.$this->host.';dbname='.$this->database, $this->username, $this->password);
        $stmt = $connection->prepare($sql);
        $stmt->execute($parameters);

        return $stmt->fetchAll();
    }

    // End of product management //

    // User management //

    function getUsers($limit, $offset){
        $sql = "SELECT * FROM users LIMIT 9 OFFSET 0";

        $connection = new PDO('mysql:host='.$this->host.';dbname='.$this->database, $this->username, $this->password);
        $stmt = $connection->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    function validatePassword($id, $password){
        $parameters = array('id' => $id);
        $sql = "SELECT users.password FROM users WHERE id = :id";

        $connection = new PDO('mysql:host='.$this->host.';dbname='.$this->database, $this->username, $this->password);
        $stmt = $connection->prepare($sql);
        $stmt->execute($parameters);

        $data = $stmt->fetchAll();

        if(password_verify($password, $data[0]['password'])){
            return true;
        }else{
            return false;
        }
    }

    function updateUser($parameters){
        if(isset($parameters['email'])){
            $dob = strtotime($parameters['dob']);
            if($dob != ""){
                if(time() - $dob > 18 * 31536000 && time() - $dob < 150 * 31536000){
                    $sql = "UPDATE users SET first_name = :first_name, last_name = :last_name, other_name = :other_name, email = :email, telephone = :telephone, address = :address, postcode = :postcode, town = :town, dob = :dob WHERE id = :id";
                }else{
                    echo "incorrect-date";
                    return;
                }
            }else{
                echo "incorrect-date";
                return;
            }
        }else{
            $dob = strtotime($parameters['dob']);
            if($dob != ""){
                if(time() - $dob > 18 * 31536000 && time() - $dob < 150 * 31536000){
                    $sql = "UPDATE users SET first_name = :first_name, last_name = :last_name, other_name = :other_name, telephone = :telephone, address = :address, postcode = :postcode, town = :town, dob = :dob WHERE id = :id";
                }else{
                    echo "incorrect-date";
                    return;
                }
            }else{
                echo "incorrect-date";
                return;
            }
        }

        $connection = new PDO('mysql:host='.$this->host.';dbname='.$this->database, $this->username, $this->password);
        $stmt = $connection->prepare($sql);
        $stmt->execute($parameters);

        return $stmt->rowCount();
    }

    function changePassword($currentPassword, $newPassword){
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $sql = "SELECT * FROM users WHERE id = :id";


        if(isset($_SESSION['id'])){
            $parameters = array('id' => $_SESSION['id']);
        }else{
            return false;
        }

        $connection = new PDO('mysql:host='.$this->host.';dbname='.$this->database, $this->username, $this->password);
        $stmt = $connection->prepare($sql);
        $stmt->execute($parameters);

        $user = $stmt->fetchAll();

        if(password_verify($currentPassword, $user[0]['password'])){
            $sql = "UPDATE users SET password = :password WHERE id = :id";
            $parameters['password'] = password_hash($newPassword, PASSWORD_DEFAULT);

            $stmt = $connection->prepare($sql);
            $stmt->execute($parameters);

            if($stmt->rowCount() > 0){
                if(isset($_COOKIE['rememberme'])){
                    unset($_COOKIE['rememberme']);
                    $this->setCookieUser($_SESSION['id']);
                }
            }

            return $stmt->rowCount();
        }else{
            return "incorrect-password";
        }

    }

    function getUser($id){
        $parametersArray = array();

        $parametersArray['id'] = $id;


        $sql = "SELECT first_name, last_name, other_name, email, telephone, address, postcode, town, dob, dateOfRegistry FROM users WHERE id = :id";

        $connection = new PDO('mysql:host='.$this->host.';dbname='.$this->database, $this->username, $this->password);
        $stmt = $connection->prepare($sql);
        $stmt->execute($parametersArray);

        return $stmt->fetchAll()[0];
    }

    function getUsersSort($limit, $offset, $options){
        $user_list = array();
        if(sizeof($options) > 0){
            $getVariable = $this->generateVariable($options, "users");
            //Dynamically assign variable
            $optionArray = $getVariable[0];
            $optionList = $getVariable[1];
            $optionList = substr($optionList, 0, -4);
            //Prepared statement & execution
            $sql = "SELECT * FROM `users` WHERE ". $optionList ." LIMIT ". $limit ." OFFSET ". $offset .";";
            try{
                if($this->port != ""){
                    $connection = new PDO('mysql:host='.$this->host.';port='.$this->port.';dbname='.$this->database, $this->username, $this->password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
                }else{
                    $connection = new PDO('mysql:host='.$this->host.';dbname='.$this->database, $this->username, $this->password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
                }
                $stmt = $connection->prepare($sql);
                $stmt->execute($optionArray);
                $data = $stmt->fetchAll();
                //Get result of the query
                foreach($data as $result){
                    array_push($user_list, $result);
                }

                //Close connection
                $connection = null;
            }catch(PDOException $e){
                $user_list = array("status", "error");
                return $user_list;
            }
        }else{
            $array = array();
            $sql = "SELECT * FROM `users` ORDER BY `id` ASC LIMIT " . $limit . " OFFSET " . $offset;

            if($this->port != ""){
                $connection = new PDO('mysql:host='.$this->host.';port='.$this->port.';dbname='.$this->database, $this->username, $this->password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
            }else{
                $connection = new PDO('mysql:host='.$this->host.';dbname='.$this->database, $this->username, $this->password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
            }

            $stmt = $connection->prepare($sql);
            $stmt->execute($array);
            $data = $stmt->fetchAll();

            foreach($data as $result){
                array_push($user_list, $result);
            }

            $connection = null;
        }

        $user_list = array(array("status"=>"success"), $user_list);
        return $user_list;
    }

    function countUsers($options){
        if(sizeof($options) > 0){
            $getVariable = $this->generateVariable($options, "users");
            $optionArray = $getVariable[0];
            $optionList = $getVariable[1];
            $optionList = substr($optionList, 0, -4);
            $sql = "SELECT COUNT(id) AS Total FROM users WHERE ". $optionList .";";

            //Prepared statement & execution
            $connection = new PDO('mysql:host='.$this->host.';dbname='.$this->database, $this->username, $this->password);
            $stmt = $connection->prepare($sql);
            $stmt->execute($options);
            $data = $stmt->fetchAll();

            //Get result of the query
            //Close connection
            $connection = null;
            return $data[0]['Total'];
        }else{
            $sql = "SELECT COUNT(id) AS Total FROM `e_commerce_database`.`users`;";

            $connection = new PDO('mysql:host='.$this->host.';dbname='.$this->database, $this->username, $this->password);
            $stmt = $connection->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetchAll();
            $connection = null;
            return $data[0]['Total'];
        }
    }

    function validateEmail($email){
        $emailArray = array();
        $emailArray['email'] = $email;
        $sql = "SELECT COUNT(id) AS user FROM e_commerce_database.users WHERE email = :email";

        $connection = new PDO('mysql:host='.$this->host.';dbname='.$this->database, $this->username, $this->password);
        $stmt = $connection->prepare($sql);
        $stmt->execute($emailArray);
        $data = $stmt->fetchAll();
        if($data[0]['user'] >= 1){
            return false;
        }else{
            return true;
        }
    }

    function createUser($user){
        if(!isset($user['privileges'])){
            $user['privileges'] = 0;
        }
        if(!isset($user['other_name'])){
            $user['other_name'] = "";
        }
        $user['verification_code'] = substr(md5(uniqid(rand(), true)), 8, 8);
        $user['verified'] = 1;
        $user['password'] = password_hash($user['password'], PASSWORD_DEFAULT);
        $user['dateOfRegistry'] = date("Y-m-d");
        $dob = explode("/", $user['dob']);
        $dob = strtotime($user['dob']);
        if($dob != ""){
            if(time() - $dob > 18 * 31536000 && time() - $dob < 150 * 31536000){
                $sql = "INSERT INTO users (first_name, last_name, other_name, email, password, address, postcode, town, telephone, dob, dateOfRegistry, privileges, verified, verification_code) VALUES(:first_name, :last_name, :other_name, :email, :password, :address, :postcode, :town, :telephone, :dob, :dateOfRegistry, :privileges, :verified, :verification_code)";

                $connection = new PDO('mysql:host='.$this->host.';dbname='.$this->database, $this->username, $this->password);
                $stmt = $connection->prepare($sql);
                $stmt->execute($user);

                $id = $connection->lastInsertId();

                echo $id;
                /*
            if($id > -1){
                $verificationLink = "http://{$this->site_name}.co.uk/scripts/activate.php?code=" . $user['verification_code'];
                $verificationLink = "http://localhost/scripts/activate.php?code=" . $user['verification_code'];

                $htmlStr = "";
                $htmlStr .= "Hi " . $user['email'] . ",<br /><br />";

                $htmlStr .= "Please click the button below to verify your subscription and have access to the download center.<br /><br /><br />";
                $htmlStr .= "<a href='{$verificationLink}' target='_blank' style='padding:1em; font-weight:bold; background-color:blue; color:#fff;'>VERIFY EMAIL</a><br /><br /><br />";

                $htmlStr .= "Kind regards,<br />";
                $htmlStr .= "<a href='http://{$this->site_name}.co.uk/' target='_blank'>{$this->site_name}</a><br />";

                $from = "no-reply@". $this->site_name . ".co.uk";
                $to = $user['email'];
                $subject = $this->site_name . ": Verify account";
                $message = "PHP mail works just fine";
                $headers = "From: {$this->site_name} <{$from}> \n";
                $headers .= " Content-type: text/html; charset=iso-8859-1\r\n";
                mail($to,$subject,$htmlStr, $headers);
            }
            */
            }else{
                echo "agefalse";
            }
            $connection = null;
        }else{
            echo "invalid-dob";
        }
    }

    function loginUser($user){
        $parametersArray = array();

        $parametersArray['email'] = $user['email'];

        $sql = "SELECT id, email, password, privileges, banned_status FROM users WHERE email = :email";

        $connection = new PDO('mysql:host='.$this->host.';dbname='.$this->database, $this->username, $this->password);

        $stmt = $connection->prepare($sql);

        $stmt->execute($parametersArray);

        $result = $stmt->fetchAll();
        if(sizeof($result) > 0){
            $result = $result[0];
            if($result['banned_status'] != 1){
                if(password_verify($user['password'], $result['password'])){
                    if($user['rememberme'] == "true"){
                        if(isset($_COOKIE['accept-cookies'])){
                            $this->setCookieUser($result['id']);
                        }
                    }
                    if (session_status() == PHP_SESSION_NONE) {
                        session_start();
                    }
                    if($result['privileges'] == "1"){
                        $_SESSION['admin'] = true;
                    }
                    $_SESSION['loggedIn'] = true;
                    $_SESSION['id'] = $result['id'];
                    if(isset($_SESSION['cart'])){
                        $cart = explode("|", $_SESSION['cart']);
                        $array = array();

                        foreach($cart as $product){
                            $data = explode(",", $product);
                            $sql = "INSERT INTO cart(product_id, user_id, quantity) VALUES (:product_id, :user_id, :quantity)";
                            $parameters = array('product_id' => $data[0], 'user_id' => $_SESSION['id'], 'quantity' => $data[1]);

                            $stmt = $connection->prepare($sql);
                            $stmt->execute($parameters);
                        }
                    }

                    echo "true";
                }else{
                    echo "wrong-password";
                }
            }else{
                echo "user-banned";
            }
        }else{
            echo "user-not-found";
        }
    }

    function promoteUser($id){
        $idArray = array();
        $idArray['id'] = $id;
        $idArray['privileges'] = 1;

        $sql = "UPDATE users SET privileges = :privileges WHERE id = :id";

        $connection = new PDO('mysql:host='.$this->host.';dbname='.$this->database, $this->username, $this->password);
        $stmt = $connection->prepare($sql);
        $stmt->execute($idArray);

        echo $stmt->rowCount();
        $connection = null;
    }

    function demoteUser($id){
        $idArray = array();
        $idArray['id'] = $id;
        $idArray['privileges'] = 0;

        $sql = "UPDATE users SET privileges = :privileges WHERE id = :id";

        $connection = new PDO('mysql:host='.$this->host.';dbname='.$this->database, $this->username, $this->password);
        $stmt = $connection->prepare($sql);
        $stmt->execute($idArray);

        echo $stmt->rowCount();
        $connection = null;
    }

    function banUser($id){
        $idArray = array();
        $idArray['id'] = $id;
        $idArray['banned_status'] = 1;

        $sql = "UPDATE users SET banned_status = :banned_status WHERE id = :id";

        $connection = new PDO('mysql:host='.$this->host.';dbname='.$this->database, $this->username, $this->password);
        $stmt = $connection->prepare($sql);
        $stmt->execute($idArray);

        echo $stmt->rowCount();
        $connection = null;
    }

    function unbanUser($id){
        $idArray = array();
        $idArray['id'] = $id;
        $idArray['banned_status'] = 0;

        $sql = "UPDATE users SET banned_status = :banned_status WHERE id = :id";

        $connection = new PDO('mysql:host='.$this->host.';dbname='.$this->database, $this->username, $this->password);
        $stmt = $connection->prepare($sql);
        $stmt->execute($idArray);

        echo $stmt->rowCount();
        $connection = null;
    }

    function setCookieUser($id){
        $parametersArray = array();

        $selector = uniqid(mt_rand(), true);
        $salt = uniqid(mt_rand(), true);
        $crypted = crypt($selector, $salt);
        $parametersArray['id'] = $id;

        $sql = "SELECT * FROM auth_tokens WHERE userid = :id";

        $connection = new PDO('mysql:host='.$this->host.';dbname='.$this->database, $this->username, $this->password);

        $stmt = $connection->prepare($sql);

        $stmt->execute($parametersArray);

        $data = $stmt->fetchAll();

        $parametersArray['selector'] = $selector;
        $parametersArray['hashedValidator'] = $crypted;

        if($stmt->rowCount() < 1){
            $sql = "INSERT INTO auth_tokens (selector, hashedValidator, userid) VALUES (:selector, :hashedValidator, :id);";

            $stmt = $connection->prepare($sql);

            $stmt->execute($parametersArray);
        }else{
            $sql = "UPDATE auth_tokens SET selector = :selector, hashedValidator = :hashedValidator WHERE userid = :id;";

            $stmt = $connection->prepare($sql);

            $stmt->execute($parametersArray);
        }

        setcookie("rememberme", $selector . "%" . $salt, time() + (84600 * 365), "/");
    }

    function getCookieUser($cookie_number){
        //Check if cookie was set
        if(isset($_COOKIE['rememberme'])){
            $parametersArray = array();

            $credentials = explode("%", $_COOKIE['rememberme']);

            $parametersArray['selector'] = $credentials[0];

            $connection = new PDO('mysql:host='.$this->host.';dbname='.$this->database, $this->username, $this->password);

            $sql = "SELECT * FROM auth_tokens WHERE selector = :selector";

            $stmt = $connection->prepare($sql);

            $stmt->execute($parametersArray);

            if($stmt->rowCount() > 0){
                $data = $stmt->fetchAll()[0];

                if(crypt($credentials[0], $credentials[1]) == $data['hashedValidator']){
                    $parametersArray = array();

                    $parametersArray['id'] = $data['userid'];

                    $sql = "SELECT id, privileges FROM users WHERE id = :id";

                    $stmt = $connection->prepare($sql);

                    $stmt->execute($parametersArray);

                    $data = $stmt->fetchAll()[0];

                    if (session_status() == PHP_SESSION_NONE) {
                        session_start();
                    }

                    $_SESSION['id'] = $data['id'];
                    $_SESSION['privileges'] = $data['privileges'];
                    $_SESSION['loggedIn'] = true;

                    echo "true";
                }else{
                    echo "invalid";
                }
            }else{
                echo "noId";
            }
        }
    }

    //End of user management //

    // Front end //

    function getCart(){
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if(isset($_SESSION['id'])){
            $parametersArray = array();

            $parametersArray['id'] = $_SESSION['id'];

            $sql = "SELECT cart.id AS cart_id, cart.user_id, cart.quantity, products.name, products.id AS products_id, products.cost AS products_cost FROM `cart` INNER JOIN products ON products.id = product_id WHERE user_id = :id";

            $connection = new PDO('mysql:host='.$this->host.';dbname='.$this->database, $this->username, $this->password);

            $stmt = $connection->prepare($sql);
            $stmt->execute($parametersArray);
            $data = $stmt->fetchAll();
            return $data;
        }else{
            if(isset($_SESSION['cart'])){
                $cart = array();

                $cart['type'] = 'session';
                $cart['cart'] = explode('|', $_SESSION['cart']);
                return $cart;
            }else{
                return null;
            }
        }
    }

    function checkCoupon($couponCode){
        $sql = "SELECT * FROM coupon WHERE code = :coupon";

        $parameters = array('coupon' => strtoupper($couponCode));
        $connection = new PDO('mysql:host='.$this->host.';dbname='.$this->database, $this->username, $this->password);

        $stmt = $connection->prepare($sql);
        $stmt->execute($parameters);
        $data = $stmt->fetchAll();

        if(sizeof($data) > 0){
            if(strtotime($data[0]['expiry']) < time()){
                return "false";
            }else{
                if($data[0]['usages'] > 0){
                    $parameters = array('coupon' => $data[0]['id']);
                    $sql = "SELECT COUNT(coupon) AS usages FROM transactions WHERE coupon = :coupon";

                    $stmt = $connection->prepare($sql);
                    $stmt->execute($parameters);
                    $checkUsage = $stmt->fetchAll();
                    if($checkUsage[0]['usages'] <= $data[0]['usages']){
                        return "false";
                    }else{
                        return $data;
                    }
                }else{
                    return $data;
                }
            }
        }else{
            return "false";
        }
    }

    function getCoupon($id){
        $sql = "SELECT * FROM coupon WHERE id = :id";

        $parameters = array("id" => $id);

        $connection = new PDO('mysql:host='.$this->host.';dbname='.$this->database, $this->username, $this->password);

        $stmt = $connection->prepare($sql);
        $stmt->execute($parameters);

        return $stmt->fetchAll();
    }

    function getCouponList($options, $limit, $page){
        if($page < 1){
            $page = 1;
        }
        if(isset($page)){
            $sql = "SELECT * FROM coupon LIMIT " . $limit . " OFFSET " . ($limit * ($page-1));
        }else{
            $sql = "SELECT * FROM coupon LIMIT " . $limit;
        }

        $connection = new PDO('mysql:host='.$this->host.';dbname='.$this->database, $this->username, $this->password);

        $stmt = $connection->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    function updateCartQuantity($cart_id, $quantity){
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if(isset($_SESSION['id'])){
            $parametersArray = array();

            $parametersArray['cart_id'] = $cart_id;
            $sql = "SELECT * FROM cart WHERE id = :cart_id";
            $connection = new PDO('mysql:host='.$this->host.';dbname='.$this->database, $this->username, $this->password);

            $stmt = $connection->prepare($sql);
            $stmt->execute($parametersArray);

            $result = $stmt->fetchAll();

            $quantityCheck = $this->getProductStock($result[0]['product_id'])[0][0];

            if($quantityCheck < $quantity){
                echo "not-enough-stock";
                return;
            }else{
                $parametersArray['quantity'] = $quantity;

                $sql = "UPDATE cart SET quantity = :quantity WHERE id = :cart_id";

                $connection = new PDO('mysql:host='.$this->host.';dbname='.$this->database, $this->username, $this->password);

                $stmt = $connection->prepare($sql);
                $stmt->execute($parametersArray);
                echo $stmt->rowCount();
            }
        }else{
            echo "false";
        }
    }

    function removeProductFromCart($cart_id){
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if(isset($_SESSION['id'])){
            $parametersArray = array();

            $parametersArray['cart_id'] = $cart_id;

            $sql = "DELETE FROM cart WHERE id = :cart_id";

            $connection = new PDO('mysql:host='.$this->host.';dbname='.$this->database, $this->username, $this->password);

            $stmt = $connection->prepare($sql);
            $stmt->execute($parametersArray);
            return $stmt->rowCount();
        }else{
            return "false";
        }
    }

    function getProductsFromId($sql, $productArray){

        $connection = new PDO('mysql:host='.$this->host.';dbname='.$this->database, $this->username, $this->password);

        $stmt = $connection->prepare($sql);

        $stmt->execute($productArray);

        return $stmt->fetchAll();
    }

    function completeTransaction($user_id, $transactionType, $shipping, $coupon){
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $parameters = array("user_id" => $user_id);
        $sql = "SELECT product_id, quantity FROM cart WHERE user_id = :user_id";

        $connection = new PDO('mysql:host='.$this->host.';dbname='.$this->database, $this->username, $this->password);

        $stmt = $connection->prepare($sql);
        $stmt->execute($parameters);

        $data = $stmt->fetchAll();

        $productArray = "";

        foreach($data as $product){
            $productArray .= $product['product_id'] . "," . $product['quantity'] . "|";
        }

        $productArray = substr($productArray, 0, -1);

        if(isset($coupon) && $coupon != null){
            $parameters = array("user_id" => $user_id, "paymentMethod" => $transactionType, "shipping_id"=>$shipping, "status" => "Processing", "products" => $productArray, "date" => date("Y-m-d"), "coupon" => $coupon);

            $sql = "INSERT INTO transactions (customer, paymentMethod, shipping_id, status, products, date, coupon) VALUES(:user_id, :paymentMethod, :shipping_id, :status, :products, :date, :coupon)";

            $stmt = $connection->prepare($sql);
            $stmt->execute($parameters);

            $lastId = $connection->lastInsertId();

            if($lastId > -1){
                $sql = "DELETE FROM cart WHERE user_id = :user_id";

                $parameters = array("user_id" => $user_id);

                $stmt = $connection->prepare($sql);
                $stmt->execute($parameters);

                foreach($data as $product){
                    $parameters = array('id' => $product['product_id']);
                    $sql = "SELECT products.quantity FROM products WHERE products.id = :id";

                    $stmt = $connection->prepare($sql);
                    $stmt->execute($parameters);
                    $quantity = $stmt->fetchAll();

                    $parameters['quantity'] = ($quantity[0]['quantity'] - $data[0]['quantity']);
                    $sql = "UPDATE products SET quantity = :quantity WHERE id = :id";
                    $stmt = $connection->prepare($sql);
                    $stmt->execute($parameters);
                }
            }else{
                $lastId = null;
            }
        }else{
            $parameters = array("user_id" => $user_id, "paymentMethod" => $transactionType, "shipping_id"=>$shipping, "status" => "Processing", "products" => $productArray, "date" => date("Y-m-d"));

            $sql = "INSERT INTO transactions (customer, paymentMethod, shipping_id, status, products, date) VALUES(:user_id, :paymentMethod, :shipping_id, :status, :products, :date)";

            $stmt = $connection->prepare($sql);
            $stmt->execute($parameters);

            $lastId = $connection->lastInsertId();

            if($lastId > -1){
                $sql = "DELETE FROM cart WHERE user_id = :user_id";

                $parameters = array("user_id" => $user_id);

                $stmt = $connection->prepare($sql);
                $stmt->execute($parameters);

                foreach($data as $product){
                    $parameters = array('id' => $product['product_id']);
                    $sql = "SELECT products.quantity FROM products WHERE products.id = :id";

                    $stmt = $connection->prepare($sql);
                    $stmt->execute($parameters);
                    $quantity = $stmt->fetchAll();

                    $parameters['quantity'] = ($quantity[0]['quantity'] - $data[0]['quantity']);
                    $sql = "UPDATE products SET quantity = :quantity WHERE id = :id";
                    $stmt = $connection->prepare($sql);
                    $stmt->execute($parameters);
                }
            }else{
                $lastId = null;
            }
        }
        return $lastId;
    }

    function getShipping(){
        $sql = "SELECT * FROM shipping";

        $connection = new PDO('mysql:host='.$this->host.';dbname='.$this->database, $this->username, $this->password);

        $stmt = $connection->prepare($sql);
        $stmt->execute();

        $data = $stmt->fetchAll();

        return $data;
    }

    function getShippingCost($id){
        $parameters = array('id' => $id);
        $sql = "SELECT * FROM shipping WHERE id = :id";
        $connection = new PDO('mysql:host='.$this->host.';dbname='.$this->database, $this->username, $this->password);
        $stmt = $connection->prepare($sql);

        $stmt->execute($parameters);

        $data = $stmt->fetchAll()[0];

        return $data;
    }

    function getOrder($user_id, $order_id){
        $sql = "SELECT * FROM transactions WHERE id = :order_id AND customer = :user_id";

        $parameters = array('order_id' => $order_id, 'user_id' => $user_id);

        $connection = new PDO('mysql:host='.$this->host.';dbname='.$this->database, $this->username, $this->password);

        $stmt = $connection->prepare($sql);
        $stmt->execute($parameters);

        $data = $stmt->fetchAll();

        return $data;
    }

    function getOrders($user_id){
        $sql = "SELECT transactions.*, shipping.shipping_type FROM transactions INNER JOIN shipping ON shipping.id = transactions.shipping_id WHERE customer = :user_id";

        $parameters = array('user_id' => $user_id);

        $connection = new PDO('mysql:host='.$this->host.';dbname='.$this->database, $this->username, $this->password);

        $stmt = $connection->prepare($sql);
        $stmt->execute($parameters);

        $data = $stmt->fetchAll();

        return $data;
    }

    function getRecentOrders($user_id){
        $sql = "SELECT transactions.*, shipping.shipping_type FROM `transactions` INNER JOIN shipping ON shipping.id = shipping_id WHERE customer = :id ORDER BY date DESC LIMIT 3";

        $connection = new PDO('mysql:host='.$this->host.';dbname='.$this->database, $this->username, $this->password);
        $stmt = $connection->prepare($sql);
        $stmt->execute($user_id);

        return $stmt->fetchAll();
    }

    function getLatestOrder($user_id){
        $parameters = array("user_id" => $user_id);

        $sql = "SELECT * FROM `transactions` WHERE customer = :user_id ORDER BY id DESC LIMIT 1";

        $connection = new PDO('mysql:host='.$this->host.';dbname='.$this->database, $this->username, $this->password);

        $stmt = $connection->prepare($sql);
        $stmt->execute($parameters);

        $data = $stmt->fetchAll();

        return $data;

    }

    function updateTransactionStatus($id, $status){
        $sql = "UPDATE transactions SET status = :status WHERE id = :id";

        $parameters = array('id' => $id, 'status' => $status);

        $connection = new PDO('mysql:host='.$this->host.';dbname='.$this->database, $this->username, $this->password);

        $stmt = $connection->prepare($sql);
        $stmt->execute($parameters);

        if($stmt->rowCount() > 0){
            return true;
        }else{
            return false;
        }
    }

    function getTransactions($options, $limit){
        if(isset($_GET['page'])){
            if($_GET['page'] < 1){
                $_GET['page'] = 1;
            }
            $offset = $limit * ($_GET['page']-1);
        }else{
            $offset = 0;
        }
        $sql = "SELECT transactions.*, shipping.shipping_type, shipping.shipping_cost, users.email FROM transactions INNER JOIN shipping ON shipping_id = shipping.id INNER JOIN users ON customer = users.id LIMIT ". $limit ." OFFSET " . $offset;

        $parameters = array('limit' => $limit, 'offset' => $offset);

        $connection = new PDO('mysql:host='.$this->host.';dbname='.$this->database, $this->username, $this->password);

        $stmt = $connection->prepare($sql);
        $stmt->execute($parameters);

        return $stmt->fetchAll();
    }

    function getLastMonthTransaction(){
        $sql = "SELECT COUNT(id) AS transactions FROM transactions WHERE date >= DATE_ADD(NOW(),INTERVAL -1 MONTH)";

        $connection = new PDO('mysql:host='.$this->host.';dbname='.$this->database, $this->username, $this->password);

        $stmt = $connection->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    // End of front end //

    //Settings

    function logError($context, $error){
        $dir = $_SERVER['DOCUMENT_ROOT'] . "/E-commerce-CMS/configs/error.json";
        if(!file_exists($dir)){
            $_SERVER['DOCUMENT_ROOT'] . "/configs/error.json";
        }
        $errorFile = file_get_contents($dir);
        $tempList = json_decode($errorFile, true);
        $errorList = array();
        foreach($tempList as $value){
            array_push($errorList, $value);
        }

        array_push($errorList, array(date("d/m/Y"), $context, $error));
        $json = json_encode($errorList);
        file_put_contents($dir, $json);
    }

    function addToCart($user_id, $product_id, $quantity){
        $parameters = array('user_id' => $user_id, 'product_id' => $product_id);
        $sql = "SELECT * FROM cart WHERE user_id = :user_id AND product_id = :product_id";

        $connection = new PDO('mysql:host='.$this->host.';dbname='.$this->database, $this->username, $this->password);
        $stmt = $connection->prepare($sql);
        $stmt->execute($parameters);

        if($stmt->rowCount() > 0){
            $data = $stmt->fetchAll();
            $stock = $this->getProductQuantity($product_id)[0]['quantity'];
            $newQuantity = $data[0]['quantity'] + $quantity;
            if($stock >= $newQuantity){
                $cartId = $data[0]['id'];
                $quantity = $data[0]['quantity'] + $quantity;

                $parameters = array('id' => $cartId, 'quantity' => $quantity);

                $sql = "UPDATE cart SET quantity = :quantity WHERE id = :id";

                $connection = new PDO('mysql:host='.$this->host.';dbname='.$this->database, $this->username, $this->password);
                $stmt = $connection->prepare($sql);
                $stmt->execute($parameters);

                if($stmt->rowCount() > 0){
                    echo "true";
                }else{
                    echo "error";
                }
            }else{
                echo "not-enough-stock";
            }
        }else{
            $parameters = array('product_id' => $product_id, 'user_id' => $user_id, 'quantity' => $quantity);
            $sql = "INSERT INTO cart(product_id, user_id, quantity) VALUES(:product_id, :user_id, :quantity)";

            $connection = new PDO('mysql:host='.$this->host.';dbname='.$this->database, $this->username, $this->password);
            $stmt = $connection->prepare($sql);
            $stmt->execute($parameters);

            if($stmt->rowCount() > 0){
                echo "true";
            }else{
                echo "error";
            }
        }
    }

    // End of settings //

    //Misc
    function getSections(){
        $data = null;
        $sql = "SELECT * FROM sections";

        $connection = new PDO('mysql:host='.$this->host.';dbname='.$this->database, $this->username, $this->password);
        $stmt = $connection->prepare($sql);
        $stmt->execute();
        $data = $stmt->fetchAll();

        return $data;
    }

    function generateVariable($options, $table){
        $returnArray = array();
        $optionArray = array();
        $optionTagList = "";
        $optionList = "";
        // Product variables //
        if(isset($options['min']) && isset($options['max'])){
            $optionList .= " products.cost BETWEEN :min AND :max AND ";
            $optionTagList .= " products.cost BETWEEN :min AND :max AND ";
            $optionArray['min'] = $options['min'];
            $optionArray['max'] = $options['max'];
            unset($options['min']);
            unset($options['max']);
        }else if(isset($options['min'])){
            $optionList .= " products.cost > :min AND ";
            $optionTagList .= " products.cost > :min AND ";
            $optionArray['min'] = $options['min'];
            unset($options['min']);
        }else if(isset($options['max'])){
            $optionList .= " products.cost < :max AND ";
            $optionArray['max'] = $options['max'];
            unset($options['max']);
        }
        if(isset($options['qmin']) && isset($options['qmax'])){
            $optionList .= " products.quantity BETWEEN :qmin AND :qmax AND ";
            $optionArray['qmin'] = $options['qmin'];
            $optionArray['qmax'] = $options['qmax'];
            unset($options['qmin']);
            unset($options['qmax']);
        }else if(isset($options['qmin'])){
            $optionList .= " products.quantity >= :qmin AND ";
            $optionArray['qmin'] = $options['qmin'];
            unset($options['qmin']);
        }else if(isset($options['qmax'])){
            $optionList .= " products.quantity =< :qmax AND ";
            $optionArray['qmax'] = $options['qmax'];
            unset($options['qmax']);
        }
        if(isset($options["section_name"]) && $options["section_name"] != "All"){
            $optionList .= " sections.name LIKE :section_name AND ";
            $optionArray['section_name'] = $options['section_name'];
            unset($options['section_name']);
        }else{
            unset($options['section_name']);
        }
        //End of product variables //

        // User variables //

        // End of user variables //
        foreach($options as $option => $value){
            $optionList .= $table . "." . $option . " LIKE :". $option ." AND ";
            $optionArray[$option] = '%'. $value . '%';
        }

        array_push($returnArray, $optionArray, $optionList, $optionTagList);
        return $returnArray;
    }
    // End of Misc //
}

?>