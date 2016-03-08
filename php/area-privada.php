<?php
include_once 'common.php';
include_once 'queries.php';
include_once 'list_show.php';

writeNav();
if(isset($_GET['usuario']) && isset($_GET['clave'])) {
    $res = select_name_type($_GET['usuario'], $_GET['clave']);
    if($res){
        $arr = $res->fetch(PDO::FETCH_NAMED);
        if (strcmp($arr['nombre'],'') != 0) {
            echo "<p id=\"saludo_login\">¡Bienvenido $arr[nombre]!</p>";
            show_list($arr['tipo'], $arr['id'], $arr['nombre'],$_GET['usuario']);
        } else {
            writeBadLogin();
        }
    } else {
      //Algo chungo ha pasado en la base de datos
    }
}
else {
    writeLogin();
}
