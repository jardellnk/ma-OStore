<?php
include_once("conexao.php");// conecxao ao banco de dados
$msg = false;
if(isset($_FILES['imagem']))

{
		$extensao = strtolower(substr($_FILES['imagem']['name'], -5));// separa nome de arquivo de sua extensao
		$novo_nome = md5(time()) . $extensao;	//renomeia o arquivo e adiciona a extensao
		$diretorio = "imagens/Produtos/"; // seleciona o diretorio para aonde sera salvo a imagem

		move_uploaded_file($_FILES['imagem']['tmp_name'], $diretorio.$novo_nome); // move o arquivo da pasta temporaria para o diretorio selecionado

		//$sql_code = //"INSERT INTO produtos (imagem,descricao) VALUES('$novo_nome',null)"; // essa linha faz a inclusao do registro na tabela produtos



	$sql_code =	"INSERT INTO produtos (codDeBarra,descricao,precoVenda,estoque,imagem) VALUES('codDeBarra','descricao','precoVenda','estoque','$novo_nome')";


}
?>

<h1>Cadastro Produtos</h1>




	<form action="Upload.php" method="POST" enctype="multipart/form-data" >

	<label>Nome: </label>
	<input type="text" name="descricao" placeholder=""><br><br>

	<label>Valor: </label>
	<input type="text" name="precoVenda" placeholder=""><br><br>

	<label>Quantidade: </label>
	<input type="text" name="estoque" placeholder=""><br><br>

	<label>Codigo: </label>
	<input type="text" name="codDeBarra" placeholder=""><br><br>

	<label>Codigo: </label>
	<input type="file" name="imagem" multiple="multiple"><br><br>

	<input type="submit" value="Cadastrar">
</form>
