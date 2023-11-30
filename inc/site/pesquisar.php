<?php
// Verificar se a pesquisa está sendo passada na URL
$valor_pesquisar = isset($_GET['pesquisar']) ? $_GET['pesquisar'] : '';
$valor_pesquisar = mysqli_real_escape_string($conn, $valor_pesquisar);

// Definir a quantidade de produtos por página
$quantidade_pg = 16;

// Verificar a página atual ou atribuir 1 como padrão
$pagina = isset($_GET['pagina']) ? $_GET['pagina'] : 1;

// Calcular o início da visualização
$inicio = ($quantidade_pg * $pagina) - $quantidade_pg;

// Consulta SQL para buscar produtos com base na pesquisa
$query = "SELECT * FROM produtos WHERE descricao LIKE '%$valor_pesquisar%' LIMIT $inicio, $quantidade_pg";
$resultado = mysqli_query($conn, $query);

// Contar o número total de produtos encontrados na pesquisa
$query_total = "SELECT COUNT(*) as total_produtos FROM produtos WHERE descricao LIKE '%$valor_pesquisar%'";
$result_total = mysqli_query($conn, $query_total);
$row_total = mysqli_fetch_assoc($result_total);
$total_produtos = $row_total['total_produtos'];

// Calcular o número de páginas necessárias
$num_pagina = ceil($total_produtos / $quantidade_pg);
?>

<section class="cardapio" id="cardapio">
    <div class="background-cardapio"></div>
    <div class="container">
        <div class="row">
            <div class="col-12 col-one text-center mb-5 wow fadeIn">
                <span class="hint-title"><b>Pesquisando Produtos</b></span>
                <h1 class="title">
                    <b>"Selecionamos produtos ideais para você."</b>
                </h1>
            </div>

            <div class="container" role="main">
                <!-- Exibir produtos encontrados -->
                <div class="row">
                    <?php while ($row_produtos = mysqli_fetch_assoc($resultado)) : ?>
                        <div class="col-sm-6 col-md-3">
                            <div class="thumbnail">
                                <?php
                                $img_path = 'os/' . $row_produtos['img'];
                                $img_src = (file_exists($img_path)) ? $img_path : 'os/assets/produtos/default.jpg';
                                echo '<img src="' . $img_src . '" alt="..." height="200" width="200">';
                                ?>
                                <div class="card-item:hover">
                                    <a href="detalhes.php?id_produtos=<?php echo $row_produtos['idProdutos']; ?>">
                                        <?php echo htmlspecialchars($row_produtos['descricao']); ?>
                                    </a>
                                </div>
                                <a href="cart.php?add_to_cart=<?php echo $row_produtos['idProdutos']; ?>" class="btn btn-white btn-icon-left mt-3" id="btnLigar">
            <span class="icon-left">
              <i class="fa fa-shopping-bag"></i>
            </span>Add a lista         
          </a>
                                
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Paginação -->
<nav aria-label="Paginação">
    <ul class="pagination justify-content-center">
        <?php if ($pagina > 1) : ?>
            <li class="page-item">
                <a class="page-link" href="pesquisar.php?pagina=<?php echo ($pagina - 1); ?>&pesquisar=<?php echo $valor_pesquisar; ?>" aria-label="Anterior">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
        <?php endif; ?>
        <?php for ($i = 1; $i <= $num_pagina; $i++) : ?>
            <li class="page-item <?php echo ($i == $pagina) ? 'active' : ''; ?>">
                <a class="page-link" href="pesquisar.php?pagina=<?php echo $i; ?>&pesquisar=<?php echo $valor_pesquisar; ?>">
                    <?php echo $i; ?>
                </a>
            </li>
        <?php endfor; ?>
        <?php if ($pagina < $num_pagina) : ?>
            <li class="page-item">
                <a class="page-link" href="pesquisar.php?pagina=<?php echo ($pagina + 1); ?>&pesquisar=<?php echo $valor_pesquisar; ?>" aria-label="Próxima">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        <?php endif; ?>
    </ul>
</nav>
