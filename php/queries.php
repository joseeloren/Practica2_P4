<?php
include_once 'database.php';

function select_name_type($usuario, $clave) {
    $query = 'SELECT id, nombre, tipo FROM usuarios where usuario=? and clave=?;';
    $md5 = md5($clave);
    $array = array($usuario, $md5);
    $res = query_from_database($query, $array);
    return $res;
}

function select_de_mesa() {
    $query = 'select id, nombre as Mesa, \'Libre\' as Ocupacion from mesas where id not in(SELECT mesas.id FROM mesas, comandas where mesas.id=mesa) union SELECT mesas.id, nombre as Mesa, \'Ocupada\' as Ocupacion from mesas, comandas where mesas.id=mesa';
    $array = array();
    $res = query_from_database($query, $array);
    return $res;
}

function new_comanda($id_mesa, $id_camarero) {
    $time = time();
    $query = 'INSERT into comandas (mesa, camareroapertura, horaapertura) values (?, ?, ?);';
    $array = array($id_mesa, $id_camarero, $time);
    $res = query_from_database($query, $array);
    return $res;
}

function select_articulos() {
    $query = 'SELECT id, nombre from Articulos where stock > 0;';
    $array = array();
    $res = query_from_database($query, $array);
    return $res;
}

function  select_lineascomanda($id_mesa) {
    $query = 'select lineascomanda.id as \'id\', articulos.nombre from articulos, lineascomanda, comandas where articulos.id=articulo and comandas.id=comanda and mesa=? and horacierre=0';
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
    $res = query_from_database('INSERT INTO [lineascomanda] ([cocinero], [horainicio]) VALUES (?,?) WHERE id=?;', $array);
}

function finalizar_articulo($id_lineascomanda){
    $array = array(time(), $id_lineascomanda);
    $res = query_from_database('INSERT INTO [lineascomanda] ([horafinalizacion]) VALUES (?) WHERE id=?;', $array);
}
