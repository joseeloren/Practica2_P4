<?php
function show_list($type, $user_id, $nombre_usuario, $usuario) {
    if ($type==1)
        show_camarero_list($user_id,$nombre_usuario, $usuario, $type);
    else
        show_cocinero_list();
}

function show_camarero_list($user_id, $nombre_usuario, $usuario, $type) {
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
                <a style="font-size:15px" href="table.php?id_mesa=$row[id]&estado=$row[Ocupacion]">
                    $row[Mesa]</a>
            </td>
FIN_HTML;
            echo $enlace;
            echo "\t<td>$row[Ocupacion]</td>\n";
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
