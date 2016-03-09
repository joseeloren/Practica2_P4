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

function borrar_servir_comanda($id_mesa) {

    echo '<table><tr>';
    $res = select_lineascomanda($id_mesa);
    if($res){
        $res->setFetchMode(PDO::FETCH_NAMED);
        echo "<tr>\n";
        echo "<th>Mesa</th>";
        echo "<th>Ocupacion</th>";
        echo "</tr>";

        foreach($res as $row){

            echo "<tr>\n";
            $enlace = <<<FIN_HTML
            <td>
                <a style="font-size:15px" href="">
                    $row[nombre]</a>
            </td>
FIN_HTML;
            echo $enlace;
            echo "\t<td>$row[Ocupacion]</td>\n";
            echo "</tr>\n";
        }

    }
    echo '</table>';
}
