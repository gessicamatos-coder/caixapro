<?php

require_once "conexao.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    die("Acesso inválido.");
}

$nome = trim($_POST["nome"] ?? "");
$email = trim($_POST["email"] ?? "");
$senha = $_POST["senha"] ?? "";
$confirmarSenha = $_POST["confirmar-senha"] ?? "";
$tipoUsuario = $_POST["tipo-usuario"] ?? "";

if (
    empty($nome) ||
    empty($email) ||
    empty($senha) ||
    empty($confirmarSenha) ||
    empty($tipoUsuario)
) {
    die("Preencha todos os campos.");
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("Digite um e-mail válido.");
}

if ($senha !== $confirmarSenha) {
    die("As senhas não coincidem.");
}

if (!in_array($tipoUsuario, ["admin", "caixa"])) {
    die("Tipo de usuário inválido.");
}

$senhaHash = password_hash($senha, PASSWORD_DEFAULT);

try {

    $sql = "INSERT INTO usuarios
            (nome, email, senha, tipo_usuario)
            VALUES
            (:nome, :email, :senha, :tipo_usuario)";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ":nome" => $nome,
        ":email" => $email,
        ":senha" => $senhaHash,
        ":tipo_usuario" => $tipoUsuario
    ]);

    header("Location: ../index.html?cadastro=sucesso");
    exit;

} catch (PDOException $e) {

    if ($e->getCode() == 23000) {
        die("Este e-mail já está cadastrado.");
    }

    die("Erro ao cadastrar usuário.");
}