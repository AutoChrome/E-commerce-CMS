<?php
$dir = $_SERVER['DOCUMENT_ROOT'] . "/E-commerce-CMS/configs/config.json";
if(!file_exists($dir)){
    $dir = $_SERVER['DOCUMENT_ROOT'] . "/configs/config.json";
}
$json = file_get_contents($dir);

$config = json_decode($json, true);
?>

<div class="cell large-12 bd content">
    <h1>Stripe manager</h1>
    <div class="grid-x grid-margin-x">
        <div class="cell large-6">
            <label>
                Stripe publishable key
                <input type="text" name="stripe-publishable-key" value="<?php echo $config[1]['stripe-publishable'] ?>">
            </label>
        </div>
        <div class="cell large-6">
            <label>
                Stripe secret key
                <input type="text" name="stripe-secret-key" value="<?php echo $config[1]['stripe-secret'] ?>">
            </label>
        </div>
        <div class="cell large-3">
            <button class="button primary" onclick="submitStripeDetails(); return false;">Save</button>
        </div>
    </div>
</div>