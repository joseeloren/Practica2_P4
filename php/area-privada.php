<?php
include_once 'common.php';
include_once 'queries.php';
include_once 'list_show.php';
session_start();
writeNav();
if (isset($_SESSION['usuario']) && isset($_SESSION['clave'])) {
    $usuario = $_SESSION['usuario'];
    $clave = $_SESSION['clave'];
}
if(isset($_GET['usuario']) && isset($_GET['clave'])) {
    $usuario = $_GET['usuario'];
    $clave = $_GET['clave'];
}

if(isset($usuario) && isset($clave)) {
    $res = select_name_type($usuario, $clave);
    if($res){
        $arr = $res->fetch(PDO::FETCH_NAMED);
        if (strcmp($arr['nombre'],'') != 0) {
            echo "<p id=\"saludo_login\">¡Bienvenido $arr[nombre]!</p><a href=\"cerrar_session.php\">Cerrar sesión</a>";
            $_SESSION['usuario'] = $usuario;
            $_SESSION['clave'] = $clave;
            $_SESSION['nombre'] = $arr['nombre'];
            $_SESSION['tipo_rol'] = $arr['tipo'];
            $_SESSION['id_usuario'] = $arr['id'];
            show_list($arr['tipo'], $arr['id'], $arr['nombre'],$usuario);
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
