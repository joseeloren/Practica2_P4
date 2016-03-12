<?php
include_once 'queries.php';
include_once 'common.php';
include_once 'list_show.php';
session_start();
$res = new_comanda($_POST['id_comanda'], $_SESSION['id_usuario'], $_POST['articulo']);
if ($res) {
    writeNav();
    show_table('Ocupada');
}
