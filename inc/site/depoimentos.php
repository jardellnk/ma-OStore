<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


<?php
// Verificar se o formulário foi submetido para adicionar uma avaliação
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['estrela'])) {
        // Receber os dados do formulário
        $estrela = filter_input(INPUT_POST, 'estrela', FILTER_DEFAULT);
        $mensagem = filter_input(INPUT_POST, 'mensagem', FILTER_DEFAULT);

        $query_avaliacao = "INSERT INTO avaliacoes (qtd_estrela, mensagem, created) VALUES (?, ?, ?)";
        $cad_avaliacao = $conn->prepare($query_avaliacao);
        $created = date("Y-m-d H:i:s");
        $cad_avaliacao->bind_param('iss', $estrela, $mensagem, $created);
        if ($cad_avaliacao->execute()) {
            $_SESSION['msg'] = "<p style='color: green;'>Avaliação cadastrada com sucesso.</p>";
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Avaliação não cadastrada.</p>";
        }
    } else {
        $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Necessário selecionar pelo menos 1 estrela.</p>";
    }
}

// Recuperar as avaliações do banco de dados
$query_avaliacoes = "SELECT id, qtd_estrela, mensagem, created FROM avaliacoes ORDER BY id DESC";
$result_avaliacoes = $conn->query($query_avaliacoes);

?>


    
    <h1>Avalie</h1>

    <?php
    // Imprimir a mensagem de erro ou sucesso salva na sessão
    if (isset($_SESSION['msg'])) {
        echo $_SESSION['msg'];
        unset($_SESSION['msg']);
    }
    ?>

    <!-- Início do formulário -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
    NOS DE UMA ESTRELINHA
</button>

    <!-- Fim do formulário -->

    <h1>Avaliações de nossos Clientes</h1>

    <?php
    // Percorrer a lista de registros recuperada do banco de dados
    while ($rows_avaliacao = $result_avaliacoes->fetch_assoc()) {
         "<p>Avaliação: " . $rows_avaliacao['id'] . "</p>";
        for ($i = 1; $i <= 5; $i++) {
            if ($i <= $rows_avaliacao['qtd_estrela']) {
                echo '<i class="opcao fa fa-star"></i>';
            } else {
                echo '<i class="opcao fa fa-star-o"></i> ';
            }
        }
        echo $rows_avaliacao['nome'].'<br>';
        echo $rows_avaliacao['mensagem'].'<BR>';
        ECHO $rows_avaliacao['created'].'<BR>';
    }
    ?><BR>



<div class="modal fade" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Avalie</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form method="POST" action="depoimentos.php">
                    <!-- Coloque aqui o seu formulário -->
                    <div class="estrelas">
                        <!-- Carrega o formulário definindo nenhuma estrela selecionada -->
                        <input type="radio" name="estrela" id="vazio" value="" checked>
                        <!-- Opção para selecionar 1 estrela -->
                        <label for="estrela_um"><i class="opcao fa"></i></label>
                        <input type="radio" name="estrela" id="estrela_um" value="1">
                        <!-- Opção para selecionar 2 estrelas -->
                        <label for="estrela_dois"><i class="opcao fa"></i></label>
                        <input type="radio" name="estrela" id="estrela_dois" value="2">
                        <!-- Opção para selecionar 3 estrelas -->
                        <label for="estrela_tres"><i class="opcao fa"></i></label>
                        <input type="radio" name="estrela" id="estrela_tres" value="3">
                        <!-- Opção para selecionar 4 estrelas -->
                        <label for="estrela_quatro"><i class="opcao fa"></i></label>
                        <input type="radio" name="estrela" id="estrela_quatro" value="4">
                        <!-- Opção para selecionar 5 estrelas -->
                        <label for="estrela_cinco"><i class="opcao fa"></i></label>
                        <input type="radio" name="estrela" id="estrela_cinco" value="5"><br><br>
                        <!-- Campo para enviar a mensagem -->
                        <textarea name="mensagem" rows="4" cols="30" placeholder="Digite o seu comentário..."></textarea><br><br>
                        <!-- Botão para enviar os dados do formulário -->
                        <input type="submit" value="Cadastrar"><br><br>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-SUBMIT" data-dismiss="modal">ACEITAR</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

</section>



