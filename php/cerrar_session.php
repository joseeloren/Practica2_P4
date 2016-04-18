<?php
    session_start();
    unset($_SESSION['id_usuario']);
    unset($_SESSION['nombre_usuario']);
    unset($_SESSION['tipo_usuario']);
    header('Location: ../php/area-privada.php');
?>
