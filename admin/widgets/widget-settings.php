<div class="cell large-12 grid-container full sortable-area show-for-large">
    <div class="grid-x">
        <div class="cell large-12 bd content">
            <h2>Widget order</h2>
        </div>
    </div>
    <div class="grid-x bd content">
        <ul id="enabled-widgets-list" class="sortable cell large-8 bd">
            <?php
            $json = file_get_contents("../configs/front-page.json");

            $frontPageConfigs = json_decode($json, true);
            for($i = 0; $i < sizeof($frontPageConfigs[0]['enabled-widgets'], 0); $i++){
                $row = $frontPageConfigs[0]['enabled-widgets'][$i];
                if(isset($row['url']) && $row['type'] === "widget"){
                    echo '
                            <div class="sortable-item" data-id='.$i.'><div class="grid-container full"><div class="grid-x"><div class="cell small-3"><div class="item-circle"><p>'. (1+$i) .'</p></div></div><div class="cell small-5"><li  data-value="'. $row['url'] .'" data-type="'. $row['type'] .'"><p class="sortable-item-text">' . $row['url'] . '</p></li></div><div class="cell small-3">'. $row['type'] .'</div><div class="cell small-1"><button class="button alert" onclick="deleteWidget($(this), '. $i .')"><i class="fas fa-trash-alt"></i></button></div></div></div></div>
                            ';
                }else{
                    echo '
                            <div class="sortable-item" data-id='.$i.'><div class="grid-container full"><div class="grid-x"><div class="cell small-3"><div class="item-circle"><p>'. (1+$i) .'</p></div></div><div class="cell small-5"><li  data-value="'. $i .'" data-type="'. $row['type'] .'"><p class="sortable-item-text">' . substr($row['options']['text'], 0, 50) . "..." . '</p></li></div><div class="cell small-3">'. $row['type'] .'</div><div class="cell small-1"><button class="button alert" onclick="deleteCustomArea($(this), '. $i .')"><i class="fas fa-trash-alt"></i></button></div></div></div></div>
                            ';
                }
            }
            ?>
        </ul>
        <div class="sortable cell large-4 bd">
            <div class="grid-x">
                <button class="button primary cell" data-open="widget-list-modal"><p><i class="fas fa-plus"></i> Add widget</p></button>
                <button class="button primary cell" data-open="add-text-modal"><p><i class="fas fa-plus"></i> Add text area</p></button>
            </div>
        </div>
        <button id="list-submit" class="button primary cell small-2" style="margin-top:5px;" onclick="saveSortOrder(); return false;">Save</button>
    </div>
</div>


<div class="callout small warning show-for-small hide-for-large">
    <i class="fas fa-exclamation-circle"></i> <span>Layout management disabled for small screens, please use on a desktop to use this feature.</span>
</div>


<div class="reveal" id="widget-list-modal" data-reveal>
    <h1>Available widgets</h1>
    <div class="grid-x">
        <div class="cell">
            <table class="unstriped">
                <thead>
                    <th>Widget</th>
                    <th>Add</th>
                </thead>
                <tbody>
                    <?php
                    $array = array_slice(scandir("../widgets/front-page/"), 2);
                    $result = array_values($array);
                    for($i = 0; $i < sizeof($result); $i++){
                        echo "<tr><td>". $result[$i] ."</td><td><button class='button primary' value='". $result[$i] ."' onclick='createListItem(". '"' . $result[$i] . '"' .")'><i class='fas fa-plus'></i></button></td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <blockquote>
        Click on add to add the widget to the list in the previous screen.
    </blockquote>
    <button class="close-button" data-close aria-label="Close modal" type="button">
        <span aria-hidden="true">&times;</span>
    </button>
</div>


<div class="reveal" id="add-text-modal" data-reveal>
    <h1>Available widgets</h1>
    <div class="grid-x bottom-spacing">
        <div class="cell small-12">
            <form id="add-text-form" class="ui form">
                <div class="fields">
                    <div class="field">
                        <label>Size</label>
                        <div class="ui selection dropdown">
                            <input type="hidden" name="headerSize">
                            <i class="dropdown icon"></i>
                            <div class="default text">Small</div>
                            <div class="menu" name="textSize">
                                <div class="item" data-value="h3">Small</div>
                                <div class="item" data-value="h2">Medium</div>
                                <div class="item" data-value="h1">Large</div>
                            </div>
                        </div>
                    </div>
                    <div class="field">
                        <label>Header text</label>
                        <input name="headerText" type="text" placeholder="Header text">
                    </div>
                </div>

                <div class="field">
                    <label>Main text</label>
                    <textarea name="mainText" placeholder="Enter text here to be entered into the webpage"></textarea>
                </div>
            </form>

        </div>
    </div>
    <div class="grid-x">
        <div class="cell small-6">
            <button class="button primary" onclick="addTextArea(); return false;">Add text</button>
        </div>
    </div>
    <button class="close-button" data-close aria-label="Close modal" type="button">
        <span aria-hidden="true">&times;</span>
    </button>
</div>