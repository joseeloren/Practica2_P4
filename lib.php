<?php
function writeNav() {
    $nav = <<<FIN_NAV
    <!doctype html>
    <html>
        <head>
            <meta charset="utf-8" />
            <link rel="stylesheet" type="text/css" href="../estilos.css">
            <link rel="icon" href="../img/favicon.ico" type="image/x-icon" />
            <script src="../jquery-1.12.3.min.js"></script>
            <script src="../scripts.js"></script>
            <title>Restaurante José</title>
        </head>
        <body id="body">
            <div id="float-bg">
            <header>
                <h1>Restaurante</h1>
                <nav>
                    <ul>
                        <li>
                            <a href="../php/index.php">Inicio</a>
                        </li>
                        <li>
                            <a href="../php/tabla.php">Platos</a>
                        </li>
                        <li>
                            <a href="../php/localizacion.php">Localización</a>
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
                    <input id="user" type="text" name="usuario"><br>
                    <p>Clave:</p>
                    <input id="pass" type="password" name="clave"><br><br>
                    <input id="identifi" class="button" type="submit" value="Identificarse">
                </form>
FIN_HTML;
    echo $html;
}


function writeLoginEnd() {
    $html = <<<FIN_HTML
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
