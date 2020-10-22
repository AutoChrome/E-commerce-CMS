<?php
function drawCustomArea($size, $headerSize, $headerText, $text, $alignment){
    switch($size){
        case "small":
            $size = 4;
            break;
        case "medium":
            $size = 8;
            break;
        case "large":
            $size = 12;
            break;
    }
    switch($headerSize){
        case "small":
            $headerSize = "h3";
            break;
        case "medium":
            $headerSize = "h2";
            break;

        case "large":
            $headerSize = "h1";
            break;

    }
    echo'
    <div class="grid-container">
        <div class="grid-x grid-margin-x">
            <div class="cell small-'.$size.' small-offset-'.((12-$size)/2).'">
                <'.$headerSize.' class="text-'. $alignment .'">'.$headerText.'</'.$headerSize.'>
                <p class="text-'. $alignment .'">'.$text.'</p>
            </div>
        </div>
    </div>
    ';
}
?>