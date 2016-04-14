<?php
$res = new stdClass();
$res->modified=false; //Formato objeto con propiedad deleted (por defecto a false)
$res->message=''; //Mensaje en caso de error
$res->articulo='';
$res->pvp='';
try{
    $datoscrudos = file_get_contents("php://input");
    $datos = json_decode($datoscrudos);
    $db = new PDO("sqlite:../datos.db");
    $db->exec('PRAGMA foreign_keys = ON;');
    $sql=$db->prepare('UPDATE lineascomanda SET camareroservicio=?, horaservicio=? WHERE id=?;');
    if($sql){
        $sql->execute(array($datos->id_camarero,time(),$datos->id_linea));
        if($sql->rowCount()>0){
           $res->modified=true;
           $sql=$db->prepare('select articulos.nombre as articulo, articulos.pvp as pvp from articulos, lineascomanda where articulos.id=articulo and horaservicio>0 and lineascomanda.id=?;');
           if($sql){
                $sql->execute(array($datos->id_linea));
                foreach($sql as $row){
                    $res->articulo=$row['articulo'];
                    $res->pvp=$row['pvp'];
                }
           }
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
