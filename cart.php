<?php
include_once("inc/head.php");
include_once("inc/header.php");

// Inicialize o carrinho na sessão, se ainda não existir
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if (isset($_GET['add_to_cart'])) {
    // Adicionar um produto ao carrinho
    $idProduto = $_GET['add_to_cart'];
    $_SESSION['cart'][$idProduto] = ($_SESSION['cart'][$idProduto] ?? 0) + 1;
} elseif (isset($_GET['remove_from_cart'])) {
    // Remover um produto do carrinho
    $idProduto = $_GET['remove_from_cart'];

    if (isset($_SESSION['cart'][$idProduto])) {
        $_SESSION['cart'][$idProduto] = max(0, $_SESSION['cart'][$idProduto] - 1);
        // Verificar se a quantidade é igual a 0 e remover o item do carrinho
        if ($_SESSION['cart'][$idProduto] == 0) {
            unset($_SESSION['cart'][$idProduto]);
        }
    }
} elseif (isset($_GET['add_one_item'])) {
    // Adicionar mais uma unidade do mesmo produto ao carrinho
    $idProduto = $_GET['add_one_item'];
    $_SESSION['cart'][$idProduto] = ($_SESSION['cart'][$idProduto] ?? 0) + 1;
} elseif (isset($_GET['remove_one_item'])) {
    // Remover uma unidade do mesmo produto do carrinho
    $idProduto = $_GET['remove_one_item'];
    $_SESSION['cart'][$idProduto] = max(0, $_SESSION['cart'][$idProduto] - 1);
    // Verificar se a quantidade é igual a 0 e remover o item do carrinho
    if ($_SESSION['cart'][$idProduto] == 0) {
        unset($_SESSION['cart'][$idProduto]);
    }
}

// Verificar e processar a finalização da compra
if (isset($_GET['finalizar_compra']) && !empty($_SESSION['cart'])) {
    $mensagem_whatsapp = "Pedido: \n";
    $total_carrinho = 0;

    foreach ($_SESSION['cart'] as $idProduto => $quantidade) {
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

    $valTotal = "Valor a pagar: R$:" . number_format($total_carrinho, 2, ',', '.');
    $numero_whatsapp = $whatsapp;
    $url_whatsapp = "https://api.whatsapp.com/send?phone=" . $numero_whatsapp . "&text=" . urlencode($mensagem_whatsapp) . $valTotal;

    header('Location: ' . $url_whatsapp);
    exit();
}
?>

<div class="container">
    <?php
    if (empty($_SESSION['cart'])) {
        echo "<p>Seu carrinho está vazio.</p>";
    } else {
        echo "<h2>Total de Itens a lista de desejos: " . array_sum($_SESSION['cart']) . "</h2>";;
        echo "<ul>";
        $total_carrinho = 0; // Inicialize o total do carrinho

        foreach ($_SESSION['cart'] as $idProduto => $quantity) {
            $query = "SELECT * FROM produtos WHERE idProdutos = $idProduto";
            $result = $conn->query($query);

            if ($result->num_rows > 0) {
                $rows = $result->fetch_assoc();
                $descricao = $rows['descricao'];
                $precovenda = $rows['precoVenda'];
                $total_item = $precovenda * $quantity;
                $total_carrinho += $total_item;

                echo "<br>";
                echo "Descrição: <b>$descricao </b>";
                echo "<br>Quantidade:<b> $quantity </b>- Preço unitário: R$<b>" . number_format($precovenda, 2, ',', '.') . "</b>";
                echo " Total do Item: R$<b>" . number_format($total_item, 2, ',', '.') . "</b>";

                echo " <a href='cart.php?add_one_item=$idProduto'><b>+</b></a>";
                echo " <a href='cart.php?remove_one_item=$idProduto'><b>-</b></a>";
                echo "</br>";
            }
        }
        echo "</br>";

        echo "</ul>";
        // Exibir o total do carrinho
        echo "<p>Total do Carrinho: </b><h4> R$" . number_format($total_carrinho, 2, ',', '.') . "</h4></b></p>";
        // Exibir a quantidade total de itens no carrinho

        // Adicione um botão para finalizar a compra ou continuar comprando
        echo "<p><a href='cart.php?finalizar_compra=1'>Finalizar Compra</a></p>";
    }
    ?>
</div>
