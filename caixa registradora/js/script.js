// CALCULADORA DO CAIXA

const display = document.getElementById("operacao");

let valorAtual = "";
let primeiroValor = null;
let operador = null;
let esperandoSegundoValor = false;


// ATUALIZAR DISPLAY

function atualizarDisplay() {

    if (valorAtual === "") {
        display.textContent = "0";
    } else {
        display.textContent = valorAtual;
    }

}


// DIGITAR NÚMERO

function adicionarNumero(numero) {

    if (esperandoSegundoValor) {
        valorAtual = "";
        esperandoSegundoValor = false;
    }

    if (valorAtual === "0" && numero === "0") {
        return;
    }

    valorAtual += numero;

    atualizarDisplay();
}


// VÍRGULA

function adicionarVirgula() {

    if (esperandoSegundoValor) {
        valorAtual = "0";
        esperandoSegundoValor = false;
    }

    if (valorAtual.includes(",")) {
        return;
    }

    if (valorAtual === "") {
        valorAtual = "0";
    }

    valorAtual += ",";

    atualizarDisplay();
}


// ESCOLHER OPERADOR

function escolherOperador(novoOperador) {

    if (valorAtual === "" && primeiroValor === null) {
        return;
    }

    if (primeiroValor === null) {
        primeiroValor = converterParaNumero(valorAtual);
    }

    operador = novoOperador;

    esperandoSegundoValor = true;
}


// CONVERTER PARA NÚMERO

function converterParaNumero(valor) {

    return Number(valor.replace(",", "."));
}


// CALCULAR

function calcular() {

    if (
        primeiroValor === null ||
        operador === null ||
        valorAtual === ""
    ) {
        return;
    }

    const segundoValor = converterParaNumero(valorAtual);

    let resultado;

    switch (operador) {

        case "+":

            resultado = primeiroValor + segundoValor;

            break;


        case "−":
        case "-":

            resultado = primeiroValor - segundoValor;

            break;


        case "×":
        case "*":

            resultado = primeiroValor * segundoValor;

            break;


        case "÷":
        case "/":

            if (segundoValor === 0) {

                display.textContent = "Erro";

                limparCalculadora();

                return;
            }

            resultado = primeiroValor / segundoValor;

            break;


        default:

            return;
    }

    resultado = Number(resultado.toFixed(2));

    valorAtual = String(resultado).replace(".", ",");

    primeiroValor = null;

    operador = null;

    esperandoSegundoValor = false;

    atualizarDisplay();
}


// LIMPAR CALCULADORA

function limparCalculadora() {

    valorAtual = "";

    primeiroValor = null;

    operador = null;

    esperandoSegundoValor = false;

    atualizarDisplay();
}


// APAGAR ÚLTIMO NÚMERO

function apagarNumero() {

    if (esperandoSegundoValor) {
        return;
    }

    valorAtual = valorAtual.slice(0, -1);

    atualizarDisplay();
}


// EVENTOS DOS BOTÕES DA CALCULADORA

const botoesCalculadora =
    document.querySelectorAll(".teclado button");


botoesCalculadora.forEach(function (botao) {

    botao.addEventListener("click", function () {

        const valor = botao.textContent.trim();


        if (!isNaN(valor) && valor !== "") {

            adicionarNumero(valor);

            return;
        }


        if (valor === ",") {

            adicionarVirgula();

            return;
        }


        if (
            valor === "+" ||
            valor === "−" ||
            valor === "×" ||
            valor === "÷"
        ) {

            escolherOperador(valor);

            return;
        }


        if (valor === "=") {

            calcular();

            return;
        }


        if (valor === "C") {

            limparCalculadora();

            return;
        }


        if (valor === "←") {

            apagarNumero();

            return;
        }

    });

});


// PRODUTOS

let produtos = [];


// CARREGAR PRODUTOS DO BANCO

async function carregarProdutos() {

    try {

        const resposta = await fetch("php/produtos.php");

        if (!resposta.ok) {
            throw new Error("Erro ao buscar produtos.");
        }

        produtos = await resposta.json();

        console.log("Produtos carregados:", produtos);

    } catch (erro) {

        console.error("Erro ao carregar produtos:", erro);

        alert("Não foi possível carregar os produtos.");

    }

}


// CARRINHO

let carrinho = [];


// ELEMENTOS DO HTML

const campoProduto =
    document.getElementById("produto");

const botaoBuscar =
    document.getElementById("btn-buscar");

const listaProdutos =
    document.getElementById("lista-produtos");

const carrinhoVazio =
    document.getElementById("carrinho-vazio");

const quantidadeItens =
    document.getElementById("quantidade-itens");

const subtotalElemento =
    document.getElementById("subtotal");

const descontoElemento =
    document.getElementById("desconto");

const totalElemento =
    document.getElementById("total");

const valorRecebidoInput =
    document.getElementById("valor-recebido");

const trocoElemento =
    document.getElementById("troco");

const botaoFinalizar =
    document.getElementById("btn-finalizar");


// FORMATAR MOEDA

function formatarMoeda(valor) {

    return valor.toLocaleString("pt-PT", {

        style: "currency",

        currency: "EUR"

    });

}


// BUSCAR PRODUTO

function buscarProduto() {

    const pesquisa =
        campoProduto.value
            .trim()
            .toLowerCase();


    if (pesquisa === "") {
        return;
    }


    const produtoEncontrado =
        produtos.find(function (produto) {

            return (

                produto.nome
                    .toLowerCase()
                    .includes(pesquisa)

                ||

                produto.codigo.toString() === pesquisa

            );

        });


    if (!produtoEncontrado) {

        alert("Produto não encontrado.");

        return;
    }


    adicionarAoCarrinho(produtoEncontrado);

    campoProduto.value = "";

    campoProduto.focus();
}


// ADICIONAR AO CARRINHO

function adicionarAoCarrinho(produto) {

    const produtoNoCarrinho =
        carrinho.find(function (item) {

            return Number(item.id) === Number(produto.id);

        });


    if (produtoNoCarrinho) {

        produtoNoCarrinho.quantidade++;

    } else {

        carrinho.push({

            id: Number(produto.id),

            nome: produto.nome,

            preco: Number(produto.preco),

            quantidade: 1

        });

    }


    atualizarCarrinho();
}


// ATUALIZAR CARRINHO

function atualizarCarrinho() {

    listaProdutos.innerHTML = "";


    if (carrinho.length === 0) {

        carrinhoVazio.style.display = "flex";

    } else {

        carrinhoVazio.style.display = "none";


        carrinho.forEach(function (produto) {

            const linha =
                document.createElement("tr");


            const totalProduto =
                Number(produto.preco) *
                Number(produto.quantidade);


            linha.innerHTML = `

                <td>${produto.nome}</td>

                <td>${produto.quantidade}</td>

                <td>
                    ${formatarMoeda(Number(produto.preco))}
                </td>

                <td>
                    ${formatarMoeda(totalProduto)}
                </td>

                <td>

                    <button
                        type="button"
                        class="btn-remover"
                        data-id="${produto.id}"
                    >
                        Remover
                    </button>

                </td>

            `;


            listaProdutos.appendChild(linha);

        });

    }


    atualizarResumo();

    calcularTroco();
}


// ATUALIZAR RESUMO

function atualizarResumo() {

    let quantidadeTotal = 0;

    let subtotal = 0;


    carrinho.forEach(function (produto) {

        quantidadeTotal +=
            Number(produto.quantidade);


        subtotal +=
            Number(produto.preco) *
            Number(produto.quantidade);

    });


    quantidadeItens.textContent =

        quantidadeTotal === 1

            ? "1 item"

            : `${quantidadeTotal} itens`;


    subtotalElemento.textContent =
        formatarMoeda(subtotal);



    const total = subtotal;



    if (descontoElemento) {

        descontoElemento.textContent =
            formatarMoeda(0);

    }


    totalElemento.textContent =
        formatarMoeda(total);
}


// OBTER TOTAL

function obterTotal() {

    let subtotal = 0;


    carrinho.forEach(function (produto) {

        subtotal +=
            Number(produto.preco) *
            Number(produto.quantidade);

    });


    return subtotal;
}


// CALCULAR TROCO

function calcularTroco() {

    const total =
        obterTotal();


    const valorRecebido =
        Number(valorRecebidoInput.value);


    if (
        isNaN(valorRecebido) ||
        valorRecebido <= 0
    ) {

        trocoElemento.textContent =
            formatarMoeda(0);

        return;
    }


    const troco =
        valorRecebido - total;


    if (troco < 0) {

        trocoElemento.textContent =
            "Valor insuficiente";

        return;
    }


    trocoElemento.textContent =
        formatarMoeda(troco);
}


// REMOVER PRODUTO

function removerDoCarrinho(id) {

    carrinho =
        carrinho.filter(function (produto) {

            return Number(produto.id) !== Number(id);

        });


    atualizarCarrinho();

    calcularTroco();
}


// BOTÃO BUSCAR

if (botaoBuscar) {

    botaoBuscar.addEventListener(
        "click",
        buscarProduto
    );

}


// PESQUISAR COM ENTER

if (campoProduto) {

    campoProduto.addEventListener(
        "keydown",
        function (evento) {

            if (evento.key === "Enter") {

                evento.preventDefault();

                buscarProduto();

            }

        }
    );

}


// BOTÕES DE REMOVER

if (listaProdutos) {

    listaProdutos.addEventListener(
        "click",
        function (evento) {

            if (
                evento.target.classList
                    .contains("btn-remover")
            ) {

                const id =
                    Number(
                        evento.target.dataset.id
                    );


                removerDoCarrinho(id);

            }

        }
    );

}


// VALOR RECEBIDO

if (valorRecebidoInput) {

    valorRecebidoInput.addEventListener(
        "input",
        calcularTroco
    );

}


// FINALIZAR VENDA

if (botaoFinalizar) {

    botaoFinalizar.addEventListener(
        "click",
        async function () {

            const total = obterTotal();

            const valorRecebido =
                Number(valorRecebidoInput.value);



            if (carrinho.length === 0) {

                alert(
                    "Adicione um produto ao carrinho."
                );

                return;
            }



            if (
                isNaN(valorRecebido) ||
                valorRecebido <= 0
            ) {

                alert(
                    "Digite o valor recebido."
                );

                valorRecebidoInput.focus();

                return;
            }



            if (valorRecebido < total) {

                alert(
                    "O valor recebido é insuficiente."
                );

                valorRecebidoInput.focus();

                return;
            }


            try {

                const resposta = await fetch(
                    "php/vendas.php",
                    {
                        method: "POST",

                        headers: {
                            "Content-Type":
                                "application/json"
                        },

                        body: JSON.stringify({

                            produtos: carrinho,

                            valor_recebido:
                                valorRecebido

                        })

                    }
                );


                const resultado =
                    await resposta.json();


                if (!resultado.sucesso) {

                    alert(
                        resultado.mensagem
                    );

                    return;
                }


                // VENDA REALIZADA

                alert(

                    "Venda finalizada!\n\n" +

                    "Venda nº: " +
                    resultado.venda_id +

                    "\n" +

                    "Total: " +
                    formatarMoeda(
                        Number(resultado.total)
                    ) +

                    "\n" +

                    "Valor recebido: " +
                    formatarMoeda(
                        Number(
                            resultado.valor_recebido
                        )
                    ) +

                    "\n" +

                    "Troco: " +
                    formatarMoeda(
                        Number(resultado.troco)
                    )

                );


                // LIMPAR VENDA

                carrinho = [];

                valorRecebidoInput.value = "";

                trocoElemento.textContent =
                    formatarMoeda(0);


                atualizarCarrinho();

                atualizarResumo();


            } catch (erro) {

                console.error(
                    "Erro ao finalizar venda:",
                    erro
                );


                alert(
                    "Não foi possível finalizar a venda."
                );

            }

        }
    );

}

// INICIALIZAR

atualizarDisplay();

atualizarCarrinho();

carregarProdutos();