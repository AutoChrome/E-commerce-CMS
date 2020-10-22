<?php
$errorFile = file_get_contents("../configs/error.json");
$tempList = json_decode($errorFile, true);
$errorList = array();
foreach($tempList as $value){
    array_push($errorList, $value);
}
?>

<h1>Error Logs</h1>
<div class="error-area">
    <table>
        <thead>
            <tr>
                <td>Error date</td>
                <td>Error located</td>
                <td>Error message</td>
            </tr>
        </thead>
        <tbody>
            <?php
                foreach($errorList as $error){
                    echo "<tr>";
                    echo "<td>". $error[0] ."</td>";
                    echo "<td>". $error[1] ."</td>";
                    echo "<td>". $error[2] ."</td>";
                    echo "</tr>";
                }
            ?>
        </tbody>
    </table>
</div>