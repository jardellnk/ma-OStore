<?php
include_once("conexao.php");

$query_emitente = "SELECT * FROM emitente";
$exec_query_emitente = mysqli_query($conn, $query_emitente);
$row_emitente = mysqli_fetch_assoc($exec_query_emitente);
?>


<meta charset="utf-8" />
<section class="header">
    <div class="container">
        <nav class="navbar navbar-expand-lg pl-0 pr-0 col-one">
            <a class="navbar-brand wow fadeIn" href="./">
                <img src="<?php echo $row_emitente['url_logo'] ?>" width="160" class="img-logo" alt="Logo da Empresa">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown">
                <span class="navbar-toggler-icon">
                    <i class="fas fa-bars"></i>
                </span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav ml-auto mr-auto wow fadeIn">
                    <!-- Adicione itens de navegação aqui -->
                </ul>
                <a class="btn btn-white btn-sm" id="openCartModal">
                    <i class="fa fa fa-shopping-bag"></i>
                    <?php
                    // Exibir a quantidade total de itens no carrinho no botão
                    echo ($quantidadeItensNoCarrinho > 0) ? "<span class='badge'>$quantidadeItensNoCarrinho</span>" : "";
                    ?>
                </a>

                <a class="btn btn-yellow btn-sm" id="openModal">
                    <i class="fa fa-search"></i>
                </a>
            </div>
        </nav>
    </div>
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <form role="search" method="GET" action="pesquisar.php">
                <input type="text" name="pesquisar" class="form-control" id="pesquisar" placeholder="O que deseja procurar?" aria-label="Search" />
            </form>
        </div>
    </div>

    <div id="cartModal" class="modal">
        <div class="modal-full">
            <span class="closeCartModal">&times;</span>
            <?php include_once("cart.php"); ?>
        </div>
    </div>
</section>

<script>
    // Função para abrir o modal ao clicar no ícone de busca
    document.getElementById("openModal").addEventListener("click", function () {
        document.getElementById("myModal").style.display = "block";
    });

    // Função para fechar o modal ao clicar no botão de fechar (X)
    document.getElementsByClassName("close")[0].addEventListener("click", function () {
        document.getElementById("myModal").style.display = "none";
    });

    // Função para abrir o modal ao clicar no ícone de carrinho
    document.getElementById("openCartModal").addEventListener("click", function () {
        document.getElementById("cartModal").style.display = "block";
    });

    // Função para fechar o modal ao clicar no botão de fechar (X)
    document.getElementsByClassName("closeCartModal")[0].addEventListener("click", function () {
        document.getElementById("cartModal").style.display = "none";
    });
</script>
