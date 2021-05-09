<?php include_once("conexao.php");
//Verificar se está sendo passado na URL a página atual, senao é atribuido a pagina
$pagina = (isset($_GET['pagina']))? $_GET['pagina'] : 1;
if(!isset($_GET['pesquisar'])){
	header("Location: index.php");
}else{
	$valor_pesquisar = $_GET['pesquisar'];
}


//Selecionar todos os produtos da tabela
$result_produto = "SELECT * FROM produtos WHERE descricao LIKE '%$valor_pesquisar%'";
$resultado_produto = mysqli_query($conn, $result_produto);

//Contar o total de produtos
$total_produtos = mysqli_num_rows($resultado_produto);

//Seta a quantidade de produtos por pagina
$quantidade_pg = 6;

//calcular o número de pagina necessárias para apresentar os produtos
$num_pagina = ceil($total_produtos/$quantidade_pg);

//Calcular o inicio da visualizacao
$incio = ($quantidade_pg*$pagina)-$quantidade_pg;

//Selecionar os produtos a serem apresentado na página
$result_produtos = "SELECT * FROM produtos WHERE descricao LIKE '%$valor_pesquisar%' limit $incio, $quantidade_pg";
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


</head>

	<body>

<!-- Menu de navegação superior -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
      <div class="container">
        <div class="col-sm-6 col-md-6">
          <form class="form-inline" method="GET" action="pesquisar.php">
            <div class="form-group">
              <input type="text" name="pesquisar" class="form-control" id="pesquisar" placeholder="Digitar...">
            </div>
            <button type="submit" class="btn btn-primary">Pesquisar</button>
          </form>
        </div>


        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item active">
              <a class="nav-link" href="./">Inicio
                <span class="sr-only">(current)</span>
              </a>
            </li>
            <li class="nav-item">
                        <a class="nav-link" href="carrinho.php">Carrinho</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Minha conta</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <!-- Page Content -->

		<div class="container theme-showcase" role="main">
			<div class="page-header">
				<div class="row">
				</div>
			</div>
			<div class="row">
				<?php while($rows_produtos = mysqli_fetch_assoc($resultado_produtos)){ ?>
					<div class="col-sm-6 col-md-3">
						<div class="thumbnail">
							<!-- <img src="imagens/produtos/<?php echo $rows_produtos['imagem']; ?>.jpg" alt="..." height="250" width="250"> -->
							<img src="imagens/produtos/produtos.jpg" alt="..." height="250" width="250">
							<div class="caption text-center">
								<a href="detalhes.php?id_produtos=<?php echo $rows_produtos['idProdutos']; ?>"><h3><?php echo $rows_produtos['descricao']; ?></h3></a>
								<p><a class="btn btn-primary" href="carrinho.php?acao=add&id=<?php echo $rows_produtos['idProdutos']?>" class="card-link" role="button">Add Carrinho</a>  </p>
							</div>
						</div>
					</div>
				<?php } ?>
			</div>
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
							<a href="pesquisar.php?pagina=<?php echo $pagina_anterior; ?>&pesquisar=<?php echo $valor_pesquisar; ?>" aria-label="Previous">
								<span aria-hidden="true">&laquo;</span>
							</a>
						<?php }else{ ?>
							<span aria-hidden="true">&laquo;</span>
					<?php }  ?>
					</li>
					<?php
					//Apresentar a paginacao
					for($i = 1; $i < $num_pagina + 1; $i++){ ?>
						<li><a href="pesquisar.php?pagina=<?php echo $i; ?>&pesquisar=<?php echo $valor_pesquisar; ?>"><?php echo $i; ?></a></li>
					<?php } ?>
					<li>
						<?php
						if($pagina_posterior <= $num_pagina){ ?>
							<a href="pesquisar.php?pagina=<?php echo $pagina_posterior; ?>&pesquisar=<?php echo $valor_pesquisar; ?>" aria-label="Previous">
								<span aria-hidden="true">&raquo;</span>
							</a>
						<?php }else{ ?>
							<span aria-hidden="true">&raquo;</span>
					<?php }  ?>
					</li>
				</ul>
			</nav>
		</div>


		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
		<!-- Include all compiled plugins (below), or include individual files as needed -->
		<script src="js/bootstrap.min.js"></script>

		  <!-- Footer -->
		  <?php include_once("includes/footer.php"); ?>
	</body>
</html>
