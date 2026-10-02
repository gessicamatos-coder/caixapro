<?php

require_once "conexao.php";

header("Content-Type: application/json; charset=UTF-8");

try {

    $sql = "SELECT id, nome, codigo, preco, estoque
            FROM produtos
            ORDER BY nome ASC";

    $stmt = $pdo->query($sql);

    $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($produtos);

} catch (PDOException $e) {

    http_response_code(500);

    echo json_encode([
        "erro" => "Erro ao buscar produtos."
    ]);
}