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
    $query = "INSERT into comandas (mesa, camareroapertura, horaapertura) values (?, ?, ?);";
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

function select_articulos_from_comanda($id_comanda) {
    $query = 'select lineascomanda.id, nombre from articulos, lineascomanda where articulos.id=articulo;';
}
