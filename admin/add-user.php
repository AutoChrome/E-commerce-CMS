<?php
$json = file_get_contents("../configs/config.json");

$configs = json_decode($json, true);
include("../objects/DatabaseHandler.php");
include("../objects/product.php");

$databaseHandler = new DatabaseHandler();
?>


<html class="no-js">
    <head>
        <title>Admin - Add user</title>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../css/foundation.css">
        <link rel='stylesheet' type='text/css' href='../css/main.php' />
        <link rel='stylesheet' type='text/css' href='css/admin.php' />
        <link rel='stylesheet' type='text/css' href='css/widget/user-manager.css'/>
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
                    <div class="cell medium-10 medium-cell-block-y content-holder">
                        <div class="content-padding">
                            <form id="user-form" class="bd" data-abide novalidate>
                                <div class="grid-container fluid">
                                    <h1>User details</h1>
                                    <div class="grid-x grid-padding-x">
                                        <div class="medium-1 cell">
                                            <label>ID
                                                <input id="id" type="text" value="Auto" disabled>
                                            </label>
                                        </div>
                                        <div class="medium-4 cell">
                                            <label>First Name
                                                <input id="first_name" type="text" placeholder="Rob" required>
                                            </label>
                                        </div>
                                        <div class="medium-4 cell">
                                            <label>Middle name
                                                <input id="other_name" type="text" placeholder="Jack">
                                            </label>
                                        </div>
                                        <div class="medium-3 cell">
                                            <label>Last name
                                                <input id="last_name" type="text" placeholder="Backburry" required>
                                            </label>
                                        </div>
                                        <div class="medium-6 cell">
                                            <label>Telephone
                                                <input id="telephone" type="text" placeholder="07472617394" pattern="telephone" required>
                                            </label>
                                        </div>
                                        <div class="medium-6 cell">
                                            <label>Date of birth
                                                <input id="dob" type="text" placeholder="02/02/1995" pattern="day_month_year" required>
                                            </label>
                                            <blockquote id="dob-error-message">Accepted formats:
                                                <ul>
                                                    <li>13/01/1990</li>
                                                </ul>
                                                Must be older than 18 years old.
                                            </blockquote>
                                        </div>
                                        <div class="medium-12 cell">
                                            <div class="grid-x grid-margin-xx">
                                                <div class="medium-6 medium-offset-6 cell" style="padding-left: 1rem;">
                                                    <div class="callout alert" id="age-young" hidden>
                                                        Error! User not old enough.
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="grid-x grid-padding-x">
                                        <div class="medium-6 cell">
                                            <label>Email
                                                <div class="input-group">
                                                    <span class="input-group-label">
                                                        <i class="fa fa-envelope"></i>
                                                    </span>
                                                    <input id="email" class="input-group-field" type="text" placeholder="someexample@example.com" pattern="email" required>
                                                    <div class="input-group-button">
                                                        <input type="button" class="button success" value="Check availability" onclick="validateEmail($('#email')); return false;">
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                        <div class="medium-12 cell">
                                            <div class="grid-x">
                                                <div class="medium-6 cell" style="padding-left: 1rem;">
                                                    <div class="callout success" id="email-available" hidden>
                                                        Email available!
                                                    </div>
                                                    <div class="callout alert" id="email-taken" hidden>
                                                        Email already taken.
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
                                                    <input id="password" class="input-group-field" type="password" placeholder="Password">
                                                    <span class="input-group-label show-password" id="show-password">
                                                        <i class="fa fa-eye-slash"></i>
                                                    </span>
                                                </div>
                                            </label>
                                        </div>
                                        <div class="medium-6 cell">
                                            <label>Confirm password
                                                <div class="input-group">
                                                    <span class="input-group-label">
                                                        <i class="fa fa-key"></i>
                                                    </span>
                                                    <input id="confirm-password" class="input-group-field" type="password" placeholder="Password">
                                                    <span class="input-group-label show-password" id="show-confirm-password">
                                                        <i class="fa fa-eye-slash"></i>
                                                    </span>
                                                </div>
                                            </label>
                                        </div>
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
                                    <hr>
                                    <div class="grid-x grid-padding-x">
                                        <div class="medium-6 cell">
                                            <label>Address
                                                <div class="input-group">
                                                    <span class="input-group-label">
                                                        <i class="fa fa-city"></i>
                                                    </span>
                                                    <input id="address" class="input-group-field" type="text" placeholder="9 Example road" required>
                                                </div>
                                            </label>
                                        </div>
                                        <div class="medium-6 cell">
                                            <label>Town/City
                                                <div class="input-group">
                                                    <span class="input-group-label">
                                                        <i class="fa fa-city"></i>
                                                    </span>
                                                    <input id="town" class="input-group-field" type="text" placeholder="Birmingham" required>
                                                </div>
                                            </label>
                                        </div>
                                        <div class="medium-6 cell">
                                            <label>Postcode
                                                <div class="input-group">
                                                    <span class="input-group-label">
                                                        <i class="fa fa-city"></i>
                                                    </span>
                                                    <input id="postcode" class="input-group-field" type="text" placeholder="EX2 9FL" pattern="postcode" required>
                                                </div>
                                                <blockquote>
                                                    Accepted formats:
                                                    <ul>
                                                        <li>EX2 3FM</li>
                                                        <li>EX23FM</li>
                                                        <li>ex2 3fm</li>
                                                        <li>ex23fm</li>
                                                    </ul>
                                                </blockquote>
                                            </label>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="grid-x grid-padding-x">
                                        <div class="medium-3 cell">
                                            <label>Privileges
                                                <select id="privileges">
                                                    <option value="0">User</option>
                                                    <option value="1">Admin</option>
                                                </select>
                                            </label>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="grid-x">
                                        <div class="cell medium-12">
                                            <div data-abide-error class="alert callout" style="display: none;">
                                                <p><i class="fi-alert"></i> There are some errors in your form.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grid-x grid-padding-x">
                                        <div class="medium-2 medium-offset-10 cell">
                                            <button class="button success" onclick="createUser(); return false;">Create</button>
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
        <script src="scripts/custom-scripts/add-user.js"></script>
        <script>
            Foundation.Abide.defaults.patterns['postcode'] = /([Gg][Ii][Rr] 0[Aa]{2})|((([A-Za-z][0-9]{1,2})|(([A-Za-z][A-Ha-hJ-Yj-y][0-9]{1,2})|(([A-Za-z][0-9][A-Za-z])|([A-Za-z][A-Ha-hJ-Yj-y][0-9][A-Za-z]?))))\s?[0-9][A-Za-z]{2})/;
            Foundation.Abide.defaults.patterns['telephone'] = /^((\(?0\d{4}\)?\s?\d{3}\s?\d{3})|(\(?0\d{3}\)?\s?\d{3}\s?\d{4})|(\(?0\d{2}\)?\s?\d{4}\s?\d{4}))(\s?\#(\d{4}|\d{3}))?$/;
            Foundation.Abide.defaults.patterns['password'] = /^(?=.*[a-z])(?=.*[A-Z])(?=.{6,})/;
            $(document).foundation();
        </script>
        <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
        <script src="../js/jquery-ui-1.12.1.custom/jquery-ui.js"></script>
        <script src="https://dhbhdrzi4tiry.cloudfront.net/cdn/sites/foundation.js"></script>
        <script src="../js/toastr/toastr.min.js"></script>
        <script src="../css/Semantic-UI-CSS-master/semantic.min.js"></script>
    </body>
</html>