<?php

require_once "php/proteger.php";

?>
<?php if ($_SESSION["tipo_usuario"] === "admin"): ?>

    <a href="admin.php">
        Administração
    </a>

<?php endif; ?>



<!DOCTYPE html>
<html lang="pt">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>CaixaPro - Sistema de Caixa</title>

    <link rel="stylesheet" href="css/style.css">

</head>

<body>

    <header class="cabecalho">

        <div class="logo">
            <h1>CaixaPro</h1>
            <span>Sistema de Caixa</span>
        </div>

        <div class="informacoes-caixa">

            <span>Caixa #01</span>

           <span>
    Operador:
    <?= htmlspecialchars($_SESSION["usuario_nome"]) ?>
</span>
        </div>

    </header>


    <main class="caixa-container">


       

        <section class="area-venda">


        

            <div class="busca-produto">

                <input
                    type="text"
                    id="produto"
                    placeholder="Buscar produto ou código de barras..."
                >

                <button
                    type="button"
                    id="btn-buscar"
                >
                    Buscar
                </button>

            </div>


            

            <div class="carrinho">

                <div class="carrinho-header">

                    <h2>Produtos</h2>

                    <span id="quantidade-itens">
                        0 itens
                    </span>

                </div>


                <table>

                    <thead>

                        <tr>

                            <th>Produto</th>

                            <th>Quantidade</th>

                            <th>Preço</th>

                            <th>Total</th>

                            <th>Ações</th>

                        </tr>

                    </thead>


                    <tbody id="lista-produtos">

                     

                    </tbody>

                </table>


                <div class="carrinho-vazio" id="carrinho-vazio">

                    <p>Nenhum produto adicionado</p>

                </div>

            </div>


        </section>


       

        <aside class="painel-caixa">


           

            <div class="resumo">

                <h2>Resumo da venda</h2>


                <div class="linha-resumo">

                    <span>Subtotal</span>

                    <span id="subtotal">
                        € 0,00
                    </span>

                </div>


                <div class="linha-resumo">

                    <span>Desconto</span>

                    <span id="desconto">
                        € 0,00
                    </span>

                </div>


                <div class="linha-total">

                    <span>Total</span>

                    <strong id="total">
                        € 0,00
                    </strong>

                </div>

            </div>


          

            <div class="calculadora">

                <div class="display-calculadora">

                    <span id="operacao">
                        0
                    </span>

                </div>


              

                <div class="teclado">

                    <button type="button">7</button>
                    <button type="button">8</button>
                    <button type="button">9</button>
                    <button type="button" class="tecla-operacao">÷</button>


                    <button type="button">4</button>
                    <button type="button">5</button>
                    <button type="button">6</button>
                    <button type="button" class="tecla-operacao">×</button>


                    <button type="button">1</button>
                    <button type="button">2</button>
                    <button type="button">3</button>
                    <button type="button" class="tecla-operacao">−</button>


                    <button
                        type="button"
                        class="tecla-zero"
                    >
                        0
                    </button>

                    <button type="button">00</button>

                    <button type="button">,</button>

                    <button
                        type="button"
                        class="tecla-operacao"
                    >
                        +
                    </button>


                    <button
                        type="button"
                        class="tecla-limpar"
                    >
                        C
                    </button>

                    <button
                        type="button"
                        class="tecla-apagar"
                    >
                        ←
                    </button>

                    <button
                        type="button"
                        class="tecla-igual"
                    >
                        =
                    </button>

                </div>

            </div>


          

            <div class="pagamento">

                <h2>Pagamento</h2>


                <div class="valor-recebido">

                    <label for="valor-recebido">
                        Valor recebido
                    </label>

                    <input
                        type="number"
                        id="valor-recebido"
                        placeholder="€ 0,00"
                        step="0.01"
                    >

                </div>


                <div class="troco">

                    <span>Troco</span>

                    <strong id="troco">
                        € 0,00
                    </strong>

                </div>


                <button
                    type="button"
                    class="btn-finalizar"
                    id="btn-finalizar"
                >
                    Finalizar venda
                </button>

            </div>


        </aside>

    </main>


    <footer>

        <p>
            CaixaPro &copy; 2026
        </p>

    </footer>


    <script src="js/script.js"></script>

</body>

</html>