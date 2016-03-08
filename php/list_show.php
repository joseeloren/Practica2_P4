<?php
function show_list($type, $user_id, $nombre_usuario, $usuario) {
    if ($type==1)
        show_camarero_list($user_id,$nombre_usuario, $usuario, $type);
    else
        show_cocinero_list($user_id,$nombre_usuario, $usuario, $type);
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
                <form id="login" action="table.php">
                    <input type="hidden" name="id_usuario" value=$user_id>
                    <input type="hidden" name="nombre_usuario" value=$nombre_usuario>
                    <input type="hidden" name="usuario" value=$usuario>
                    <input type="hidden" name="rol" value=$type>
                    <input type="hidden" name="id_mesa" value=$row[id]>
                    <input type="hidden" name="estado" value=$row[Ocupacion]>
                    <input class="button" type="submit" value="$row[Mesa]">
                </form>
            </td>
FIN_HTML;
            echo $enlace;
            echo "\t<td>$row[Ocupacion]</td>\n";
            echo "</tr>\n";
        }

    }
    echo '</table>';
}

function show_cocinero_list($user_id,$nombre_usuario, $usuario, $type) {

}
