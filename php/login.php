<?php
include_once 'common.php';
$db = new PDO("sqlite:../datos.db");
$db->exec('PRAGMA foreign_keys = ON;');
session_name('session');
session_start();
if (isset($_SESSION['session'])) {
    $res=$db->prepare('SELECT nombre FROM usuarios where usuario=?;');
    $res->execute(array($_SESSION['session']));
    echo 'Hay cookie';
}
else {
    unset($_SESSION['session']);
    $usuario =  $_GET['usuario'];
    $clave =  $_GET['clave'];
    $md5 = md5($clave);
    $res=$db->prepare('SELECT nombre FROM usuarios where usuario=? and clave=?;');
    $res->execute(array($usuario, $md5));
    echo 'NO hay cookie';
}
$name = null;
if($res){
    if (isset($_SESSION['session'])) {
        $_SESSION['session'] = $usuario;
    }
    $res->setFetchMode(PDO::FETCH_NAMED);
    foreach($res as $row){
        foreach($row as $field=>$value){
            $name = $value;
        }
    }
}
if (!is_null($name)) {
    writeNav();
    echo "<p id=\"saludo_login\">¡Bienvenido $name!</p>";
    echo '<table><tr>';
    $res=$db->prepare('select id, nombre as Mesa, \'Libre\' as Ocupacion from mesas where id not in(SELECT mesas.id FROM mesas, comandas where mesas.id=mesa) union SELECT mesas.id, nombre as Mesa, \'Ocupada\' as Ocupacion from mesas, comandas where mesas.id=mesa');
    $res->execute();
    //Ejemplo de lectura de tabla
    if($res){
        $res->setFetchMode(PDO::FETCH_NAMED);

        echo "<tr>\n";
        echo "<th>Mesa</th>";
        echo "<th>Ocupacion</th>";
        echo "</tr>";

        foreach($res as $game){

            echo "<tr>\n";
            $enlace = <<<FIN_HTML
            <td>
                <form id="login" action="table.php">
                    <input type="hidden" name="usuario" value=$usuario>
                    <input type="hidden" name="id_mesa" value=$game[id]>
                    <input type="hidden" name="estado" value=$game[Ocupacion]>
                    <input class="button" type="submit" value="$game[Mesa]">
                </form>
            </td>
FIN_HTML;
            echo $enlace;
            echo "\t<td>$game[Ocupacion]</td>\n";
            echo "</tr>\n";
        }

    }
    echo '</table>';
} else {
    writeBadLogin();
}
