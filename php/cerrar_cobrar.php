<?php
    include_once 'queries.php';
    $res = query_cerrar_cobrar();
    if ($res) {
        header('Location: area-privada.php');
    }
