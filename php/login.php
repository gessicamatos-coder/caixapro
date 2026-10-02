<?php

session_start();

require_once "conexao.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    die("Acesso inválido.");
}

$email = trim($_POST["email"] ?? "");
$senha = $_POST["senha"] ?? "";

if (empty($email) || empty($senha)) {
    die("Preencha o e-mail e a senha.");
}

try {

    $sql = "SELECT id, nome, email, senha, tipo_usuario
            FROM usuarios
            WHERE email = :email
            LIMIT 1";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ":email" => $email
    ]);

    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$usuario || !password_verify($senha, $usuario["senha"])) {
        die("E-mail ou senha incorretos.");
    }

    $_SESSION["usuario_id"] = $usuario["id"];
    $_SESSION["usuario_nome"] = $usuario["nome"];
    $_SESSION["usuario_email"] = $usuario["email"];
    $_SESSION["tipo_usuario"] = $usuario["tipo_usuario"];

    header("Location: ../caixa.php");
    exit;

} catch (PDOException $e) {

    die("Erro ao realizar login.");
}