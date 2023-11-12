<?php
// Verificar se está sendo passado na URL a página atual, senão é atribuída a página 1
$pagina = isset($_GET['pagina']) ? $_GET['pagina'] : 1;
// Definir a quantidade de produtos por página
$quantidade_pg = 30;
// Calcular o início da visualização
$inicio = ($quantidade_pg * $pagina) - $quantidade_pg;
// Consulta para selecionar os produtos a serem apresentados na página
$query_produtos = "SELECT * FROM produtos LIMIT $inicio, $quantidade_pg";
$resultado_produtos = mysqli_query($conn, $query_produtos);
// Obter o número total de produtos
$query_total_produtos = "SELECT COUNT(*) as total_produtos FROM produtos";
$result_total_produtos = mysqli_query($conn, $query_total_produtos);
$row_total_produtos = mysqli_fetch_assoc($result_total_produtos);
$total_produtos = $row_total_produtos['total_produtos'];
$num_pagina = ceil($total_produtos / $quantidade_pg);
?>

<section class="cardapio" id="cardapio">
    <div class="background-cardapio"></div>
        <div class="container">
            <div class="row">
                <div class="col-12 col-one text-center mb-5 wow fadeIn">
                    <span class="hint-title"><b>Produtos</b></span>
                    <h1 class="title">
                        <b>Conheça alguns de nossos produtos</b>
                    </h1>
                </div>

                <div class="col-12 col-one">
                    <div class="row">
                        
                        <?php while ($row_produtos = mysqli_fetch_assoc($resultado_produtos)) { ?>
                            <div class="col-sm-4 ">
                            
                            <div class="card mt-4">
                            <div class="thumbnail">


                            
                                
                                    <?php
                                    $img_path = 'assets/img/produtos/' . $row_produtos['img'];
                                    if (!empty($row_produtos['img']) && file_exists($img_path)) {
                                        echo '<img src="' . $img_path . '" alt="..." height="200" width="200">';
                                    } else {
                                        echo '<img src="assets/img/produtos/default.jpg" alt="..." height="200" width="200">';
                                    }
                                    ?>
                                    <p><div class="card-body">
                                        <a href="detalhes.php?id_produtos=<?php echo $row_produtos['idProdutos']; ?>">
                                        <?php echo $row_produtos['descricao']; ?><br><?php /*echo 'Apartir de R$ '  . $row_produtos['precoVenda'] */; ?><br><br>
                                        </a>
                                        <a href="cart.php?add_to_cart=<?php echo $row_produtos['idProdutos']; ?>" class="btn btn-white btn-icon-left mt-3" id="btnLigar">
            <span class="icon-left">
              <i class="fa fa-shopping-bag"></i>
            </span>Add ao carrinho          
          </a>
                                    </div></p>
                                </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</section>

<?php
// Verificar a página anterior e posterior
$pagina_anterior = $pagina - 1;
$pagina_posterior = $pagina + 1;
?>

        <nav aria-label="">
            <ul class="pagination justify-content-center">
                <li class="page-item">
                    <?php if ($pagina_anterior != 0) { ?>
                        <a class="page-link" href="produtos.php?pagina=<?php echo $pagina_anterior; ?>" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    <?php } else { ?>
                        <span class="page-link" aria-hidden="true">&laquo;</span>
                    <?php } ?>
                </li>

                <?php
                // Apresentar a paginação
                for ($i = 1; $i <= $num_pagina; $i++) {
                    ?>
                    <li class="page-item">
                        <a class="page-link" href="produtos.php?pagina=<?php echo $i; ?>">
                            <?php echo $i; ?>
                        </a>
                    </li>
                <?php } ?>

                <li class="page-item">
                    <?php if ($pagina_posterior <= $num_pagina) { ?>
                        <a class="page-link" href="produtos.php?pagina=<?php echo $pagina_posterior; ?>" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    <?php } else { ?>
                        <span class="page-link" aria-hidden="true">&raquo;</span>
                    <?php } ?>
                </li>
            </ul>
        </nav>        
