<?php
include_once 'common.php';
include_once 'database.php';
writeNav();
if (strcmp($_GET['estado'], "Ocupada") == 0) {
    /*
    Añadir peticiones a una comanda
    Eliminar peticiones de una comanda
    Servir peticiones de una comanda
    Cerrar y cobrar una comanda
    */
    $formi = <<<FIN_HTML
    <form id="login" action="add_comanda.php">
            <input type="hidden" name="id_mesa" value=$_GET[id_mesa]>
            <input type="hidden" name="id_camarero" value=$_GET[id_usuario]>
            <input type="hidden" name="horaapertura" value=$time>
            <input class="button" type="submit" value="Test">
    </form>
FIN_HTML;
    echo $formi;

} else {
    //Comenzar una nueva comanda
    $formi = <<<FIN_HTML
    <form id="login" action="add_comanda.php">
            <input type="hidden" name="id_mesa" value=$_GET[id_mesa]>
            <input type="hidden" name="id_camarero" value=$_GET[id_usuario]>
            <input type="hidden" name="nombre_usuario" value=$_GET[nombre_usuario]>
            <input type="hidden" name="usuario" value=$_GET[usuario]>
            <input type="hidden" name="rol" value=$_GET[rol]>
            <input class="button" type="submit" value="Comenzar una nueva comanda">
    </form>
FIN_HTML;
    echo $formi;
}
