<?php
    include_once 'queries.php';
prepare_database();
    $res = query_cerrar_cobrar();
    if ($res) {
        header('Location: area-privada.php');
    }
