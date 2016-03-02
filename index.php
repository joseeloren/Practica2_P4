<?php
include_once 'lib.php';
View::start('Restaurante');
echo '<img class="minilogo" src="logo.png">';
$db = new PDO("sqlite:./datos.db");
$db->exec('PRAGMA foreign_keys = ON;'); //Activa la integridad referencial para esta conexión
$res=$db->prepare('SELECT * FROM articulos;');
$res->execute();
//Ejemplo de lectura de tabla
if($res){
    echo '<h2>Ejemplo acceso a tabla</h2>';
    $res->setFetchMode(PDO::FETCH_NAMED);
    $first=true;
    foreach($res as $game){
        if($first){
            echo "<table><tr>";
            foreach($game as $field=>$value){
                echo "<th>$field</th>";
            }
            $first = false;
            echo "</tr>";
        }
        echo "<tr>";
        foreach($game as $value){
            echo "<th>$value</th>";
        }
        echo "</tr>";
    }
    echo '</table>';
}
View::end();
