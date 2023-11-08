<?php 
$id_produtos = $_GET['id_produtos'];
$result_produtos = "SELECT * FROM produtos WHERE idProdutos='$id_produtos'";
$resultado_produtos = mysqli_query($conn, $result_produtos);
$row_produtos = mysqli_fetch_assoc($resultado_produtos);
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

        if (!empty($row_produtos['img']) && file_exists($img_path)) {
          echo '<img src="' . $img_path . '" alt="..." height="250" width="250">';
        } else {
          echo '<img src="assets/img/produtos/default.jpg" alt="..." height="250" width="250">';
        }
        ?>
                        
        <div class="card-body"> 
          <class="card-item:hover"><?php echo $row_produtos['descricao']; ?>
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
          <a href="https://api.whatsapp.com/send/?phone=55<?php echo $row_emitente['whatsapp'] ?>&text=Olá! Gostaria de adquirir o <?php echo $row_produtos['descricao']; ?>" target="_blank" class="btn btn-white btn-icon-left mt-4" role="button">Chama no "ZAP"</a>
          
        </div>
      </div>
    </div>
  </div>
</div>