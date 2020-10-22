<?php
if(!isset($_COOKIE['accept-cookies']) && !isset($_SESSION['accept-cookies'])){
    echo '
<div class="cookie_request" id="cookie_request">
    <div class="grid-container">
        <div class="grid-x grid-margin-x">
            <div class="cell large-12">
                <b>This website uses cookies.</b><br>
                <p>This website uses cookies to improve user experience. By using our website you consent to all cookies in accordance with our Cookie Policy.  <br><a href="privacy-policy.php">Read policy</a></p>
            </div>
            <div class="cell large-6 large-offset-3">
                <button class="button primary" onclick="acceptCookieClick(); return false;">Accept</button>
                <button class="button alert" onclick="denyCookieClick(); return false;">Deny</button>
            </div>
        </div>
    </div>
</div>
';
}
?>