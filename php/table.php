<?php
include_once 'common.php';
$usuario =  $_GET['usuario'];
$estado =  $_GET['estado'];
$id_mesa =  $_GET['id_mesa'];
$id_camarero =  $_GET['id_camarero'];
$db = new PDO("sqlite:../datos.db");
$db->exec('PRAGMA foreign_keys = ON;');
//$res=$db->prepare('SELECT nombre FROM usuarios where usuario=? and clave=?;');
//$res->execute(array($usuario, $md5));
writeNav();
if (strcmp($estado, "Ocupada") == 0) {
    /*
    Añadir peticiones a una comanda
    Eliminar peticiones de una comanda
    Servir peticiones de una comanda
    Cerrar y cobrar una comanda
    */
    $time = time();
    $formi = <<<FIN_HTML
    <form id="login" action="add_comanda.php">
            <input type="hidden" name="id_mesa" value=$id_mesa>
            <input type="hidden" name="id_camarero" value=$id_camarero>
            <input type="hidden" name="horaapertura" value=$time>
            <input class="button" type="submit" value="Comenzar una nueva comanda">
    </form>
FIN_HTML;
    echo $formi;

} else {
    //Comenzar una nueva comanda
    $formi = <<<FIN_HTML
    <form id="login" action="queries.php">
            <input type="hidden" name="usuario" value=$usuario>
            <input class="button" type="submit" value="Comenzar una nueva comanda">
    </form>
FIN_HTML;
    echo $formi;
}
