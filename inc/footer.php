<?php
include_once("conexao.php");
$query = "SELECT * FROM emitente";
$exec_query = mysqli_query($conn, $query);
$rows_emitente = mysqli_fetch_assoc($exec_query);
?>
<footer>
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-3 col-md-3 col-sm-12 col-one container-logo-footer wow fadeIn">
                <img class="logo-footer" src="<?php echo $rows_emitente['url_logo'] ?>" alt="Logo">
            </div>
            <div class="col-12 col-lg-6 col-md-6 col-sm-12 col-one container-texto-footer wow fadeIn">
                <p>&copy; <?php echo $rows_emitente['nome'] ?> - CNPJ:  <?php echo $rows_emitente['cnpj'] ?></p>
                <p><?php echo $rows_emitente['rua'] ?>, <?php echo $rows_emitente['numero'] ?> - <?php echo $rows_emitente['bairro'] ?>, <?php echo $rows_emitente['cidade'] ?>/<?php echo $rows_emitente['uf'] ?> - <?php echo $rows_emitente['cep'] ?> </p>
            </div>
            <div class="col-12 col-lg-3 col-md-3 col-sm-12 col-one container-redes-footer wow fadeIn">
                <a href="https://<?php echo $rows_emitente['instagram'] ?>" class="btn btn-sm btn-white btn-social mr-3">
                    <i class="fab fa-instagram"></i>
                </a>
                <a href="https://<?php echo $rows_emitente['facebook'] ?>"  class="btn btn-sm btn-white btn-social mr-3">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="https://api.whatsapp.com/send/?phone=55<?php echo $rows_emitente['whatsapp'] ?>&text=Olá! Gostaria de conversar " class="btn btn-sm btn-white btn-social">
                    <i class="fab fa-whatsapp"></i>
                </a>
            </div>
        </div>
        <div class="text-center">
        <a href='https://github.com/jardellnk/ma-OStore/'><p><b>ma-OStore </b> &copy; Todos os direitos reservados</p>
        </div>
    </div>
</footer>