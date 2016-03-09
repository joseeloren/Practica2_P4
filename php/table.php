<?php
include_once 'common.php';
include_once 'database.php';
include_once 'ocupada.php';
writeNav();
if (strcmp($_GET['estado'], "Ocupada") == 0) {
    /*
    Eliminar peticiones de una comanda
    Servir peticiones de una comanda
    Cerrar y cobrar una comanda
    */
    combobox_articulos();
    //Añadir peticiones a una comanda
    //<!--input type="hidden" value=$_GET[id_comanda]-->
    $formi = <<<FIN_HTML
   <form id="login" action="area-privada.php" id="lineacomanda">

    <input class="button" type="submit" value="Añadir petición">
    </form>

FIN_HTML;
    echo $formi;
    //Eliminar peticiones de una comanda
    borrar_servir_comanda($_GET['id_mesa']);
} else {
    //Comenzar una nueva comanda
    $formi = <<<FIN_HTML
    <form id="login" action="add_comanda.php">
            <input type="hidden" name="id_mesa" value=$_GET[id_mesa]>
            <input class="button" type="submit" value="Nueva comanda">
    </form>
FIN_HTML;
    echo $formi;
}
