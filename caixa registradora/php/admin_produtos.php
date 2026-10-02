<?php

require_once "proteger_admin.php";
require_once "conexao.php";


if ($_SERVER["REQUEST_METHOD"] !== "POST") {

    header("Location: ../admin.php");
    exit;

}


$acao = $_POST["acao"] ?? "";


try {


    // CADASTRAR PRODUTO

    if ($acao === "cadastrar") {

        $nome = trim($_POST["nome"] ?? "");
        $codigo = trim($_POST["codigo"] ?? "");
        $preco = (float) ($_POST["preco"] ?? 0);
        $estoque = (int) ($_POST["estoque"] ?? 0);


        if (
            $nome === "" ||
            $codigo === "" ||
            $preco < 0 ||
            $estoque < 0
        ) {

            die("Dados do produto inválidos.");

        }


        $sql = "INSERT INTO produtos
                (nome, codigo, preco, estoque)
                VALUES
                (:nome, :codigo, :preco, :estoque)";


        $stmt = $pdo->prepare($sql);


        $stmt->execute([

            ":nome" => $nome,

            ":codigo" => $codigo,

            ":preco" => $preco,

            ":estoque" => $estoque

        ]);


        header("Location: ../admin.php");
        exit;

    }


    // EXCLUIR PRODUTO

    if ($acao === "excluir") {

        $id = (int) ($_POST["id"] ?? 0);


        if ($id <= 0) {

            die("Produto inválido.");

        }


        $sql = "DELETE FROM produtos
                WHERE id = :id";


        $stmt = $pdo->prepare($sql);


        $stmt->execute([

            ":id" => $id

        ]);


        header("Location: ../admin.php");
        exit;

    }


    die("Ação inválida.");


} catch (PDOException $e) {


    if ($e->getCode() == 23000) {

        die(
            "Não foi possível realizar a operação. " .
            "O código do produto pode já estar cadastrado."
        );

    }


    die(
        "Erro ao realizar operação no produto."
    );

}