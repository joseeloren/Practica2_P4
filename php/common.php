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
                            <a href="../html/area-privada.html">Área Privada</a>
                        </li>
                    </ul>
                </nav>
            </header>
FIN_NAV;
    echo $nav;
}

function writeBadLogin() {
$html = <<<FIN_HTML
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
                        <a href="index.html">Inicio</a>
                    </li>
                    <li>
                        <a href="tabla.html">Platos</a>
                    </li>
                    <li>
                        <a href="localizacion.html">Localización</a>
                    </li>
                    <li>
                        <a href="area-privada.html">Área Privada</a>
                    </li>
                </ul>
            </nav>
        </header>
        <main>
            <section>
                <form id="login" action="../php/login.php">
                    <p>Usuario:</p>
                    <input type="text" name="usuario"><br>
                    <p>Clave:</p>
                    <input type="password" name="clave"><br><br>
                    <input class="button" type="submit" value="Identificarse">
                </form>
                <p>Nombre o clave incorrecta, vuelva a intentarlo</p>
                <a id="go-top" href="#body">Ir arriba</a>
            </section>
        </main>
        </div>
    </body>
</html>
FIN_HTML;
    echo $html;
}
