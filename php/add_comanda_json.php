<?php
$res = new stdClass();
$res->message='';
$res->id_comanda=-1;
try{
    $datoscrudos = file_get_contents("php://input");
    $datos = json_decode($datoscrudos);
    $db = new PDO("sqlite:../datos.db");
    $db->exec('PRAGMA foreign_keys = ON;');
    $sql=$db->prepare('INSERT INTO comandas (mesa, camareroapertura, horaapertura) VALUES (?, ?, ?);');
    $db -> beginTransaction();
    $sql->execute(array($datos->id_mesa, $datos->id_camarero, time()));
    $id = $db->lastInsertId();
    $db -> commit();
    if($sql){
        if($sql->rowCount()>0){
           $res->id_comanda=$id;
        }else{
            $res->message='No se ha encontrado el registro a borrar';
            $res->id_comanda=-1;
        }
    }else{
        $res->message='No se ha podido preparar la instrucción SQL';
        $res->id_comanda=-1;
    }
}catch(Exception $e){
   //En caso de error se envia la información de error al navegador
   $res->message="Se ha producido una excepción en el servidor: ".$e->getMessage();
    $res->id_comanda=-1;
}

echo json_encode($res);
