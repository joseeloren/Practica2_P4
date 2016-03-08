<?php
function writeNav() {
    $nav = <<<FIN_NAV
    <!doctype html>
    <html>
        <head>
            <meta charset="utf-8" />
            <link rel="stylesheet" type="text/css" href="../css/estilo.css">
            <link rel="icon" href="img/favicon.ico" type="image/x-icon" />
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
                            <a href="../html/tabla.html">Platos</a>
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
                <form id="login" action="../php/area-privada.php">
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