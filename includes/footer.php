<?php include_once("conexao.php");
$query = "SELECT * FROM emitente";
$exec_query = mysqli_query($conn, $query);
$row_emitente = mysqli_fetch_assoc($exec_query);
?>

<footer class="py-3 bg-dark">
    <div class="container">
      <p class="m-0 text-center text-white">&copy; <?php echo $row_emitente['nome'] ?> - CNPJ:  <?php echo $row_emitente['cnpj'] ?></p>
      <p class="m-0 text-center text-white"> <?php echo $row_emitente['rua'] ?>, <?php echo $row_emitente['numero'] ?> - <?php echo $row_emitente['bairro'] ?>, <?php echo $row_emitente['cidade'] ?>/<?php echo $row_emitente['uf'] ?> - <?php echo $row_emitente['cep'] ?> </p>
    </div>
 </footer>