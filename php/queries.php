<?php
$db = 0;

function prepare_database() {
    global $db;
    $db = new PDO("sqlite:../datos.db");
    $db->exec('PRAGMA foreign_keys = ON;');
}

function query_from_database($query, $array=array()) {
    global $db;
    $res= $db->prepare($query);
    $res->execute($array);
    if ($res) {
        $res->setFetchMode(PDO::FETCH_NAMED);
    }
    return $res;
}
function select_name_type_id($usuario, $clave) {
    $query = 'SELECT id as id_usuario, nombre as nombre_usuario,  tipo as tipo_usuario FROM usuarios where usuario=? and clave=?;';
    $md5 = md5($clave);
    $array = array($usuario, $md5);
    $res = query_from_database($query, $array);
    return $res;
}

function select_de_mesa() {
    $query = 'select id as id_mesa, nombre as Mesa, \'Libre\' as ocupacion from mesas where id not in(SELECT mesas.id FROM mesas, comandas where mesas.id=mesa and horacierre=0) union SELECT mesas.id, nombre as Mesa, \'Ocupada\' as Ocupacion from mesas, comandas where mesas.id=mesa  and horacierre=0';
    $res = query_from_database($query);
    return $res;
}

function new_comanda() {
    $time = time();
    $query = 'INSERT INTO comandas (mesa, camareroapertura, horaapertura) VALUES (?, ?, ?);';
    $array = array($_POST['id_mesa'], $_SESSION['id_usuario'], $time);
    $res = query_from_database($query, $array);
    return $res;
}

function select_articulos() {
    $query = 'SELECT id as id_articulo, nombre from Articulos where stock > 0;';
    $res = query_from_database($query);
    return $res;
}

function  select_lineascomanda($id_comanda) {
    $query = 'select lineascomanda.id as \'id_lineas\', articulos.nombre as \'nombre_articulo\' from articulos, lineascomanda, comandas where articulos.id=articulo and comandas.id=comanda and comanda=? and horaservicio=0 and ((articulos.tipo=1 and horafinalizacion!=0) or(articulos.tipo=0));';
    $array = array($id_comanda);
    $res = query_from_database($query, $array);
    return $res;
}

function  select_lineascomanda_elaboracion($id_comanda) {
    $query = 'select lineascomanda.id as id_lineascomanda, articulos.nombre as nombre_articulo, \'En elaboración\' as elaboracion from articulos, lineascomanda, comandas where articulos.id=articulo and comandas.id=comanda and comanda=? and horaservicio=0 and articulos.tipo=1 and horafinalizacion=0 and horainicio!=0 UNION select lineascomanda.id as id_lineascomanda, articulos.nombre as nombre_articulo, \'Pendiente\' as elaboracion from articulos, lineascomanda, comandas where articulos.id=articulo and comandas.id=comanda and comanda=? and horaservicio=0 and articulos.tipo=1 and horafinalizacion=0 and horainicio=0;';
    $array = array($id_comanda,$id_comanda);
    $res = query_from_database($query, $array);
    return $res;
}

function select_buscar_plato($platito) {
    $query = <<<FIN
        SELECT nombre, pvp as pvp from articulos where nombre like '%$platito%';
FIN;
    $res = query_from_database($query);
    return $res;
}

function  select_lineascomanda_servidas($id_comanda) {
    $query = 'select lineascomanda.id as id_lineas, articulos.nombre as articulo, articulos.pvp as pvp from articulos, lineascomanda, comandas where articulos.id=articulo and comandas.id=comanda and comanda=? and horaservicio>0';
    $array = array($id_comanda);
    $res = query_from_database($query, $array);
    return $res;
}

function get_articulosPendientes(){
    $res = query_from_database('Select articulos.nombre as articulo, mesas.nombre as mesa, lineascomanda.id as id_lineascomanda FROM lineascomanda,articulos, comandas, mesas WHERE cocinero is null and articulos.tipo=1 and articulo=articulos.id and comandas.id=comanda and mesa=mesas.id;');
    return $res;
}

function get_articulos_pendientes_de_cocinero(){
    $array = array($_SESSION['id_usuario']);
    $res = query_from_database('Select articulos.nombre as articulo, mesas.nombre as mesa, lineascomanda.id as id_comanda FROM lineascomanda,articulos,comandas, mesas WHERE articulos.id=articulo and cocinero=? and mesas.id=mesa and comandas.id=comanda and horafinalizacion=0;', $array);
    return $res;
}
function get_articulos_pendientes_de_cocinero_concreto($id_lineascomanda){
    $array = array($id_lineascomanda, $_SESSION['id_usuario']);
    $res = query_from_database('Select articulos.nombre as articulo, mesas.nombre as mesa, lineascomanda.id as id_comanda FROM lineascomanda,articulos,comandas, mesas WHERE lineascomanda.id= ? articulos.id=articulo and cocinero=? and mesas.id=mesa and comandas.id=comanda and horafinalizacion=0;', $array);
    return $res;
}

function get_nombreMesa($id_mesa){
    $array = array($id_mesa);
    $res = query_from_database('Select nombre FROM mesas WHERE id=?;', $array);
    return $res;
}

function query_indicar_preparacion($id_lineascomanda){
    $array = array($_SESSION['id_usuario'], time(), $id_lineascomanda);
    $res = query_from_database('UPDATE lineascomanda SET cocinero=?, horainicio=? WHERE id=?;', $array);
}

function query_indicar_finalizacion($id_lineascomanda){
    $array = array(time(), $id_lineascomanda);
    $res = query_from_database('UPDATE lineascomanda SET horafinalizacion=? WHERE id=?;', $array);
}

function add_peticion($id_comanda) {
    $query = 'INSERT INTO lineascomanda (comanda, articulo, camareropeticion, horapeticion) VALUES (?,?,?,?);';
    $time = time();
    $array = array($id_comanda, $_POST['id_articulo'], $_SESSION['id_usuario'], $time);
    $res = query_from_database($query, $array);
    return $res;
}
function obtener_comanda_activa_de_mesa($id_mesa) {
    $query = 'SELECT comandas.id AS \'id_comanda\' FROM comandas WHERE mesa=? AND horacierre=0;';
    $array = array($id_mesa);
    $res = query_from_database($query, $array);
    return $res;
}

function query_servir($id_linea) {
    $query = 'UPDATE lineascomanda SET camareroservicio=?, horaservicio=? WHERE id=?;';
    $time = time();
    $array = array($_SESSION['id_usuario'], $time, $id_linea);
    $res = query_from_database($query, $array);
    return $res;
}

function query_eliminar($id_linea) {
    $query = 'DELETE FROM lineascomanda WHERE id=?;';
    $array = array($id_linea);
    $res = query_from_database($query, $array);
    return $res;
}

function query_cerrar_cobrar() {
    $query = 'DELETE FROM lineascomanda WHERE horaservicio=0 AND comanda=?;';
    $array = array($_POST['id_comanda']);
    $res = query_from_database($query, $array);
    if ($res) {
        $query = 'UPDATE comandas SET camarerocierre=?, horacierre=?, pvp=? WHERE mesa=? AND horacierre=0;';
        $time = time();
        $array = array($_SESSION['id_usuario'],$time, $_POST['pvp'], $_POST['id_mesa']);
        $res = query_from_database($query, $array);
        return $res;
    }
}


