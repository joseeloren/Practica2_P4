<!doctype html>
<html>
<head>
<meta charset=\"utf-8\">
<link rel=\"stylesheet\" type=\"text/css\" href=\"estilos.css\">
<title>Todo</title>
</head>
<body>
<?php
$db = new PDO("sqlite:./datos.db");
$db->exec('PRAGMA foreign_keys = ON;'); //Activa la integridad referencial para esta conexión

Function all($table){
    global $db;
    $res=$db->prepare("SELECT * FROM $table;");
    $res->execute();
    $res->setFetchMode(PDO::FETCH_NAMED);
    $all=$res->fetchAll();
    echo "<h1>$table</h1>";
    echo "<table>";
    foreach($all as $id =>$row){
        if($id == 0){
            echo "<tr>";
            foreach($row as $field=>$value){
                echo "<th>$field</th>";
            }
            echo "</tr>";
        }
        echo "<tr>";
        foreach($row as $value){
            echo "<th>$value</th>";
        }
        echo "</tr>";
    }
    echo '</table>';
}
all('usuarios');
all('articulos');
all('mesas');
all('comandas');
all('lineascomanda');
?>
</body>
</html>
