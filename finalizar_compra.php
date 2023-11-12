<?php 
include_once("inc/head.php");

$query = "SELECT * FROM emitente LIMIT 1";
$result = mysqli_query($conn, $query);

if ($result && $rows_emitente = mysqli_fetch_assoc($result)) {
    // Use os dados conforme necessário
    $whatsapp = $rows_emitente['whatsapp'];

} ;

session_start();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if (isset($_GET['finalizar_compra']) && !empty($_SESSION['cart'])) {
    $mensagem_whatsapp = "Pedido: \n";
    $total_carrinho = 0;

    foreach ($_SESSION['cart'] as $idProduto => $quantidade) {
        // Consulta ao banco de dados para obter informações do produto
        $query = "SELECT * FROM produtos WHERE idProdutos = $idProduto";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            $rows = $result->fetch_assoc();
            $descricao = $rows['descricao'];
            $precovenda = $rows['precoVenda'];
            $codDeBarra = $rows['codDeBarra'];
            $total_item = $precovenda * $quantidade;
            $total_carrinho += $total_item;
        
            $mensagem_whatsapp .= "Qtd: $quantidade - ID: $idProduto - COD: $codDeBarra \nItem: $descricao \nPreço und: R$ " . number_format($precovenda, 2, ',', '.') . " - Total do Item: R$ " . number_format($total_item, 2, ',', '.') . "\n\n";
        }
    }

    $valTotal = "Valor a pagar: R$:".number_format($total_carrinho, 2, ',', '.');

    $numero_whatsapp = $whatsapp; // Substitua 'numero' pelo índice correto do array
    $url_whatsapp = "https://api.whatsapp.com/send?phone=" . $numero_whatsapp . "&text=" . urlencode($mensagem_whatsapp) . $valTotal ;

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
        echo "<p><a href='finalizar_compra.php?finalizar_compra=1'>Finalizar Compra</a></p>";
    }
    ?>
</body>
</html>