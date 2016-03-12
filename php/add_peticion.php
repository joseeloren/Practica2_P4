<?php
include_once 'queries.php';
include_once 'common.php';
include_once 'list_show.php';
session_start();
$res = add_peticion();
if ($res) {
    writeNav();
    show_table("Ocupada");
}
