<?php
include_once 'queries.php';
function combobox_articulos() {
    echo '<select id="login" style="float:left;margin:0;margin-top:25px" name="articulo" form="lineacomanda">';
    $res = select_articulos();
    if ($res) {
        $res->setFetchMode(PDO::FETCH_NAMED);
        foreach($res as $row)
            echo "<option value=\"$row[id]\">$row[nombre]</option>";
    }
      echo '</select>';
}
