<?php

require_once "php/proteger_admin.php";

?>

<!DOCTYPE html>
<html lang="pt">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>CaixaPro - Administração</title>

    <link
        rel="stylesheet"
        href="css/style.css"
    >

</head>

<body>

    <main class="admin-container">

        <section class="admin-box">

            <div class="logo">

                <h1>CaixaPro</h1>

                <p>
                    Área Administrativa
                </p>

            </div>


            <div class="admin-info">

                <p>
                    Administrador:
                    <strong>
                        <?= htmlspecialchars($_SESSION["usuario_nome"]) ?>
                    </strong>
                </p>

            </div>


            <hr>


            <!-- CADASTRAR PRODUTO -->

            <h2>Cadastrar produto</h2>

            <form
                action="php/admin_produtos.php"
                method="POST"
            >

                <input
                    type="hidden"
                    name="acao"
                    value="cadastrar"
                >


                <div class="form-group">

                    <label for="nome">
                        Nome do produto
                    </label>

                    <input
                        type="text"
                        id="nome"
                        name="nome"
                        placeholder="Ex: Coca-Cola"
                        required
                    >

                </div>


                <div class="form-group">

                    <label for="codigo">
                        Código
                    </label>

                    <input
                        type="text"
                        id="codigo"
                        name="codigo"
                        placeholder="Ex: 1005"
                        required
                    >

                </div>


                <div class="form-group">

                    <label for="preco">
                        Preço
                    </label>

                    <input
                        type="number"
                        id="preco"
                        name="preco"
                        step="0.01"
                        min="0"
                        placeholder="0.00"
                        required
                    >

                </div>


                <div class="form-group">

                    <label for="estoque">
                        Estoque inicial
                    </label>

                    <input
                        type="number"
                        id="estoque"
                        name="estoque"
                        min="0"
                        placeholder="0"
                        required
                    >

                </div>


                <button
                    type="submit"
                    class="btn-cadastro"
                >
                    Cadastrar produto
                </button>

            </form>


            <hr>


            <!-- PRODUTOS -->

            <h2>Produtos cadastrados</h2>

            <?php

            require_once "php/conexao.php";

            $sql = "SELECT id, nome, codigo, preco, estoque
                    FROM produtos
                    ORDER BY nome ASC";

            $stmt = $pdo->query($sql);

            $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

            ?>


            <div class="tabela-produtos">

                <table>

                    <thead>

                        <tr>

                            <th>Nome</th>

                            <th>Código</th>

                            <th>Preço</th>

                            <th>Estoque</th>

                            <th>Ação</th>

                        </tr>

                    </thead>


                    <tbody>

                        <?php foreach ($produtos as $produto): ?>

                            <tr>

                                <td>
                                    <?= htmlspecialchars($produto["nome"]) ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($produto["codigo"]) ?>
                                </td>

                                <td>
                                    € <?= number_format(
                                        $produto["preco"],
                                        2,
                                        ",",
                                        "."
                                    ) ?>
                                </td>

                                <td>
                                    <?= $produto["estoque"] ?>
                                </td>

                                <td>

                                    <form
                                        action="php/admin_produtos.php"
                                        method="POST"
                                    >

                                        <input
                                            type="hidden"
                                            name="acao"
                                            value="excluir"
                                        >

                                        <input
                                            type="hidden"
                                            name="id"
                                            value="<?= $produto["id"] ?>"
                                        >

                                        <button
                                            type="submit"
                                            class="btn-remover"
                                        >
                                            Excluir
                                        </button>

                                    </form>

                                </td>

                            </tr>

                        <?php endforeach; ?>

                    </tbody>

                </table>

            </div>


            <hr>


            <div class="admin-links">

                <a href="caixa.php">
                    Voltar para o caixa
                </a>

            </div>

        </section>

    </main>


    <footer>

        <p>
            CaixaPro &copy; 2026
        </p>

    </footer>

</body>

</html>