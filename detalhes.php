<?php include_once("conexao.php");
$id_produtos = $_GET['id_produtos'];
$result_produtos = "SELECT * FROM produtos WHERE idProdutos='$id_produtos'";
$resultado_produtos = mysqli_query($conn, $result_produtos);
$row_produtos = mysqli_fetch_assoc($resultado_produtos);

$imagem = $row_produtos['imagem']
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

  <!-- Header -->
  <!-- <?php include_once("includes/header.php"); ?> -->


<br><br>
</head>

<body>

  <!-- Page Content -->
  <div class="container">

    <div class="row">

      <div class="col-lg-4">
        <div class="card mt-4">
          <img class="card-img-top img-fluid" src="imagens/produtos/<?php echo $row_produtos['imagem']; ?>.jpg" alt="..." height="10" width="10">
          <div class="card-body">
            <h3 class="card-title"><?php echo $row_produtos['descricao']; ?></h3>
            <h4 class="card-title"><?php echo 'R$ ' . $row_produtos['precoVenda']; ?> <?php echo 'por ' . $row_produtos['unidade']; ?></h4>

            <!--  <span class="text-warning">&#9733; &#9733; &#9733; &#9733; &#9734;</span>
            4.0 Estrelas -->
          </div>
        </div>
      </div>
      <!-- /.col-lg-3 -->

      <div class="col-lg-8">

        <!-- /.card -->

        <div class="card card-outline-secondary my-4">
          <div class="card-header">
            Detalhes do produto
          </div>
          <div class="card-body">
           <p class="card-text"><?php echo $row_produtos['detalhes']; ?>
            <!-- <p class="card-text"><?php echo 'Esse é um texto de exemplo, para deixar funcionando adicione a coluna detalhes na tabela produtos e edite a linha 64' ?> -->
            </p>
            <hr>
            <br>
            <p class="stock_quantity"> Estoque: <?php echo $row_produtos['estoque'] ?>
            <br>

            <div class="input-group input-group-sm mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text" id="inputGroup-sizing-sm">Quantidade:</span>
            </div> 
            <form name="form" action="" method="get">
              <input type="number" class="form-control" name="quantity" id="quantity" value="<?php echo $row_produtos['estoque'] ?>">
            </form>
            </div>
            <!--- <select class="custom-select custom-select-sm col-md-2" id="<?php echo $row_produtos['idProduto']; ?>" name="<?php echo $row_produtos['idProduto']; ?>">
              <?php for ($i = 1; $i <= $row_produtos['estoque']; $i++) { ?>
                <option value=" <?php echo $i ?> "> <?php echo $i ?></option>
              <?php } ?>
            </select> -->
            <a href="https://api.whatsapp.com/send/?phone=5562981836830&text=Olá! Gostaria de estar adquirindo o <?php echo $row_produtos['descricao'] ?>" target="_blank" class="btn btn-primary" role="button">Comprar</a>
          </div>
        </div>
        <!-- /.card -->
      </div>
      <!-- /.col-lg-9 -->
    </div>
  </div>
  <!-- /.container -->
  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Footer -->
    <?php include_once("includes/footer.php"); ?>

</body>

</html>
