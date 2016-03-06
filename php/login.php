<?php
include_once 'common.php';
$usuario =  $_GET['usuario'];
$clave =  $_GET['clave'];
$db = new PDO("sqlite:../datos.db");
$db->exec('PRAGMA foreign_keys = ON;');
$md5 = md5($clave);
$res=$db->prepare('SELECT nombre FROM usuarios where usuario=? and clave=?;');
$res->execute(array($usuario, $md5));
$name = null;
if($res){
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
    $res=$db->prepare('select nombre as Mesa, \'Libre\' as Ocupacion from mesas where id not in(SELECT mesas.id FROM mesas, comandas where mesas.id=mesa) union SELECT nombre as Mesa, \'Ocupada\' as Ocupacion from mesas, comandas where mesas.id=mesa');
    $res->execute();
    //Ejemplo de lectura de tabla
    if($res){
        $res->setFetchMode(PDO::FETCH_NAMED);
        $first=true;
        foreach($res as $game){
            if($first){
                foreach($game as $field=>$value){
                    echo "<th>$field</th>";
                }
                $first = false;
                echo "</tr>";
            }
            echo "<tr>";
            $count = 1;
            foreach($game as $value){
                if (%count % 3 == 0)
                    echo "<th><a href=$value</th>";
                else
                    echo "<th>$value</th>";
                $count++;
            }
            echo "</tr>";
        }

    }
    echo '</table>';
} else {
    writeBadLogin();
}
