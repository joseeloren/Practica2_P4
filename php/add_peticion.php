<?php
    include_once 'queries.php';
    prepare_database();
    include_once 'common.php';
    include_once 'list_show.php';
    session_start();
    $res = add_peticion($_POST['id_comanda']);
    if ($res) {
        writeNav();
        show_table('Ocupada');
        endPage();
    }
