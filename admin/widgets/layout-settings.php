<?php
$dir = $_SERVER['DOCUMENT_ROOT'] . "/E-commerce-CMS/configs/config.json";
if(!file_exists($dir)){
    $dir = $_SERVER['DOCUMENT_ROOT'] . "/configs/config.json";
}
$json = file_get_contents($dir);

$config = json_decode($json, true);
?>

<div class="cell large-12 bd content">
    <h1>Layout manager</h1>
    <ul class="tabs" data-tabs id="example-tabs">
        <li class="tabs-title is-active size-reset"><a href="#general-panel" aria-selected="true">General panel</a></li>
    </ul>
    <div class="tabs-content" data-tabs-content="example-tabs">
        <div class="tabs-panel is-active" id="general-panel">
            <form>
                <div class="grid-container full">
                    <div class="grid-x grid-margin-x">
                        <div class="cell large-6">
                            <label>Primary colour
                                <input id="primary-colour" name="primary-colour" type="text" placeholder="#fff" value="<?php echo $config[0]['primary-colour'];?>">
                            </label>
                        </div>
                        <div class="cell large-6">
                            <label>Secondary colour
                                <input id="secondary-colour" name="secondary-colour" type="text" placeholder="#fff" value="<?php echo $config[0]['secondary-colour'];?>">
                            </label>
                        </div>
                        <div class="cell large-6">
                            <label>Button colour
                                <input id="button-colour" name="button-colour" type="text" placeholder="#fff" value="<?php echo $config[0]['button-colour'];?>">
                            </label>
                        </div>
                        <div class="cell large-6">
                            <label>Button hover colour
                                <input id="button-colour-hover" name="button-hover-colour" type="text" placeholder="#fff" value="<?php echo $config[0]['button-colour-hover'];?>">
                            </label>
                        </div>
                        <div class="cell large-3">
                            <button class="button primary" onclick="saveLayout(); return false;">Save</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>