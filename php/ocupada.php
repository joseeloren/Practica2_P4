<?php
include_once 'queries.php';
function combobox_articulos() {
    echo '<select id="login" style="float:left;margin:0;margin-top:25px" name="articulo" form="lineacomanda">';
    $res = select_articulos();
    if ($res) {
        $res->setFetchMode(PDO::FETCH_NAMED);
        foreach($res as $row)
            echo "<option value=\"$row[id]\">$row[nombre]</option>";
    }
      echo '</select>';
}

function borrar_servir_comanda($id_mesa) {


    $res = select_lineascomanda($id_mesa);
    if($res){
        $res->setFetchMode(PDO::FETCH_NAMED);
        echo '<form class="table" method="post" action="algo.php">';
        echo "<div class=\"tr\">\n";
        echo "<div class=\"th\">Producto</div>";
        echo "<div class=\"th\">Servir</div>";
        echo "<div class=\"th\">Eliminar</div>";
        echo "</div>";


        foreach($res as $row){
            $enlace = <<<FIN_HTML
            <div class="tr">
        <div class="td">$row[nombre]</div>
        <input class="td" type="radio" name="$row[id]_opcion" value="$row[id]_servir"/>
        <input class="td" type="radio" name="$row[id]_opcion" value="$row[id]_eliminar"/>
        </div>
FIN_HTML;
            echo $enlace;

        }
        echo '</form>';

    }
    echo '</table>';
}
