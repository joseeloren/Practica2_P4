<?php
include_once 'common.php';
include_once 'list_show.php';
session_start();
writeNav();
$algo = <<< FIN_HTML
    <div id="center_form">
     <form action="tabla.php">
    <input type="text" id="buscador" name="platito" placeholder="Buscar..."/>
    </form>
    </div>
FIN_HTML;
echo $algo;
$algo = <<< FIN_HTML
 <main>
            <table id="productos">
                <tr>
                	<th>Título</th>
                	<th>PVP</th>
                </tr>
FIN_HTML;
echo $algo;
$res = select_buscar_plato("");
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
        </main>
FIN_HTML;
echo $algo;
endPage();

