<?php
include_once 'queries.php';
prepare_database();
$res = new stdClass();
$res->modified=false; //Formato objeto con propiedad deleted (por defecto a false)
$res->message='';
try{
    $datoscrudos = file_get_contents("php://input"); //Leemos los datos
    $datos = json_decode($datoscrudos);
    $db = new PDO("sqlite:../datos.db");
    $db->exec('PRAGMA foreign_keys = ON;'); //Activa la integridad referencial para esta conexión
    $sql=$db->prepare('UPDATE lineascomanda SET horafinalizacion=? WHERE id=?;');

    $sql->execute(array(time(),$datos->id));
    if($sql){

        if($sql->rowCount()>0){ //Numero de filas/registros afectadas
           $res->modified=true; //Devolvemos que ha sido borrado
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
