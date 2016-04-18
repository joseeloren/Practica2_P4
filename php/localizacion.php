
<?php
include_once 'common.php';
writeNav();
$page = <<<FIN_HTML
        <main>
            <section>
                <h2 class="hide">Localización</h2>
                <p id="parrafo" class="center">Nos encontramos en la Calle Bruno Naranjo Díaz nº 7, cerca del
                    SPAR de Tafira.
                </p>
                <figure>
                    <img id="localizacion" src="../img/localizacion.jpg" alt="Mapa con la localización del restaurante marcada"/>
                </figure>
            </section>
             <a id="go-top" href="#body">Ir arriba</a>
        </main>
FIN_HTML;
echo $page;
endPage();