<?php
include_once 'queries.php';
function combobox_articulos() {
    echo '<select class="selector" name="articulo" form="lineacomanda">';
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
        echo '<table style="clear:both">';
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
        echo '<input class="boton_fin" type="submit" value="Servir y/o eliminar"/>';
        echo '</form>';


    }
}

function cerrar_cobrar_comanda($id_mesa) {
    $res = select_lineascomanda_servidas($id_mesa);
    if($res){
        $res->setFetchMode(PDO::FETCH_NAMED);
        echo '<table style="clear:both">';
        echo '<form method="post" action="algo.php">';
        echo '<tr>';
        echo '<th>Producto</th>';
        echo '<th>PVP</th>';
        echo '</tr>';
        $total = 0;

        foreach($res as $row){
            $total += $row[pvp];
            $enlace = <<<FIN_HTML
            <tr>
        <td>$row[nombre]</td>
        <td>$row[pvp]</td>
        </tr>
FIN_HTML;
            echo $enlace;

        }
        $enlace = <<<FIN_HTML
        <tr>
        <td>TOTAL</td>
        <td>$total</td>
        </tr>
FIN_HTML;
        echo $enlace;
        echo '</table>';
        echo '<input class="boton_cerrar" type="submit" value="Cerrar y cobrar"/>';
        echo '</form>';


    }
}
