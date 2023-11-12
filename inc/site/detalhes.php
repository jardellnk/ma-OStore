<?php 
// Se certifique de ter a conexão $conn estabelecida previamente

$id_produtos = $_GET['id_produtos'];

// Evite injeção de SQL usando prepared statements
$stmt_produtos = $conn->prepare("SELECT * FROM produtos WHERE idProdutos = ?");
$stmt_produtos->bind_param("i", $id_produtos);
$stmt_produtos->execute();
$resultado_produtos = $stmt_produtos->get_result();
$row_produtos = $resultado_produtos->fetch_assoc();

$query = "SELECT * FROM emitente";
$exec_query = mysqli_query($conn, $query);
$row_emitente = mysqli_fetch_assoc($exec_query);
?>

<!-- Page Content -->
<div class="container">
  <div class="row">
    <div class="col-lg-4">
      <div class="card mt-4">
        <?php
        $img_path = 'assets/img/produtos/' . $row_produtos['img'];
        $image_source = (empty($row_produtos['img']) || !file_exists($img_path)) ? 'assets/img/produtos/default.jpg' : $img_path;
        ?>
        <img src="<?php echo $image_source; ?>" alt="..." height="250" width="250">
        <div class="card-body">
          <p class="card-item:hover"><?php echo $row_produtos['descricao']; ?></p>
        </div>
      </div>
    </div>
    <!-- /.col-lg-3 -->

    <div class="col-lg-8">
      <div class="card card-outline-secondary my-4">
        <div class="card-header">
          Detalhes do produto 
        </div>
        <div class="card-body">
          <p class="card-text"><?php echo $row_produtos['especificacao']; ?></p>
          <hr>
          <br>
          <p class="stock_quantity"> Estoque atual: <?php echo $row_produtos['estoque']; ?></p>
          
        
        
          <a href="cart.php?add_to_cart=<?php echo $row_produtos['idProdutos']; ?>" class="btn btn-white btn-icon-left mt-3" id="btnLigar">
            <span class="icon-left">
              <i class="fa fa-shopping-bag"></i>
            </span>Add ao carrinho          
          </a>
        </div>
      </div>
    </div>
  </div>
</div>
