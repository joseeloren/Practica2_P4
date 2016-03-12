<?php
include_once 'queries.php';
include_once 'common.php';
include_once 'list_show.php';
$res = add_peticion($_GET['id_mesa'], $_GET['id_camarero']);
if ($res) {
    writeNav();
    $res = select_name_type($_GET['usuario'], $_GET['rol']);
    if($res){
        echo "<p id=\"saludo_login\">¡Bienvenido $_GET[nombre_usuario]!</p>";
        show_list($_GET['rol'], $_GET['id_camarero'], $_GET['nombre_usuario'], $_GET['usuario']);
    }
}
