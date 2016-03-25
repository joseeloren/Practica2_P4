<?php
    include_once 'queries.php';
    prepare_database();
    session_start();

    $finalizacion = $_POST['finalizar'];
    if(isset($finalizacion)){
        foreach($finalizacion as $id_lineascomanda){
            query_indicar_finalizacion($id_lineascomanda);
        }
    }

    $preparacion = $_POST['preparar'];
    if(isset($preparacion)){
        foreach($preparacion as $id_lineascomanda){
            query_indicar_preparacion($id_lineascomanda);
        }
    }




    header('Location: area-privada.php');

