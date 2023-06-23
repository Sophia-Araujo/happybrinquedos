<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Excluir produto </title>
		<link rel="stylesheet" type="text/css" href="./css/styleS.css">
		<link rel="stylesheet" type="text/css" href="./css/style.css">
    	<link rel="stylesheet" type="text/css" href="./bootstrap/css/bootstrap.min.css">
	</head>
	<body>
		
		<?php
			include_once('conexao.php');		
			/*
			ORIGINAL COMENTADO!!!!
			// recuperando 
			$codigo = $_POST['codigo'];

			// criando a linha do  SELECT
			$sqlconsulta =  "select * from brinquedos where codigo = $codigo";
			
			*/
			// Acrescentado
			//função remodelada para de fato formatar data/hora
			function convertedata($data){
				date_default_timezone_set("America/Sao_Paulo");
				$datanova = date_create($data);
				return date_format($datanova, "Y-m-d");
			}
			
			include("conexao.php");
			// recuperando a informação da URL
			// verifica se parâmetro está correto e dento da normalidade 
			if(isset($_GET['id']) && is_numeric(base64_decode($_GET['id']))){
				$id = base64_decode($_GET['id']);
			} else {
				header('Location: index.php');
			}
			// criando a linha do  SELECT
			$sqlconsulta =  "select * from brinquedos where id = $id";
			// executando instrução SQL
			$resultado = @mysqli_query($conexao, $sqlconsulta);
			if (!$resultado) {
				echo '<input type="button" onclick="window.location='."'index.php'".';" value="Voltar"><br><br>';
				die('<b>Query Inválida:</b>' . @mysqli_error($conexao)); 
			} else {
				$num = @mysqli_num_rows($resultado);
				if ($num==0){
				echo "<b>Código: </b>não localizado !!!!<br><br>";
				echo '<input type="button" onclick="window.location='."'exclusao.php'".';" value="Voltar"><br><br>';
				exit;		
				}else{
					$dados=mysqli_fetch_array($resultado);
				}
			}
			mysqli_close($conexao);
			$imagem = "SemImagem.png";
			if (!empty($dados['imagem'])){
				$imagem = $dados['imagem'];
			}
		?>
		
		<div class="container1 bordinha">
					<h3 class="tit">Exclusão de cadastro</h3>
		
		            <div class="ex-cod">
						<label>Código:</label> <input type="text" name="codigo" class="form-control" required="required" value="<?php echo $dados['codigo']; ?>" readonly="" maxlength="50" ><br><br>
					</div>
		            <div class="ex-nome">
						<label>Produto:</label> <input type="text" name="produto" class="form-control" maxlength="80"  value="<?php echo $dados['produto']; ?>" readonly=""><br><br> <!-- ALTERADO // ATENÇÃO-->  
					</div>
					<div class="ex-nome">
						<label>Modelo:</label> <input type="text" name="modelo" class="form-control" required="required" value="<?php echo $dados['modelo']; ?>" readonly="" maxlength="50" ><br><br>
					</div>
					<div class="ex-nome">
						<label>Marca:</label> <input type="text" name="marca" class="form-control" required="required" value="<?php echo $dados['marca']; ?>" readonly="" maxlength="50" ><br><br>
					</div>
					<div class="ex-nome">
						<label>faixa etária:</label> <input type="text" name="faixa_etaria" class="form-control" required="required" value="<?php echo $dados['faixa_etaria']; ?>" readonly="" maxlength="50" ><br><br>
					</div>
		            <div class="ex-desc">
						<label>Descrição: </label><br><textarea class="form-control" rows="3" cols="100"  readonly=""><?php echo $dados['descricao']; ?></textarea><br><br>
					</div>
					
					<div class="ex-data">
						<label>Data do cadastro: </label> <input type="date" class="form-control" value="<?php echo convertedata($dados['data']); ?>" readonly=""><br><br> <!-- Foi incluido o convertedata -->
					</div>
					<div class="ex-va">
						<label>Valor: R$ </label><input type="number" class="form-control" step="0.01" name="valor" value="<?php echo $dados['valor']; ?>" readonly=""> <br><br>
					</div>
					<div class="ex-fo">
						<label>Foto:</label><br><img src="imagens/<?php echo $imagem; ?>" class="rounded" name="foto" > <br><br><!-- Foi incluido -->
					</div>
				
		    <form name="produto" action="excluir.php" method="post">
			    <div class="in-bt">
					<input type="hidden" name="id" value="<?php echo $dados['id']; ?>">
					<input class="btn btn-primary" type="submit" value="Apagar">&nbsp;&nbsp;
					<input class="btn btn-primary" type="button" onclick="window.location='index.php';" value="Voltar"> <!-- Alterado -->
				</div>
			</form>
	    </div>
	</body>
</html>
