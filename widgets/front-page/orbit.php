<?php
echo '

';
?>

<div class="orbit" role="region" aria-label="Favorite Space Pictures" data-orbit>
    <ul class="orbit-container">
        <button class="orbit-previous" aria-label="previous"><span class="show-for-sr">Previous Slide</span>&#9664;</button>
        <button class="orbit-next" aria-label="next"><span class="show-for-sr">Next Slide</span>&#9654;</button>
        <?php
        $images = glob("img/orbit/*");
        $is_active = 0;
        foreach($images as $image){
            if($is_active == 0){
                echo '<li class="orbit-slide is-active"><img src="'. $image .'" style="width:50%;height:560px;margin-left:23%;"></li>';
                $is_active = 1;
            }else{
                echo '<li class="orbit-slide"><img src="'. $image .'" style="width:50%;height:560px;margin-left:23%;"></li>';
            }
        }
        ?>
    </ul>
</div>