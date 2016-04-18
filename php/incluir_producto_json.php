<?php
$res = new stdClass();
$res->inserted=false; //Formato objeto con propiedad deleted (por defecto a false)
$res->message='';
$res->type='';
$res->id_lineascomanda='';
try{
    $datoscrudos = file_get_contents("php://input"); //Leemos los datos
    $datos = json_decode($datoscrudos);
    $db = new PDO("sqlite:../datos.db");
    $db->exec('PRAGMA foreign_keys = ON;'); //Activa la integridad referencial para esta conexión

    $sql=$db->prepare('INSERT INTO lineascomanda (comanda, articulo, camareropeticion, horapeticion) VALUES (?,?,?,?);');
    $db -> beginTransaction();
    $sql->execute(array($datos->id_comanda, $datos->id_articulo, $datos->id_camarero,time()));
    $id = $db->lastInsertId();
    $db -> commit();
    if($sql){

        if($sql->rowCount()==1){ //Numero de filas/registros afectadas
           $res->inserted=true; //Devolvemos que ha sido borrado
            $res->id_lineascomanda=$id;
        }else{
            $res->message='No se ha insertado correctamente';
        }
        $sql=$db->prepare('SELECT tipo FROM articulos WHERE id=?');
        $sql->execute(array($datos->id_articulo));
        if($sql){
            foreach($sql as $row){
                $res->type=$row['tipo'];
            }

        } else {
            $res->message='No se ha podido consultar tipo del articulo';
        }

    }else{
        $res->message='No se ha podido preparar la instrucción SQL de insertar un articulo';
    }

}catch(Exception $e){
   //En caso de error se envia la información de error al navegador
   $res->message="Se ha producido una excepción en el servidor: ".$e->getMessage();
}
echo json_encode($res);
