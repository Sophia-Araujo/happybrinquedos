<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Excluir</title>
		<link rel="stylesheet" type="text/css" href="./bootstrap/css/bootstrap.min.css">
	</head>
	<body class="container" style="padding-left: 20%; margin-top: 16%;">
		<?php
			include("conexao.php");
			// recuperando 
			// FOI ALTERADO
			$id = $_POST['id'];

			// Recuperar o nome do arquivo de imagem
			$sqlselect = "SELECT imagem FROM brinquedos WHERE id = $id";
			$resultadoselect = mysqli_query($conexao, $sqlselect);
			if ($resultadoselect) {
				$registro = mysqli_fetch_assoc($resultadoselect);
				$nomeImagem = $registro['imagem'];

				// Excluir o arquivo de imagem
				$caminhoImagem = "imagens/" . $nomeImagem;
				
				if (file_exists($caminhoImagem)) {
					if($caminhoImagem!="imagens/SemImagem.png" ){
					if (!unlink($caminhoImagem)) {
						echo '<b>Erro ao excluir a imagem:</b> Não foi possível excluir o arquivo de imagem.';
					}
				}
				}
			
			} else {
				die('<b>Erro ao recuperar o nome da imagem:</b> ' . mysqli_error($conexao));
			}

			// criando a linha do DELETE
			// FOI ALTERADO
			$sqldelete = "DELETE FROM brinquedos WHERE id = $id";
			
			// executando instrução SQL
			$resultado = mysqli_query($conexao, $sqldelete);
			if (!$resultado) {
				echo '<input type="button" onclick="window.location='."'index.php'".';" value="Voltar"><br><br>';
				die('<b>Query Inválida:</b>' . mysqli_error($conexao)); 
			} else {
				echo "<h1>Registro Excluído com Sucesso.</h1>";
			} 
			mysqli_close($conexao);
		?>
		<img src="./img/excluir2.png" alt="" style="padding-left: 20%;">
		<br><br>
		<input class="btn btn-primary" type="button" onclick="window.location='index.php';" value="Voltar" style="margin-left: 29%;">
	</body>
</html>
