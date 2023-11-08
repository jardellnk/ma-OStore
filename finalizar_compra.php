<?php include_once("inc/head.php"); ?>

<?php
session_start();

// Inicialize o carrinho na sessão, se ainda não existir
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// ... (seu código existente para manipular o carrinho) ...

// Verificar se o usuário deseja finalizar a compra
if (isset($_GET['finalizar_compra'])) {
    // Aqui você pode adicionar a lógica para finalizar a compra, como salvar o pedido no banco de dados, calcular o total, etc.

    // Por exemplo, você pode criar uma mensagem a ser enviada para o WhatsApp
    $mensagem_whatsapp = "Pedido: \n";
    foreach ($_SESSION['cart'] as $idProdutos => $quantity) {
        // Consulta ao banco de dados para obter informações do produto
        $query = "SELECT descricao, precoVenda FROM produtos WHERE idProdutos = $idProdutos";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $descricao = $row['descricao'];
            $precovenda = $row['precoVenda'];
            $total_item = $precovenda * $quantity;

            $mensagem_whatsapp .= "Descrição: " . $descricao . " - Quantidade: " . $quantity . " - Preço unitário: R$ " . $precovenda . " - Total do Item: R$ " . $total_item . "\n";
        }
    }

    // Agora, você pode enviar a mensagem para o número de WhatsApp
    $numero_whatsapp = $whatsapp['numero']; // Substitua 'numero' pelo índice correto do array
    $url_whatsapp = "https://api.whatsapp.com/send?phone=" . $numero_whatsapp . "&text=" . urlencode($mensagem_whatsapp);

    // Redirecione para o WhatsApp com a mensagem pronta para ser enviada
    header('Location: ' . $url_whatsapp);
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Finalizar Compra</title>
</head>
<body>
    <h1>Finalizar Compra</h1>

    <?php

    if (empty($_SESSION['cart'])) {
        echo "<p>Seu carrinho está vazio.</p>";
    } else {
        // Exiba o resumo do carrinho aqui

        // Adicione um botão "Finalizar Compra" que enviará a mensagem para o WhatsApp
        echo "<p><a href='finalizar_compra.php?finalizar_compra=1'>Finalizar Compra</a></p>";
    }
    ?>
</body>
</html>
