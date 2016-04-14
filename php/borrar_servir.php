<?php
include_once 'queries.php';
prepare_database();
include_once 'common.php';
include_once 'list_show.php';
session_start();
if (isset($_POST['servir']))
    foreach($_POST['servir'] as $id_linea)
        query_servir($id_linea);
if (isset($_POST['eliminar']))
    foreach($_POST['eliminar'] as $id_linea)
        query_eliminar($id_linea);
writeNav();
show_table("Ocupada");
endPage();
