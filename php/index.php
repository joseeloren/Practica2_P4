<?php
include_once 'common.php';
writeNav();
$page = <<<FIN_HTML
<main>
            <section>
                <h2 class="hide">Introducción</h2>
                <p id="parrafo">En restaurante José tendrá un servicio familiar y acogedor.
                Servimos toda clase de platos de la gastronomía canaria. Realizamos
                todo tipo de eventos. Además, realizamos actividades cada fin de semana
                para todos los clientes. Será una experiencia inolvidable.
                </p>
                <figure id="img1">
                    <figcaption class="hide">Entrada</figcaption>
                    <img class="foto" src="../img/principal.jpg" alt="Restaurante luminoso con mesas"/>
                </figure>
                <figure id="img2">
                    <figcaption class="hide">Salón de eventos</figcaption>
                    <img class="foto" src="../img/principal2.jpg" alt="Restaurante con muchas mesas"/>
                </figure>
                <figure id="img3">
                    <figcaption class="hide">Sala principal</figcaption>
                    <img class="foto" src="../img/principal3.jpg" alt="Restaurante muy luminoso con gente sentada"/>
                </figure>
                <div id="dummy-image"></div>
            </section>
        </main>

FIN_HTML;
echo $page;
endPage();
