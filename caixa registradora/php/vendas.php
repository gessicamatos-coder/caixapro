<?php

session_start();

require_once "conexao.php";

header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);

    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Método não permitido."
    ]);

    exit;
}


// Verificar se existe usuário logado

if (!isset($_SESSION["usuario_id"])) {

    http_response_code(401);

    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Usuário não está logado."
    ]);

    exit;
}


$dados = json_decode(
    file_get_contents("php://input"),
    true
);


if (!$dados) {

    http_response_code(400);

    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Dados da venda inválidos."
    ]);

    exit;
}


$produtos = $dados["produtos"] ?? [];

$valorRecebido = (float) ($dados["valor_recebido"] ?? 0);


if (empty($produtos)) {

    http_response_code(400);

    echo json_encode([
        "sucesso" => false,
        "mensagem" => "O carrinho está vazio."
    ]);

    exit;
}


if ($valorRecebido <= 0) {

    http_response_code(400);

    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Valor recebido inválido."
    ]);

    exit;
}


try {

    $pdo->beginTransaction();


    // CALCULAR TOTAL

    $total = 0;

    $produtosBanco = [];


    foreach ($produtos as $item) {

        $produtoId = (int) $item["id"];

        $quantidade = (int) $item["quantidade"];


        if ($quantidade <= 0) {
            throw new Exception("Quantidade inválida.");
        }


        // Buscar produto no banco

        $sql = "SELECT id, nome, preco, estoque
                FROM produtos
                WHERE id = :id
                FOR UPDATE";

        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            ":id" => $produtoId
        ]);


        $produto = $stmt->fetch(PDO::FETCH_ASSOC);


        if (!$produto) {

            throw new Exception(
                "Produto não encontrado."
            );

        }


        // Verificar estoque

        if ($produto["estoque"] < $quantidade) {

            throw new Exception(
                "Estoque insuficiente para: " .
                $produto["nome"]
            );

        }


        $preco = (float) $produto["preco"];

        $total += $preco * $quantidade;


        $produtosBanco[] = [

            "id" => $produtoId,

            "quantidade" => $quantidade,

            "preco" => $preco

        ];

    }


    // VERIFICAR PAGAMENTO

    if ($valorRecebido < $total) {

        throw new Exception(
            "Valor recebido insuficiente."
        );

    }


    $troco =
        $valorRecebido - $total;


    // CRIAR VENDA

    $sql = "INSERT INTO vendas
            (
                usuario_id,
                total,
                valor_recebido,
                troco
            )
            VALUES
            (
                :usuario_id,
                :total,
                :valor_recebido,
                :troco
            )";


    $stmt = $pdo->prepare($sql);


    $stmt->execute([

        ":usuario_id" =>
            $_SESSION["usuario_id"],

        ":total" =>
            $total,

        ":valor_recebido" =>
            $valorRecebido,

        ":troco" =>
            $troco

    ]);


    $vendaId =
        $pdo->lastInsertId();


    // INSERIR ITENS DA VENDA

    $sqlItem = "INSERT INTO itens_venda
                (
                    venda_id,
                    produto_id,
                    quantidade,
                    preco
                )
                VALUES
                (
                    :venda_id,
                    :produto_id,
                    :quantidade,
                    :preco
                )";


    $stmtItem =
        $pdo->prepare($sqlItem);


    // ATUALIZAR ESTOQUE

    $sqlEstoque = "UPDATE produtos
                   SET estoque = estoque - :quantidade
                   WHERE id = :id";


    $stmtEstoque =
        $pdo->prepare($sqlEstoque);


    foreach ($produtosBanco as $item) {

        $stmtItem->execute([

            ":venda_id" =>
                $vendaId,

            ":produto_id" =>
                $item["id"],

            ":quantidade" =>
                $item["quantidade"],

            ":preco" =>
                $item["preco"]

        ]);


        $stmtEstoque->execute([

            ":quantidade" =>
                $item["quantidade"],

            ":id" =>
                $item["id"]

        ]);

    }


    // FINALIZAR TRANSAÇÃO

    $pdo->commit();


    echo json_encode([

        "sucesso" => true,

        "mensagem" =>
            "Venda realizada com sucesso.",

        "venda_id" =>
            $vendaId,

        "total" =>
            $total,

        "valor_recebido" =>
            $valorRecebido,

        "troco" =>
            $troco

    ]);


} catch (Exception $e) {

    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }


    http_response_code(400);


    echo json_encode([

        "sucesso" => false,

        "mensagem" =>
            $e->getMessage()

    ]);

}