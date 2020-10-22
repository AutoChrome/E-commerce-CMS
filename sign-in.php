<html class="no-js">
    <head>
        <?php
        $dir = $_SERVER['DOCUMENT_ROOT'] . "/E-commerce-CMS/configs/database.json";
        $json = file_get_contents($dir);

        $config = json_decode($json, true);

        echo '
                <title>Login/Register - '. $config['site_name'] .'</title>
        ';
        ?>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/foundation.css">
        <link rel='stylesheet' type='text/css' href='css/main.php' />
        <link rel='stylesheet' type='text/css' href='css/sign-in.css' />
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
                    <div class="grid-x grid-margin-x sign-in-middle-align">
                        <div class="cell large-8 large-offset-2">
                            <form id="log-in-form" class="log-in-form" style="padding:2rem;" novalidate data-abide>
                                <h4 class="text-center">Log in with you email account</h4>
                                <label>Email
                                    <input type="email"  name="email" placeholder="somebody@example.com" pattern="email" required>
                                </label>
                                <label>Password
                                    <input type="password" name="password" placeholder="Password" required pattern="password">
                                </label>
                                <?php
                                
                                ?>
                                <p><input type="checkbox" name="rememberme"> Remember me</p>
                                <p><input type="submit" class="button primary expanded" onclick="logIn(); return false;" value="Log in"></p>
                                <p class="text-center"><a href="#">Forgot your password?</a></p>
                                <p class="text-center"><a href="#" onclick="showSignUp(); return false;">Don't have an account? Sign up!</a></p>
                            </form>
                        </div>
                        <div class="cell large-12">
                            <form id="sign-in-form" class="sign-in-form" style="padding:2rem;" data-abide novalidate hidden>
                                <h4 class="text-center">Create your account</h4>
                                <div class="grid-x grid-margin-x">
                                    <div class="cell large-4">
                                        <label>First name *
                                            <input name="first_name" type="text" placeholder="First name" required>
                                        </label>
                                    </div>
                                    <div class="cell large-4">
                                        <label>Last name *
                                            <input name="last_name" type="text" placeholder="Last name" required>
                                        </label>
                                    </div>
                                    <div class="cell large-4">
                                        <label>Other name
                                            <input name="other_name" type="text" placeholder="Other name">
                                        </label>
                                    </div>
                                    <div class="large-12 cell">
                                        <label>Email *
                                            <div class="input-group">
                                                <span class="input-group-label">
                                                    <i class="fa fa-envelope"></i>
                                                </span>
                                                <input name="email" id="email" class="input-group-field" type="text" placeholder="someexample@example.com" pattern="email" required>
                                            </div>
                                        </label>
                                    </div>
                                    <div class="large-12 cell">
                                        <div class="grid-x">
                                            <div class="medium-6 cell" style="padding-left: 1rem;">
                                                <div class="callout success" id="email-available" hidden>
                                                    Email available!
                                                </div>
                                                <div class="callout alert" id="email-taken" hidden>
                                                    Email already taken or incorrect format entered.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="medium-6 cell">
                                        <label>Password
                                            <div class="input-group">
                                                <span class="input-group-label">
                                                    <i class="fa fa-key"></i>
                                                </span>
                                                <input name="password" class="input-group-field" type="password" placeholder="Password" required pattern="password">
                                            </div>
                                        </label>
                                    </div>
                                    <div class="medium-6 cell">
                                        <label>Confirm password
                                            <div class="input-group">
                                                <span class="input-group-label">
                                                    <i class="fa fa-key"></i>
                                                </span>
                                                <input id="confirm-password" class="input-group-field" type="password" placeholder="Password" required pattern="alpha_numeric">
                                            </div>
                                        </label>
                                    </div>
                                    <div class="medium-12 cell">
                                        <div class="grid-x grid-margin-x">
                                            <div class="medium-6 cell">
                                                <div class="callout alert" id="invalid-password" hidden>
                                                    Invalid passwords, possible reasons:
                                                    <ul>
                                                        <li>Not long enough, must be 6 characters or longer</li>
                                                        <li>Password does not match confirmation password</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="cell large-4">
                                        <label>Address line *
                                            <input name="address" type="text" placeholder="9 example road" required>
                                        </label>
                                    </div>
                                    <div class="cell large-4">
                                        <label>Postcode *
                                            <input name="postcode" id="signup-postcode" type="text" placeholder="ED4 2PD" pattern="postcode" aria-errormessage="postcode-error" required>
                                        </label>
                                        <blockquote hidden id="postcode-error" class="form-error" data-form-error-for="signup-postcode">
                                            Accepted formats:
                                            <ul>
                                                <li>EX2 3FM</li>
                                                <li>EX23FM</li>
                                                <li>ex2 3fm</li>
                                                <li>ex23fm</li>
                                            </ul>
                                        </blockquote>
                                    </div>
                                    <div class="cell large-4">
                                        <label>Town/City *
                                            <input name="town" type="text" placeholder="London">
                                        </label>
                                    </div>
                                    <div class="cell large-6">
                                        <label>Telephone *
                                            <input name="telephone" type="text" placeholder="07493826473" pattern="telephone" required>
                                        </label>
                                    </div>
                                    <div class="cell large-6">
                                        <label>Date of birth *
                                            <div class="grid-x grid-margin-x">
                                                <div class="cell large-4">
                                                    <select name="dob_day">
                                                        <?php
                                                        for($i = 1; $i <= 31; $i++){
                                                            if($i < 10){
                                                                echo "<option value='{$i}'>0{$i}</option>";
                                                            }else{
                                                                echo "<option value='{$i}'>{$i}</option>";   
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="cell large-4">
                                                    <select name="dob_month">
                                                        <option>MM</option>
                                                        <option value="01">January</option>
                                                        <option value="02">February</option>
                                                        <option value="03">March</option>
                                                        <option value="04">April</option>
                                                        <option value="05">May</option>
                                                        <option value="06">June</option>
                                                        <option value="07">July</option>
                                                        <option value="08">August</option>
                                                        <option value="09">September</option>
                                                        <option value="10">October</option>
                                                        <option value="11">November</option>
                                                        <option value="12">December</option>
                                                    </select>
                                                </div>
                                                <div class="cell large-4">
                                                    <input name="dob_year" type="number" placeholder="YYYY" required>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                                <p><input type="submit" class="button primary expanded" value="Sign up" onclick="createUser(); return false;"></p>
                                <p class="text-center"><a href="#" onclick="showLogIn(); return false;">Have an account? Log in!</a></p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="grid-container full footer">
                <?php include_once("widgets/footer.php"); ?>
            </div>
        </div>
        <script>
            Foundation.Abide.defaults.patterns['postcode'] = /([Gg][Ii][Rr] 0[Aa]{2})|((([A-Za-z][0-9]{1,2})|(([A-Za-z][A-Ha-hJ-Yj-y][0-9]{1,2})|(([A-Za-z][0-9][A-Za-z])|([A-Za-z][A-Ha-hJ-Yj-y][0-9][A-Za-z]?))))\s?[0-9][A-Za-z]{2})/;
            Foundation.Abide.defaults.patterns['telephone'] = /^((\(?0\d{4}\)?\s?\d{3}\s?\d{3})|(\(?0\d{3}\)?\s?\d{3}\s?\d{4})|(\(?0\d{2}\)?\s?\d{4}\s?\d{4}))(\s?\#(\d{4}|\d{3}))?$/;
            Foundation.Abide.defaults.patterns['password'] = /^[a-zA-Z0-9!-£]{6,}$/;
            $(document).foundation();
        </script>
        <script src="js/custom-scripts/sign-in.js"></script>
        <script src="js/custom-scripts/searchbar.js"></script>
        <script src="js/toastr/toastr.min.js"></script>
    </body>
</html>