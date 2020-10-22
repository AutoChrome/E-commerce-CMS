<?php
$dir = $_SERVER['DOCUMENT_ROOT'] . "/configs/database.json";
if(!file_exists($dir)){
    $dir = $_SERVER['DOCUMENT_ROOT'] . "E-commerce-CMS/configs/database.json";
}
$json = file_get_contents($dir);
$config = json_decode($json, true);
?>
<h1>Configuration settings</h1>
<form onsubmit="updateIni($(this)); return false;" method="POST">
    <div class="grid-container full">
        <div class="grid-container full">
            <div class="grid-x">
                <div class="cell large-12">
                    <label>
                        Host
                        <input name="host" type="text" value='<?php if(isset($config['host'])){echo $config['host'];}?>'>
                    </label>
                </div>
            </div>
            <div class="grid-x">
                <div class="cell large-12">
                    <label>
                        Database port
                        <input name="port" type="text" value='<?php if(isset($config['port'])){echo $config['port'];}?>'>
                    </label>
                </div>
            </div>
            <div class="grid-x">
                <div class="cell large-12">
                    <label>
                        Database username
                        <input name="username" type="text" value='<?php if(isset($config['username'])){echo $config['username'];}?>'>
                    </label>
                </div>
            </div>
            <div class="grid-x">
                <div class="cell large-12">
                    <label>
                        Database Password
                        <input name="password" type="password" value='<?php if(isset($config['password'])){echo $config['password'];}?>'>
                    </label>
                </div>
            </div>
            <div class="grid-x">
                <div class="cell large-12">
                    <label>
                        Database name
                        <input name="database" type="text" value='<?php if(isset($config['database'])){echo $config['database'];}?>'>
                    </label>
                </div>
            </div>
            <div class="grid-x">
                <div class="cell large-12">
                    <label>
                        Website name
                        <input name="site_name" type="text" value='<?php if(isset($config['site_name'])){echo $config['site_name'];}?>'>
                    </label>
                </div>
            </div>
            <hr>
            <div class="grid-x">
                <div class="cell large-12">
                    <button class="button primary cell" type="submit">Submit</button>
                </div>
            </div>
        </div>
    </div>
</form>