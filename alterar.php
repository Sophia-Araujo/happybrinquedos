<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title> CRUD - PHP com mysqli </title>
		<link rel="stylesheet" type="text/css" href="./css/styleS.css">
		<link rel="stylesheet" type="text/css" href="./css/style.css">
		<link rel="stylesheet" type="text/css" href="./bootstrap/css/bootstrap.min.css">
	</head>
	<body class="container" style="padding-left: 20%;margin-top: 16%;">

		<?php
			include_once('conexao.php');
			// recuperando
			$id = $_POST['id'];
			$codigo = $_POST['codigo'];
			$produto = $_POST['produto'];
			$modelo = $_POST['modelo'];
			$faixa_etaria = $_POST['faixa_etaria'];
			$marca = $_POST['marca'];
			$descricao = $_POST['descricao'];
			$data = $_POST['data'];
			$valor = $_POST['valor'];
			$imagem = ""; //variável para armazenar o nome da imagem para mandar para o Banco de dados

			// Tutorial de upload de arquivos
			// https://www.w3schools.com/php/php_file_upload.asp

			// Pasta onde serão gravadas as imagens
			$target_dir = "imagens/";
			// Caminho + nome da imagem
			$target_file = $target_dir . basename($_FILES["imagem"]["name"]);
			// Variável para controlar o upload
			$uploadOk = 1;
			// obtendo a extensão do arquivo para verificarmos o tipo dele
			$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

			if (isset($_POST["submit"])) {
				// Verificando se o arquivo é mesmo uma imagem
				// O getimagesize vai retornar o tamanho da imagem ou um erro se não for imagem o arquivo
				$check = getimagesize($_FILES["imagem"]["tmp_name"]);
				if ($check !== false) {
					echo "<p>O arquivo é uma imagem do tipo " . $check["mime"] . ".</p>";
					$uploadOk = 1;
				} else {
					echo "<p>O arquivo não é de imagem.</p>";
					$uploadOk = 0;
				}
			}

			// Verificando se já existe um arquivo com o mesmo nome da pasta onde serão gravadas as imagens


			// Verificando o tamanho da imagem, pois por padrão, só são aceitos arquivos com 40MB
			if ($_FILES["imagem"]["size"] > 500000) { // Equivale a menos de 500KB
				echo "<p>Desculpe, mas o arquivo é muito grande.</p>";
				$uploadOk = 0;
			}

			// Limitando os formatos aceitos
			if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
				&& $imageFileType != "gif" && ($target_file != "imagens/")) {
				echo "<p>Desculpe, mas só arquivos JPG, JPEG, PNG e GIF são permitidos.</p>";
				$uploadOk = 0;
			}

			// Verificando se $uploadOk é zero, pois isso indica que houve um erro
			if ($uploadOk == 0) {
				echo "<p>Desculpe, mas seu arquivo não foi enviado para o servidor.</p>";
				$imagem = ""; // Definindo a imagem como vazia para manter a imagem existente no registro
			} else {
				if (move_uploaded_file($_FILES["imagem"]["tmp_name"], $target_file)) {
					echo "<h5>O arquivo " . htmlspecialchars(basename($_FILES["imagem"]["name"])) . " foi enviado para o servidor.";
					$imagem = basename($_FILES["imagem"]["name"]); //  Nome do arquivo
				} else if ($target_file != $target_dir) {
					echo "<h5>Desculpe, houve um erro ao tentar enviar seu arquivo para o servidor.</h5>";
				} else {
					$imagem = ""; // Definindo a imagem como vazia para manter a imagem existente no registro
				}
			}

			// Recuperar o nome do arquivo de imagem existente no registro
			$sqlselect = "SELECT imagem FROM brinquedos WHERE id = $id";
			$resultadoselect = mysqli_query($conexao, $sqlselect);
			if ($resultadoselect) {
				$registro = mysqli_fetch_assoc($resultadoselect);
				$nomeImagem = $registro['imagem'];
			} else {
				die('<b>Erro ao recuperar o nome da imagem:</b> ' . mysqli_error($conexao));
			}

			// criando a linha do UPDATE
			$sqlupdate = "UPDATE brinquedos SET produto='$produto', descricao='$descricao', data='$data', valor=$valor, modelo='$modelo', faixa_etaria='$faixa_etaria', marca='$marca'";

			// Adiciona a alteração da imagem ao SQL UPDATE apenas se uma nova imagem foi enviada
			if (!empty($imagem)) {
				$sqlupdate .= ", imagem='$imagem'";
			}

			$sqlupdate .= " WHERE id=$id";

			// executando instrução SQL
			$resultado = @mysqli_query($conexao, $sqlupdate);
			if (!$resultado) {
				echo '<input type="button" onclick="window.location=' . "'index.php'" . ';" value="Voltar"><br><br>';
				die('<b>Query Inválida:</b>' . @mysqli_error($conexao));
			} else {
				echo "<h1>Registro Alterado com Sucesso</h1>";
			}
			mysqli_close($conexao);

			// Excluir o arquivo de imagem antigo apenas se uma nova imagem foi enviada
			if (!empty($imagem) && $imagem != $nomeImagem) {
				$caminhoImagem = "imagens/" . $nomeImagem;
				if($caminhoImagem!="imagens/"){
				if (file_exists($caminhoImagem)) {
					if (!unlink($caminhoImagem)) {
						echo '<b>Erro ao excluir a imagem antiga:</b> Não foi possível excluir o arquivo de imagem antigo.';
					}
				}
			}
			}
		?>
		<br><br>
		<img src="./img/editar.png" alt="" style="padding-left: 20%;">
		<input class="btn btn-primary" type="button" onclick="window.location='index.php';" value="Voltar" style="margin-left: 29%;display: block;margin-top: 20px;">
	</body>
</html>
