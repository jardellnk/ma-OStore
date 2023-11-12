<?php
$pagina = (isset($_GET['pagina']) && is_numeric($_GET['pagina'])) ? $_GET['pagina'] : 1;
$quantidade_pg = 8;
$result_produtos = "SELECT * FROM produtos ORDER BY RAND() LIMIT " . ($quantidade_pg * ($pagina - 1)) . ", $quantidade_pg";
$resultado_produtos = mysqli_query($conn, $result_produtos);
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
            <div class="col-12 col-one" >
                <div class="row">
                    <?php while ($rows_produtos = mysqli_fetch_assoc($resultado_produtos)) { ?>
                        <div class="col-sm-4 col-md-3" >
                            <?php
                            if ($rows_produtos['img'] === null) {
                                $img_src = 'assets/img/produtos/produtos.jpg';
                            } else {
                                $img_path = 'assets/img/produtos/' . $rows_produtos['img'];

                                if (empty($rows_produtos['img']) || !file_exists($img_path)) {
                                    $img_src = 'assets/img/produtos/produtos.jpg';
                                } else {
                                    $img_src = $img_path;
                                }
                            }
                            ?>
                            <img src="<?php echo $img_src; ?>" alt="Product Image" height="200" width="200">
                            <div class="card-item:hover">
                                <a href="detalhes.php?id_produtos=<?php echo $rows_produtos['idProdutos']; ?>">
                                    <?php echo $rows_produtos['descricao']; ?>
                                </a>
                                <a href="cart.php?add_to_cart=<?php echo $rows_produtos['idProdutos']; ?>" class="btn btn-white btn-icon-left mt-3" id="btnLigar">
            <span class="icon-left">
              <i class="fa fa-shopping-bag"></i>
            </span>Add ao carrinho          
          </a>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <div class="col-12 col-one text-center wow fadeInUp">
                <a id="btnVerMais" class="btn btn-white btn-sm" href="produtos.php">Ver mais produtos</a>
            </div>
        </div>
    </div>
</section>
