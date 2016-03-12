<?php
function query_from_database($query, $array) {
    $db = new PDO("sqlite:../datos.db");
    $db->exec('PRAGMA foreign_keys = ON;');
    $res=$db->prepare($query);
    $res->execute($array);
    if ($res)
        $res->setFetchMode(PDO::FETCH_NAMED);
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
    $array = array();
    $res = query_from_database($query, $array);
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
    $array = array();
    $res = query_from_database($query, $array);
    return $res;
}

function  select_lineascomanda($id_mesa) {
    $query = 'select lineascomanda.id as \'id_lineas\', articulos.nombre as \'nombre_articulo\' from articulos, lineascomanda, comandas where articulos.id=articulo and comandas.id=comanda and mesa=? and horaservicio=0';
    $array = array($id_mesa);
    $res = query_from_database($query, $array);
    return $res;
}

function  select_lineascomanda_servidas($id_mesa) {
    $query = 'select lineascomanda.id as id_lineas, articulos.nombre as articulo, articulos.pvp as pvp from articulos, lineascomanda, comandas where articulos.id=articulo and comandas.id=comanda and mesa=? and horaservicio!=0';
    $array = array($id_mesa);
    $res = query_from_database($query, $array);
    return $res;
}

function get_articulosPendientes(){
    $array = array();
    $res = query_from_database('Select * FROM lineascomanda WHERE tipo=1 and cocinero=NULL;', $array);
    return $res;
}

function get_articulos_pendientes_de_cocinero($id){
    $array = array($id);
    $res = query_from_database('Select * FROM lineascomanda WHERE cocinero=?;', $array);
    return $res;
}

function get_nombreArticulo($id_articulo){
    $array = array($id_articulo);
    $res = query_from_database('Select nombre FROM articulos WHERE id=?;', $array);
    return $res;
}

function get_nombreMesa($id_mesa){
    $array = array($id_mesa);
    $res = query_from_database('Select nombre FROM mesas WHERE id=?;', $array);
    return $res;
}

function iniciar_articulo($id_lineascomanda){
    $array = array($_SESSION['id_usuario'], time(), $id_lineascomanda);
    $res = query_from_database('UPDATE lineascomandas SET cocinero=?, horainicio=? WHERE id=?;', $array);
}

function finalizar_articulo($id_lineascomanda){
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
    $query = 'UPDATE comandas SET camarerocierre=?, horacierre=?, pvp=? WHERE mesa=? AND horacierre=0;';
    $time = time();
    $array = array($_SESSION['id_usuario'],$time, $_POST['pvp'], $_POST['id_mesa']);
    $res = query_from_database($query, $array);
    return $res;
}
