<?php
include 'ocupada.php';
function show_list() {
    if ($_SESSION['tipo_usuario']==1)
        show_camarero_list();
    else
        show_cocinero_list();
}

function show_camarero_list() {
    echo '<table><tr>';
    $res=select_de_mesa();
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
                <form method="post" action="table.php">
                <input type="hidden" name="id_mesa" value="$row[id_mesa]">
                <input type="hidden" name="estado" value="$row[ocupacion]">
                <input type="submit" value="$row[Mesa]"/>
                </form>

            </td>
FIN_HTML;
            echo $enlace;
            echo "\t<td>$row[ocupacion]</td>\n";
            echo "</tr>\n";
        }

    }
    echo '</table>';
}

function show_cocinero_list() {
    $cabecera = <<<T_HTML
    <table>
        <tr>
            <th>Nombre de artículo</th>
            <th>Mesa</th>
            <th>Indicar inicio</th>
        </tr>
T_HTML;

    echo $cabecera;
    $res = get_articulosPendientes();
    if($res){
        foreach($res as $game){
            $fila = <<<T_HTML
            <tr>
            <td> {get_nombreArticulo($game[articulo])['nombre']} </td>
            <td> {get_nombreMesa($game[mesa])[nombre]} </td>
            <td>  </td>
            </tr>
T_HTML;
            echo $fila;
        }
    }
    echo "</table>";

    $cabecera = <<<T_HTML
    <table>
        <tr>
            <th>Artículo en Elaboración</th>
            <th>Indicar Finalización</th>
        </tr>
T_HTML;

    echo $cabecera;
    $res = get_articulos_pendientes_de_cocinero($_SESSION['id_usuario']);
    if($res){
        foreach($res as $game){
            $nombre_art = get_nombreArticulo($game['articulo']);
            foreach ($nombre_art as $row)
                $nombrecito = $row['nombre'];
            $fila = "<tr>
            <td> $nombrecito </td>
            <td>  </td>
            </tr>";
            echo $fila;
        }
    }
}

function show_table($ocupacion=NULL) {
    if (isset($_POST['estado']))
        $ocupacion = $_POST['estado'];


    if (strcmp($ocupacion, "Ocupada") == 0) {
        //Añadir peticiones a una comanda

        $res = obtener_comanda_activa_de_mesa($_POST['id_mesa']);
        if($res) {
            foreach($res as $row)
                $id_comanda = $row['id_comanda'];
        }

        combobox_articulos();
        $formi = <<<FIN_HTML
       <form method="post" action="add_peticion.php" id="lineacomanda">
        <input type="hidden" name="id_mesa" value="$_POST[id_mesa]">
        <input type="hidden" name="id_comanda" value="$id_comanda">
        <input  class="button boton_peticion" type="submit" value="Añadir petición">
        </form>

FIN_HTML;
        echo $formi;

        //Eliminar y servir peticiones de una comanda
        borrar_servir_comanda($_POST['id_mesa'], $id_comanda);

        //Cerrar y cobrar una comanda
        cerrar_cobrar_comanda($_POST['id_mesa'], $id_comanda);
    }
    else {
        //Comenzar una nueva comanda
        $formi = <<<FIN_HTML
        <form method="post" action="add_comanda.php">
                <input type="hidden" name="id_mesa" value="$_POST[id_mesa]">
                <input class="button boton_comanda" type="submit" value="Nueva comanda">
        </form>
FIN_HTML;
        echo $formi;
    }
}
