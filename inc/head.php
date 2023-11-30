<?php include_once("conexao.php");
$query = "SELECT * FROM configuracoes  WHERE 1"; 
$exec_query = mysqli_query($conn, $query);
$row_emitente = mysqli_fetch_assoc($exec_query);
?>
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo $row_emitente['valor'] ?> - ma-OStore</title>
    <link rel="stylesheet" href="./assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="./assets/css/fontawesome.css" />
    <link rel="stylesheet" href="./assets/css/animate.css" />
    <link rel="stylesheet" href="./assets/css/main.css" />
    <link rel="stylesheet" href="./assets/css/responsivo.css" />
</head>

<?php
session_start();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$quantidadeItensNoCarrinho = array_sum($_SESSION['cart']);
?>