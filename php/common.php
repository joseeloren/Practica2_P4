<?php
function writeNav() {
    $nav = <<<FIN_NAV
    <!doctype html>
    <html>
        <head>
            <meta charset="utf-8" />
            <link rel="stylesheet" type="text/css" href="../css/estilo.css">
            <link rel="icon" href="../img/favicon.ico" type="image/x-icon" />
            <script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
            <script src="../js/comenzarElaboracion.js">
            </script>
            <script src="../js/scripts.js"></script>
            <script src="../js/buscar-plato.js"></script>
            <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
            <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
            <title>Restaurante José</title>
        </head>
        <body id="body">
            <div id="float-bg">
            <header>
                <h1>Restaurante José</h1>
                <nav>
                    <ul>
                        <li>
                            <a href="../index.html">Inicio</a>
                        </li>
                        <li>
                            <a href="../php/tabla.php">Platos</a>
                        </li>
                        <li>
                            <a href="../html/localizacion.html">Localización</a>
                        </li>
                        <li>
                            <a href="../php/area-privada.php">Área Privada</a>
                        </li>
                    </ul>
                </nav>
            </header>
FIN_NAV;
    echo $nav;
}

function endPage() {
    $name = <<<FIN_HTML
    </div>
    </body>
    </html>
FIN_HTML;
    echo $name;
}

function writeBadLogin() {
    writeLoginBegin();
    echo '<p>Nombre o clave incorrecta, vuelva a intentarlo</p>';
    writeLoginEnd();
}

function writeLogin() {
    writeLoginBegin();
    writeLoginEnd();
}

function writeLoginBegin() {
    $html = <<<FIN_HTML
        <main>
            <section>
                <form id="login" method="post" action="../php/area-privada.php">
                    <p>Usuario:</p>
                    <input type="text" name="usuario"><br>
                    <p>Clave:</p>
                    <input type="password" name="clave"><br><br>
                    <input class="button" type="submit" value="Identificarse">
                </form>
FIN_HTML;
    echo $html;
}


function writeLoginEnd() {
    $html = <<<FIN_HTML
    <a id="go-top" href="#body">Ir arriba</a>
            </section>
        </main>
        </div>
    </body>
</html>
FIN_HTML;
    echo $html;

}

function escribir_bienvenida($nombre_usuario) {
    echo "<div id=\"saludo_cerrar\"><p id=\"saludo_login\">¡Bienvenido $nombre_usuario!</p><a id=\"cerrar_session\" href=\"cerrar_session.php\">Cerrar sesión</a></div>";
}
