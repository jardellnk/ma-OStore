<?php include_once("conexao.php");


//Verificar se está sendo passado na URL a página atual, senao é atribuido a pagina
$pagina = (isset($_GET['pagina']))? $_GET['pagina'] : 1;

//Selecionar todos os produtos da tabela
$result_produto = "SELECT * FROM produtos";
$resultado_produto = mysqli_query($conn, $result_produto);

//Contar o total de produtos
$total_produtos = mysqli_num_rows($resultado_produto);

//Seta a quantidade de produtos por pagina
$quantidade_pg = 8;

//calcular o número de pagina necessárias para apresentar os produtos
$num_pagina = ceil($total_produtos/$quantidade_pg);

//Calcular o inicio da visualizacao
$incio = ($quantidade_pg*$pagina)-$quantidade_pg;

//Selecionar os produtos a serem apresentado na página
$result_produtos = "SELECT * FROM produtos limit $incio, $quantidade_pg";
$resultado_produtos = mysqli_query($conn, $result_produtos);
$total_produtos = mysqli_num_rows($resultado_produtos);

?>

<!DOCTYPE html>

<html lang="PT-BR">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Webink - Store </title>
  <!-- Bootstrap core CSS -->
  <link href="./vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom styles for this template -->
  <link href="./css/shop-homepage.css" rel="stylesheet">

  <!-- Menu de navegação superior -->
  <?php include_once("includes/menu.php"); ?>

  <!-- Banner -->
  <?php include_once("includes/banner.php"); ?>

</head>

<body>
  <!-- VITRINE -->

    <div class="container theme-showcase" role="main">
      <div class="page-header">
      </div>
      <div class="row">
        <?php while ($rows_produtos = mysqli_fetch_assoc($resultado_produtos)) { ?>
          <div class="col-sm-6 col-md-3">
            <div class="thumbnail">
            <!--  <img src="imagens/produtos/<?php echo $rows_produtos['imagem']; ?>.jpg" alt="..." height="250" width="250"> -->
               <img src="imagens/produtos/produtos.jpg" alt="..." height="250" width="250"> 
              <div class="caption text-center">
                <a href="detalhes.php?id_produtos=<?php echo $rows_produtos['idProdutos']; ?>">
                  <h4><?php echo $rows_produtos['descricao']; ?></h4><?php echo 'Apartir de R$ ' . $rows_produtos['precoVenda']; ?><br><br>
                </a>
                <select class="custom-select custom-select-sm col-md-4" id="
                <?php echo $rows_produtos['idProduto']; ?>" name="<?php echo $rows_produtos['idProduto']; ?>">
                  <?php for ($i = 1; $i <= $rows_produtos['estoque']; $i++) { ?>
                    <option value=" <?php echo $i ?> "> <?php echo $i ?></option>
                  <?php } ?>
                </select>

                <a class="btn btn-primary" href="carrinho.php?acao=add&id=<?php echo $rows_produtos['idProdutos']?>" class="card-link" role="button">Add Carrinho</a> </p>
              <!--  <a class="btn btn-primary" href="carrinho.php?acao=add&id=<?php echo $rows_produtos['idProdutos']?>" class="card-link">Comprar</a>
            -->  </div>
            </div>
          </div>
        <?php } ?>
      </div>
    </div>
    <!-- /.row -->

    <?php
      //Verificar a pagina anterior e posterior
      $pagina_anterior = $pagina - 1;
      $pagina_posterior = $pagina + 1;
    ?>
    <nav class="text-center">
      <ul class="pagination">
        <li>
          <?php
          if($pagina_anterior != 0){ ?>
            <a href="index.php?pagina=<?php echo $pagina_anterior; ?>" aria-label="Previous">
              <span aria-hidden="true">&laquo;</span>
            </a>
          <?php }else{ ?>
            <span aria-hidden="true">&laquo;</span>
        <?php }  ?>
        </li>
        <?php
        //Apresentar a paginacao
        for($i = 1; $i < $num_pagina + 1; $i++){ ?>
          <li><a href="index.php?pagina=<?php echo $i; ?>"><?php echo $i; ?></a></li>
        <?php } ?>
        <li>
          <?php
          if($pagina_posterior <= $num_pagina){ ?>
            <a href="index.php?pagina=<?php echo $pagina_posterior; ?>" aria-label="Previous">
              <span aria-hidden="true">&raquo;</span>
            </a>
          <?php }else{ ?>
            <span aria-hidden="true">&raquo;</span>
        <?php }  ?>
        </li>
      </ul>
    </nav>
  </div>

  </div>
  <!-- /.col-lg-9 -->

  </div>
  <!-- /.row -->

  </div>
  <!-- /.container -->

  <!-- Footer -->
  <?php include_once("includes/footer.php"); ?>
  

  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script type="text/javascript">
    function addCarrinho(idProduto) {

      var estoque = document.getElementById(idProduto).value;

      $.ajax({
        type: "POST",
        url: "<?php echo base_url('store/add') ?>",
        dataType: "JSON",
        data: {
          idProduto: idProduto,
          estoque: estoque
        },
        success: function(data) {
          alert(data);
        }
      });
    }
  </script>

</body>

</html>
