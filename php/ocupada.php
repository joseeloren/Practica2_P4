<?php
include_once 'queries.php';
prepare_database();
function combobox_articulos($id_comanda) {
    echo '<p class="clear_both ocupada" >Seleccione, solo haciendo click, un artículo pedido por el cliente:<p>';
    echo '<select class="selector ocupada" name="id_articulo" id_camarero="'.$_SESSION['id_usuario'].'" id_comanda="'.$id_comanda.'">';
    $res = select_articulos();
    if ($res) {
        $res->setFetchMode(PDO::FETCH_NAMED);
        foreach($res as $row)
            echo "<option value=\"$row[id_articulo]\">$row[nombre]</option>";
    }
      echo '</select>';
    echo '<input  class="button boton_peticion ocupada" type="submit" value="Añadir petición">';
}

function borrar_servir_comanda($id_comanda) {
    echo '<p class="ocupada">Aquí podrá servir un producto ya preparado o que no requiera preparación o eliminarlo, si el cliente ya no lo quiere:</p>';
    $res = select_lineascomanda($id_comanda);
    if($res){
        $res->setFetchMode(PDO::FETCH_NAMED);

        echo '<table id="borrar_servir" class="clear_both ocupada">';
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
    echo '<p class="clear_both ocupada">Aquí podrá ver los artículos pendientes o en elaboración por parte de la cocina:</p>';
    $res = select_lineascomanda_elaboracion($id_comanda);
    if($res){
        $res->setFetchMode(PDO::FETCH_NAMED);
        echo '<table id="elaboracion" class="ocupada clear_both">';
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
    echo '<p class="ocupada"> Aquí podrá ver los artículos ya servidos y su precio. Además puede cerrar la comanda y cobrarla:</p>';
    $res = select_lineascomanda_servidas($id_comanda);
    if($res){
        $res->setFetchMode(PDO::FETCH_NAMED);
        echo '<table class="ocupada clear_both" id="tablaProductosServidos">';
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
        echo '<form class="ocupada" method="post" action="cerrar_cobrar.php">';
        echo "<input type=\"hidden\" name=\"pvp\" value=\"$total\"/>";
        echo "<input type=\"hidden\" name=\"id_mesa\" value=\"$_POST[id_mesa]\"/>";
        echo "<input type=\"hidden\" name=\"id_comanda\" value=\"$id_comanda\"/>";
        echo '<input class="boton_cerrar" type="submit" value="Cerrar y cobrar">';
        echo '</form>';


    }
}
