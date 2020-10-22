<html class="no-js">
    <head>
        <?php
        $dir = $_SERVER['DOCUMENT_ROOT'] . "/E-commerce-CMS/configs/database.json";
        $json = file_get_contents($dir);

        $config = json_decode($json, true);

        echo '
                <title>Account created - '. $config['site_name'] .'</title>
        ';
        ?>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/foundation.css">
        <link rel='stylesheet' type='text/css' href='css/main.php' />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/motion-ui@1.2.3/dist/motion-ui.min.css" />
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous"/>
        <link rel="stylesheet" href="css/toastr.min.css"/>
        <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
        <script src="js/jquery-ui-1.12.1.custom/jquery-ui.js"></script>
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
                <div class="grid-container">
                    <div class="grid-x content-border">
                        <h1>Account created successfully!</h1>
                        <p>Your account has been created, please go to the login page and login with the credentials provided.</p>
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
        <script src="js/toastr/toastr.min.js"></script>
        <script src="js/custom-scripts/cookie.js"></script>
    </body>
</html>