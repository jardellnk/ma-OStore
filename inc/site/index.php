<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8" />
    <title>Produtos</title>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>

<body>

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
                <div class="col-12 col-one">
                    <div class="container">
                        <div class="row justify-content-around">
                            <?php while ($row_produtos = mysqli_fetch_assoc($resultado_produtos)) : ?>
                                <div class="col-sm-4 col-md-3 mb-4">
                                    <?php
                                    $img_src = empty($row_produtos['img']) || !file_exists('os/' . $row_produtos['img']) ? 'os/assets/produtos/produtos.jpg' : 'os/' . $row_produtos['img'];
                                    ?>

                                    <div class="card text-center">
                                        <a href="detalhes.php?id_produtos=<?php echo $row_produtos['idProdutos']; ?>">
                                            <img src="<?php echo $img_src; ?>" alt="Product Image" class="mx-auto d-block" style="max-width: 100%; max-height: 100%;" height="200" width="200">
                                        </a>

                                        <a href="detalhes.php?id_produtos=<?php echo $row_produtos['idProdutos']; ?>" class="mt-3">
                                            <?php echo $row_produtos['descricao']; ?>
                                        </a>

                                        <a href="#" class="btn btn-white btn-icon-left mt-3" id="btnLigar" data-product-id="<?php echo $row_produtos['idProdutos']; ?>">
                                            <span class="icon-left">
                                                <i class="fa fa-shopping-bag"></i>
                                            </span>Add à lista
                                        </a>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-one text-center wow fadeInUp">
                    <a id="btnVerMais" class="btn btn-white btn-sm" href="produtos.php">Ver mais produtos</a>
                </div>
            </div>
        </div>
    </section>

    <script>
        $(document).ready(function () {
            $(".btn-icon-left").on("click", function (event) {
                event.preventDefault();
                var productId = $(this).data("product-id");

                $.ajax({
                    url: 'cart.php',
                    type: 'GET',
                    data: { add_to_cart: productId },
                    success: function (response) {
                        console.log('Produto adicionado ao carrinho com sucesso');
                    },
                    error: function (error) {
                        console.error('Erro ao adicionar produto ao carrinho', error);
                    }
                });
            });
        });
    </script>

</body>

</html>
