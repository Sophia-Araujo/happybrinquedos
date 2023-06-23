<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title> CRUD - PHP com mysqli </title>
		<link rel="stylesheet" type="text/css" href="./bootstrap/css/bootstrap.min.css">
	</head>
	<body class="container" style="padding-left: 28%; margin-top: 10%;">
		<?php
			include_once('conexao.php');
			// recuperando 
			$codigo = $_POST['codigo'];
			$produto = $_POST['produto'];	
			$descricao = $_POST['descricao'];
			$modelo = $_POST['modelo'];
			$faixa_etaria = $_POST['faixa_etaria'];
			$marca = $_POST['marca'];
			$data = $_POST['data'];	
			$valor = $_POST['valor'];
			$imagem = ""; 
			$target_dir = "imagens/";
			// Caminho + nome da imagem
			$target_file = $target_dir . basename($_FILES["imagem"]["name"]);
			// Variável para controlar o upload
			$uploadOk = 1;
			// obtendo a extensão do arquivo para verificarmos o tipo dele
			$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

			if(isset($_POST["submit"])) {
				// Verificando se o arquivo é mesmo uma imagem 
				// O getimagesize vai retornar o tamanho da imagem ou um erro se não for imagem o arquivo
				$check = getimagesize($_FILES["imagem"]["tmp_name"]);

				if($check !== false) {
					echo "<p>O arquivo é uma imagem do tipo " . $check["mime"] . ".</p>";
					$uploadOk = 1;
				} else {
					echo "<p>O arquivo não é de imagem.</p>";
					$uploadOk = 0;
				}
			}

			// Verificando se já existe um arquivo com o mesmo nome da pasta onde serão gravadas as imagens
			if($target_file != "imagens/") {
				if (file_exists($target_file)) {
					echo "<p>Desculpe, mas já existe um arquivo no servidor com esse nome.</p>";
					$uploadOk = 0;
				}
			}

			// Verificando o tamanho da imagem, pois por padrão, só são aceitos arquivos com 40MB
			if ($_FILES["imagem"]["size"] > 500000) { // Equivale a menos de 500KB
				echo "<p>Desculpe, mas o arquivo é muito grande.</p>";
				$uploadOk = 0;
			}

			// Limitando os formatos aceitos
			if($target_file != "imagens/") {
				if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
					echo "<p>Desculpe, mas só arquivos JPG, JPEG, PNG e GIF são permitidos.</p>";
					$uploadOk = 0;
				}
			}

			// Verificando se $uploadOk é zero, pois isso indica que houve um erro
			if ($uploadOk == 0) {
				echo "<p>Desculpe, mas seu arquivo não foi enviado para o servidor.</p>";
			// Se tudo estiver certo, vamos mover o arquivo para a pasta definitiva ==> move_uploaded_file
			} else {
				if (move_uploaded_file($_FILES["imagem"]["tmp_name"], $target_file)) {
					echo "<h5>O arquivo " . htmlspecialchars(basename($_FILES["imagem"]["name"])) . " foi enviado para o servidor.</h5>";
					$imagem = basename($_FILES["imagem"]["name"]); // Nome do arquivo
				} else if($target_file != "imagens/") {
					echo "<h5>Desculpe, houve um erro ao tentar enviar seu arquivo para o servidor.</h5>";
				}
			}

			// criando a linha de INSERT
			$sqlinsert =  "INSERT INTO brinquedos (codigo, produto, descricao, data, valor, imagem, faixa_etaria, modelo, marca) VALUES ($codigo, '$produto', '$descricao', '$data', $valor, '$imagem', '$faixa_etaria', '$modelo', '$marca')";

			
			// executando instrução SQL
			$resultado = mysqli_query($conexao, $sqlinsert);
			if (!$resultado) {
				echo '<input type="button" onclick="window.location='."'index.php'".';" value="Voltar"><br><br>';
				die('<b>Query Inválida:</b>' . mysqli_error($conexao)); 
			} else {
				echo "<h1 style='margin-top: 50px;'><strong>Cadastro efetuado</strong></h1>";
			} 
			mysqli_close($conexao);
		?>
		<br><br>
		<img src="./img/mais.png" alt="" style="padding-left: 9%;">
		<br><br>
		<input class="btn btn-primary" type="button" onclick="window.location='index.php';" value="Voltar" style="margin-left: 20%;">
	</body>
</html>
