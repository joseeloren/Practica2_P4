<?php
include_once 'queries.php';
function combobox_articulos() {
    echo '<select id="login" style="float:left;margin:0;margin-top:25px;display:inline-block;" name="articulo" form="lineacomanda">';
    $res = select_articulos();
    if ($res) {
        $res->setFetchMode(PDO::FETCH_NAMED);
        foreach($res as $row)
            echo "<option value=\"$row[id]\">$row[nombre]</option>";
    }
      echo '</select>';
}

function borrar_servir_comanda($id_mesa) {
    $res = select_lineascomanda($id_mesa);
    if($res){
        $res->setFetchMode(PDO::FETCH_NAMED);
        echo '<table>';
        echo '<form method="post" action="algo.php">';
        echo '<tr>';
        echo '<th>Producto</th>';
        echo '<th>Servir</th>';
        echo '<th>Eliminar</th>';
        echo '</tr>';


        foreach($res as $row){
            $enlace = <<<FIN_HTML
            <tr>
        <td>$row[nombre]</td>
        <td><input type="radio" name="$row[id]_opcion" value="$row[id]_servir"/></td>
        <td><input type="radio" name="$row[id]_opcion" value="$row[id]_eliminar"/></td>
        </tr>
FIN_HTML;
            echo $enlace;

        }
        echo '</table>';
        echo '<input id="enviar_form" type="submit" value="Finalizar"/>';
        echo '</form>';


    }
}
