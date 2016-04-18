<?php
include_once '../lib.php';
include_once 'queries.php';
prepare_database();
include_once 'list_show.php';
session_start();
writeNav();
if (isset($_SESSION['id_usuario']) && isset($_SESSION['nombre_usuario']) && isset($_SESSION['tipo_usuario'])) {
    echo escribir_bienvenida($_SESSION['nombre_usuario']);
    show_list();
}
elseif(isset($_POST['usuario']) && isset($_POST['clave'])) {
    $res = select_name_type_id($_POST['usuario'], $_POST['clave']);
    if($res){
        $arr = $res->fetch(PDO::FETCH_NAMED);
        if (strcmp($arr['nombre_usuario'],'') != 0) {
            $_SESSION['nombre_usuario'] = $arr['nombre_usuario'];
            $_SESSION['tipo_usuario'] = $arr['tipo_usuario'];
            $_SESSION['id_usuario'] = $arr['id_usuario'];
            echo escribir_bienvenida($_SESSION['nombre_usuario']);
            show_list();
        } else {
            writeBadLogin();
        }
    } else {
      echo '<p>ERROR EN LA BASE DE DATOS<\p>';
    }
}
else {
    writeLogin();
}
endPage();
