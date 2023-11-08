<?php
include_once("conexao.php");
$query = "SELECT * FROM emitente";
$exec_query = mysqli_query($conn, $query);
$row_emitente = mysqli_fetch_assoc($exec_query);
?>

<section class="header">
    <div class="container">
        <div class="row">
            <nav class="navbar navbar-expand-lg pl-0 pr-0 col-one">
                <a class="navbar-brand wow fadeIn" href="./">
                    <img src="<?php echo $row_emitente['url_logo'] ?>" width="160" class="img-logo" alt="Logo da Empresa">
                </a>

               

            <div class="navbar navbar-expand-lg pl-0 pr-0 col-one">
                    <form role="search" method="GET" action="pesquisar.php" class="form-inline">
                        <input type="text" name="pesquisar" class="form-control" id="pesquisar" placeholder="Pesquisar..." aria-label="Search">
                    </form>
            </div>
        </div>    
    </div>
</section>