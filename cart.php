<?php include_once("inc/head.php"); 
session_start();

// Inicialize o carrinho na sessão, se ainda não existir
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Verificar se o usuário deseja adicionar um item ao carrinho
if (isset($_GET['add_to_cart'])) {
    $idProdutos = $_GET['add_to_cart'];

    // Adicione o item ao carrinho (usando o ID do produto como chave)
    if (!isset($_SESSION['cart'][$idProdutos])) {
        $_SESSION['cart'][$idProdutos] = 1; // Defina a quantidade inicial
    } else {
        $_SESSION['cart'][$idProdutos]++; // Incrementar a quantidade se já existir no carrinho
    }
}

// Verificar se o usuário deseja remover um item do carrinho
if (isset($_GET['remove_from_cart'])) {
    $idProdutos = $_GET['remove_from_cart'];

    // Remova o item do carrinho
    if (isset($_SESSION['cart'][$idProdutos])) {
        if ($_SESSION['cart'][$idProdutos] > 1) {
            $_SESSION['cart'][$idProdutos]--; // Reduzir a quantidade se for maior que 1
        } else {
            unset($_SESSION['cart'][$idProdutos]); // Remover completamente se a quantidade for 1
        }
    }

    // Redirecionar de volta para o carrinho após a remoção
    header('Location: cart.php');
    exit();
}

// Verificar se o usuário deseja adicionar um item ao carrinho
if (isset($_GET['add_one_item'])) {
    $idProdutos = $_GET['add_one_item'];

    // Adicione um item à quantidade existente
    if (isset($_SESSION['cart'][$idProdutos])) {
        $_SESSION['cart'][$idProdutos]++;
    }
}

// Verificar se o usuário deseja remover um item do carrinho
if (isset($_GET['remove_one_item'])) {
    $idProdutos = $_GET['remove_one_item'];

    // Verifique se o item existe e tenha uma quantidade maior que 1
    if (isset($_SESSION['cart'][$idProdutos]) && $_SESSION['cart'][$idProdutos] > 1) {
        $_SESSION['cart'][$idProdutos]--;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Carrinho de Compras</title>
</head>
<body>
    <h1>Carrinho de Compras</h1>

    <?php

    if (empty($_SESSION['cart'])) {
        echo "<p>Seu carrinho está vazio.</p>";
    } else {
        echo "<h2>Itens no Carrinho:</h2>";
        echo "<ul>";
        $total_carrinho = 0; // Inicialize o total do carrinho
        foreach ($_SESSION['cart'] as $idProdutos => $quantity) {
            // Consulta ao banco de dados para obter informações do produto
            $query = "SELECT * FROM produtos WHERE idProdutos";
            $result = $conn->query($query);

            if ($result->num_rows > 0) {
                $rows = $result->fetch_assoc();
                $descricao = $rows['descricao'] ;
                $precovenda = $rows['precoVenda'];
                $total_item = $precovenda * $quantity;
                $total_carrinho += $total_item; // Atualizar o total do carrinho

                echo "<br>";
                echo "Descrição: " . $descricao ;
                echo "<br>Quantidade: " . $quantity . " - Preço unitário: R$ " . $precovenda;
                echo " Total do Item: R$ " . $total_item;
                echo " <br><a href='cart.php?remove_from_cart=" . $idProdutos . "'>Remover do Carrinho</a>";
                echo " <a href='cart.php?add_one_item=" . $idProdutos . "'>Adicionar um item</a>";
                echo " <a href='cart.php?remove_one_item=" . $idProdutos . "'>Remover um item</a>";
                echo "</br>";
            }
        }

        echo "</ul>";
        // Exibir o total do carrinho
        echo "<p>Total do Carrinho: R$ " . $total_carrinho . "</p>";
        // Adicione um botão para finalizar a compra ou continuar comprando
        echo "<p><a href='finalizar_compra.php'>Finalizar Compra</a></p>";
    }
    ?>
</body>
</html>
