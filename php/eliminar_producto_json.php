<?php
$res = new stdClass();
$res->deleted=false; //Formato objeto con propiedad deleted (por defecto a false)
$res->message='';
try{
    $datoscrudos = file_get_contents("php://input");
    $datos = json_decode($datoscrudos);
    $db = new PDO("sqlite:../datos.db");
    $db->exec('PRAGMA foreign_keys = ON;');
    $sql=$db->prepare('DELETE FROM lineascomanda WHERE id=?;');
    if($sql){
        $sql->execute(array($datos->id_linea));
        if($sql->rowCount()>0){
           $res->deleted=true;

        }else{
            $res->message='No se ha encontrado el registro a borrar';
        }
    }else{
        $res->message='No se ha podido preparar la instrucción SQL';
    }
}catch(Exception $e){
   //En caso de error se envia la información de error al navegador
   $res->message="Se ha producido una excepción en el servidor: ".$e->getMessage();
}

echo json_encode($res);
