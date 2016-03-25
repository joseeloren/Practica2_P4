<?php
include_once 'common.php';
include_once 'list_show.php';
session_start();
writeNav();
$algo = <<< FIN_HTML
     <form class="clear_both" action="tabla.php">
    <input type="text" name="platito"/>
    <input class="boton_cerrar" type="submit" value="Buscar">
    </form>
FIN_HTML;
echo $algo;
$algo = <<< FIN_HTML
 <main>
            <table>
                <tr>
                	<th>Título</th>
                	<th>PVP</th>
                </tr>
FIN_HTML;
echo $algo;
if (!isset($_GET['platito']))
    $res = select_buscar_plato("");
else
    $res = select_buscar_plato($_GET['platito']);
if($res) {
    foreach($res as $row) {
        $algo = <<< FIN_HTML
                <tr>
                	<td>$row[nombre]</td>
                	<td>$row[pvp]</td>
                </tr>
FIN_HTML;
        echo $algo;
    }
}
$algo = <<< FIN_HTML
            </table>
            <a id="go-top" href="#body">Ir arriba</a>
        </main>
FIN_HTML;
echo $algo;
endPage();

