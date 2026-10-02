<?php

session_start();

if (!isset($_SESSION["usuario_id"])) {

    header("Location: ../index.html");
    exit;

}

if ($_SESSION["tipo_usuario"] !== "admin") {

    http_response_code(403);

    die("Acesso negado. Apenas administradores podem acessar esta área.");

}