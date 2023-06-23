<!DOCTYPE html>
	<html lang="pt-br">

	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" type="text/css" href="./css/styleS.css">
		<link rel="stylesheet" type="text/css" href="./css/style.css">
		<link rel="stylesheet" type="text/css" href="./bootstrap/css/bootstrap.min.css">
		<title>Ver produto</title>
		<style>
			.qua{
				border-radius:20px;
				background-color:#fff;
				max-width: 800px;
				padding: 20px;
				margin:20px auto;
				box-shadow: 0 0 10px rgba(0,0,0,0.3);
				align-items: center;
			}
			body{
				background-color:#f3f0f0;
			}
		</style>
	</head>
	
<body>
	
	<header id="header">
		<a id="logo" href="index.php"><img src="./img/logo.png" alt="logo"></a>
		<h1 style="margin-right: 9%;">Happy brinquedos</h1>
		</header>
		<div class="qua">
			<h3 class="tit">Detalhes do Produto</h3>
			<div class="">
					<?php
				//função antiga
				function convertedata2($data){
					$data_vetor = explode('-', $data);
					$novadata = implode('/', array_reverse ($data_vetor));
					return $novadata;
				}
				//função remodelada para de fato formatar data/hora
				function convertedata($data){
					date_default_timezone_set("America/Sao_Paulo");
					$datanova = date_create($data);
					return date_format($datanova,"d/m/Y");
				}
				
				include("conexao.php");
				// recuperando a informação da URL
				// verifica se parâmetro está correto e dento da normalidade 
				if(isset($_GET['id']) && is_numeric(base64_decode($_GET['id']))){
					$id = base64_decode($_GET['id']);
				} else {
					header('Location: index.php');
				}
				// realizando a pesquisa com o id recebido
				$query = mysqli_query($conexao, "select * from brinquedos where id = $id");
				
				if (!$query) {
					echo '<input type="button" onclick="window.location='."'index.php'".';" value="Voltar"><br><br>';
					die('<b>Query Inválida:</b>' . @mysqli_error($conexao)); 
				}
				
				$dados=mysqli_fetch_array($query);
				
				
				if (empty($dados['imagem'])){
					$imagem = 'SemImagem.png';
				}else{
					$imagem = $dados['imagem'];
				}
				$produto = $dados['produto'];
			
			echo "<img src=\"imagens/$imagem\" class=\"\"  style=\"display:block;margin-right: 0px;margin-left: 35%;heigth: 255px ;border-radius:10px;box-shadow: 0 0 10px rgba(0,0,0,0.4); \" alt=\"$produto\">";
			echo"<div style=\"margin-left: 0%;\">";
			echo "<br> <b>Data: </b>".convertedata($dados['data'])."<br>";	
			echo "<b>Id: </b>".$dados['id']."<br>";
			echo "<b>Codigo: </b>".$dados['codigo']."<br>";
			echo "<b>Produto: </b>".$dados['produto']."<br>";	
			echo "<b>Descrição: </b><br>";	
			echo "<p>".$dados['descricao']."</p>";
			echo "<b>Valor: </b> R$ ". number_format($dados['valor'],2,",",".") . "<br>";
			echo"</div>";
			
			mysqli_close($conexao);
			?>
		<br>
		<div class="container">
			<div class="row">
				<input type="button" class="btn btn-primary btn-sm" onclick="window.location='index.php';" value="Voltar"> 
				
			</div>
		</div>
    </div>
	
</body>
</html>


