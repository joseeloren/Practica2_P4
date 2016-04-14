<?php
include_once 'queries.php';
prepare_database();
function combobox_articulos($id_comanda) {
    echo '<p class="clear_both" >Seleccione un artículo pedido por el cliente:<p>';
    echo '<select class="selector" name="id_articulo" id_camarero="'.$_SESSION['id_usuario'].'" id_comanda="'.$id_comanda.'">';
    $res = select_articulos();
    if ($res) {
        $res->setFetchMode(PDO::FETCH_NAMED);
        foreach($res as $row)
            echo "<option value=\"$row[id_articulo]\">$row[nombre]</option>";
    }
      echo '</select>';
}

function borrar_servir_comanda($id_comanda) {
    echo '<p>Aquí podrá servir un producto ya preparado o que no requiera preparación o eliminarlo, si el cliente ya no lo quiere:</p>';
    $res = select_lineascomanda($id_comanda);
    if($res){
        $res->setFetchMode(PDO::FETCH_NAMED);

        echo '<table id="borrar_servir" class="clear_both">';
        echo '<tr>';
        echo '<th>Producto</th>';
        echo '<th>Servir</th>';
        echo '<th>Eliminar</th>';
        echo '</tr>';


        $contador = 0;

        foreach($res as $row){
            $enlace = <<<FIN_HTML
            <tr id ="listoParaServir$row[id_lineas]">
        <td>$row[nombre_articulo]</td>
        <td><button class="listoParaServir" id_lineascomanda="$row[id_lineas]" id_camarero="$_SESSION[id_usuario]">Servir</button></td>
        <td><button class="eliminarArticulo" id_lineascomanda="$row[id_lineas]" >Eliminar</button></td>
        </tr>
FIN_HTML;
            echo $enlace;
            $contador++;

        }
        echo '</table>';

    }
}

function comandas_elaboracion($id_comanda) {
    echo '<p class="clear_both">Aquí podrá ver los artículos pendientes o en elaboración por parte de la cocina:</p>';
    $res = select_lineascomanda_elaboracion($id_comanda);
    if($res){
        $res->setFetchMode(PDO::FETCH_NAMED);
        echo '<table id="elaboracion" style="clear:both">';
        echo '<tr>';
        echo '<th>Producto</th>';
        echo '<th>¿Elaboración?</th>';
        echo '</tr>';

        foreach($res as $row){
            $enlace = <<<FIN_HTML
            <tr>
        <td>$row[nombre_articulo]</td>
        <td>$row[elaboracion]</td>
        </tr>
FIN_HTML;
            echo $enlace;
        }
        echo '</table>';
    }
}

function cerrar_cobrar_comanda($id_comanda) {
    echo '<p> Aquí podrá ver los artículos ya servidos y su precio. Además puede cerrar la comanda y cobrarla:</p>';
    $res = select_lineascomanda_servidas($id_comanda);
    if($res){
        $res->setFetchMode(PDO::FETCH_NAMED);
        echo '<table style="clear:both" id="tablaProductosServidos">';
        echo '<tr>';
        echo '<th>Producto</th>';
        echo '<th>PVP</th>';
        echo '</tr>';
        $total = 0;

        foreach($res as $row){
            $total += $row['pvp'];
            $enlace = <<<FIN_HTML
            <tr>
        <td>$row[articulo]</td>
        <td>$row[pvp]</td>
        </tr>
FIN_HTML;
            echo $enlace;

        }
        $enlace = <<<FIN_HTML
        <tr>
        <td>TOTAL</td>
        <td id="precioTotal">$total</td>
        </tr>
FIN_HTML;
        echo $enlace;
        echo '</table>';
        echo '<form method="post" action="cerrar_cobrar.php">';
        echo "<input type=\"hidden\" name=\"pvp\" value=\"$total\"/>";
        echo "<input type=\"hidden\" name=\"id_mesa\" value=\"$_POST[id_mesa]\"/>";
        echo "<input type=\"hidden\" name=\"id_comanda\" value=\"$id_comanda\"/>";
        echo '<input class="boton_cerrar" type="submit" value="Cerrar y cobrar">';
        echo '</form>';


    }
}
