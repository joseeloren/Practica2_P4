<?php
    include_once 'queries.php';
    session_start();

    $finalizacion = $_POST['finalizar'];
    print_r($finalizacion);
    if($finalizacion){
        foreach($finalizacion as $id_lineascomanda){
            query_indicar_finalizacion($id_lineascomanda);
        }
    }

    $preparacion = $_POST['preparar'];
    print_r($preparacion);
    if($preparacion){
        foreach($preparacion as $id_lineascomanda){
            query_indicar_preparacion($id_lineascomanda);
        }
    }




    header('Location: area-privada.php');

