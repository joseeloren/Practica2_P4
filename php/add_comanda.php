<?php
include_once 'common.php';
$id_mesa =  $_GET['id_mesa'];
$id_camarero =  $_GET['id_camarero'];
$horaapetura = $_GET['horaapertura'];
$db = new PDO("sqlite:../datos.db");
$db->exec('PRAGMA foreign_keys = ON;');
$res=$db->prepare("INSERT into comandas (mesa, camareroapertura, horaapertura) values ($id_mesa, $id_camarero, $horaapertura);");
$res->execute();
if ($res) {

}
