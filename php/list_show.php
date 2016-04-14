<?php
include 'ocupada.php';
function show_list() {
    if ($_SESSION['tipo_usuario']==1)
        show_camarero_list();
    else{

        show_cocinero_list();
    }

}

function show_camarero_list() {
    echo '<table>';
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
                <input class="boton_gen" type="submit" value="$row[Mesa]"/>
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

    $html = "<form method=\"post\" action=\"acciones_cocinero.php\">";
    //echo $html;
    $cabecera = <<<T_HTML
    <p class="clear_both">Aquí puede ver los artículos pedientes por cocinar:</p>
    <table>
        <tr>
            <th>Nombre de artículo</th>
            <th>Mesa</th>
            <th>¿Empezar a elaborar?</th>
        </tr>
T_HTML;

    echo $cabecera;
    $res = get_articulosPendientes();
    if($res){

        foreach($res as $row){
            $fila = <<<T_HTML
            <tr id="pendiente$row[id_lineascomanda]">
            <td> $row[articulo] </td>
            <td> $row[mesa] </td>
            <td> <button class="botonesP" id_usuario="$_SESSION[id_usuario]"  id_lineascomanda="$row[id_lineascomanda]" articulo="$row[articulo]" mesa="$row[mesa]">Hacer</button> </td>
            </tr>
T_HTML;

            echo $fila;
        }
    }
    echo "</table>";


    $cabecera = <<<T_HTML
    <p>Aquí puede encontrar los artículos en elaboración por usted. Indique si los ha acabado de cocinar:</p>
    <table id="tablaHaciendo">
        <tr>
            <th>Artículo en Elaboración</th>
            <th>Mesa</th>
            <th>¿Finalizar?</th>
        </tr>
T_HTML;

    echo $cabecera;
    $res = get_articulos_pendientes_de_cocinero();
    if($res){
        foreach($res as $row){
            $fila = "<tr id=haciendo$row[id_comanda]>
            <td> $row[articulo] </td>
            <td> $row[mesa] </td>
            <td> <button class=\"botonesF\" id_lineascomanda=\"$row[id_comanda]\"> Finalizar</button> </td>
            </tr>";
            echo $fila;
        }
    }
    echo "</table>";
    $html = "<div id=\"centrar_botoncito\"><input class=\"boton_gen\" type=\"submit\" value=\"Aceptar\">
    </div></form>";
    //echo $html;
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

        combobox_articulos($id_comanda);
        $formi = <<<FIN_HTML
       <form method="post" action="add_peticion.php" id="lineacomanda">
        <input type="hidden" name="id_mesa" value="$_POST[id_mesa]">
        <input type="hidden" name="id_comanda" value="$id_comanda">
        <input  class="button boton_peticion" type="submit" value="Añadir petición">
        </form>

FIN_HTML;
        //echo $formi;

        //Comandas en elaboración
        comandas_elaboracion($id_comanda);

        //Eliminar y servir peticiones de una comanda
        borrar_servir_comanda($id_comanda);

        //Cerrar y cobrar una comanda
        cerrar_cobrar_comanda($id_comanda);
    }
    else {
        //Comenzar una nueva comanda
        echo '<p class="clear_both">Haga click en el botón "Nueva comanda" para comenzar una comanda en esta mesa:</p>';
        $formi = <<<FIN_HTML
        <div id="center_form">
        <form class="clear_both" method="post" action="add_comanda.php">
                <input type="hidden" name="id_mesa" value="$_POST[id_mesa]">
                <input class="boton_gen" type="submit" value="Nueva comanda">
        </form>
        </div>
FIN_HTML;
        echo $formi;
    }
}
