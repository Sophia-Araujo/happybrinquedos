<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title> Ver Alteração </title>
		<link rel="stylesheet" type="text/css" href="./css/style.css">
		<link rel="stylesheet" type="text/css" href="./css/styleS.css">
		<link rel="stylesheet" type="text/css" href="./bootstrap/css/bootstrap.min.css">
		<style>
			.bordinha{
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
	<body  class="container">
		
		<?php
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
					echo '<input type="button" onclick="window.location='."'alteracao.php'".';" value="Voltar"><br><br>';
					exit;
				}else{
					$dados=mysqli_fetch_array($resultado);
				}
			} 
			mysqli_close($conexao);
			// Acrescentado
			$imagem = "SemImagem.png";
			if(!empty($dados['imagem'])){
				$imagem = 
				$dados['imagem'];
			}
			
		?>
		<div  class=" bordinha">

		<h3  class="tit"style="display: inline;margin-left: 27%;">Alteração de cadastro</h3>
		<form style="margin-left: 10%;" name="produto" action="alterar.php" method="post" enctype="multipart/form-data"> <!-- ALTERADO -->    
		<div class="in">
			<input type="hidden" class="form-control" name="id" value="<?php echo $id; ?>"> <!-- Foi incluido  -->
		</div>
		<div class="in-cod">
			<label>Código:</label> <input type="number" class="form-control" name="codigo" value="<?php echo $dados['codigo']; ?>" readonly><br><br>
		</div>
		<div class="in-nome">
			<label>Produto:</label> <input type="text"  class="form-control"name="produto" required maxlength='80' style="width:550px" value="<?php echo $dados['produto']; ?>"><br><br><!-- ALTERADO // ATENÇÃO-->
		</div>
		<div class="in-nome">
			<label>Modelo:</label> <input type="text"  class="form-control"name="modelo"required maxlength='50' style="width:550px" value="<?php echo $dados['modelo']; ?>"><br><br><!-- ALTERADO // ATENÇÃO-->
		</div>
		<div class="in-nome">
			<label>Marca:</label> <input type="text"  class="form-control"name="marca"required maxlength='40' style="width:550px" value="<?php echo $dados['marca']; ?>"><br><br><!-- ALTERADO // ATENÇÃO-->
		</div>
		<div class="in-nome">
			<label>Faixa etária:</label> <input type="text"  class="form-control"name="faixa_etaria" maxlength='3' style="width:550px" value="<?php echo $dados['faixa_etaria']; ?>"><br><br><!-- ALTERADO // ATENÇÃO-->
		</div>
		<div class="in-des">
			<label>Descrição: </label><br><textarea name="descricao"class="form-control" rows='3'required cols='100' style="resize: none;" ><?php echo $dados['descricao']; ?></textarea><br><br>
		</div>
			<div class="in-data">
				<label>Data do cadastro: </label> <input type="date" class="form-control"required name="data" value="<?php echo convertedata($dados['data']); ?>"><br><br>
			</div>
			<div class="in-va">
				<label>Valor: R$ </label><input type="number" class="form-control" required step="0.01" name="valor" value='<?php echo $dados['valor']; ?>'> <br><br>
			</div>
			<div class="input-group">
				<input type="file" class="form-control" id="inputGroupFile04"   name="imagem"aria-describedby="inputGroupFileAddon04" aria-label="Upload">
			</div>
			<img id="miniatura" src="#" alt="Miniatura da imagem" style="display: none;margin-top: 10%;width: 250px;">
			
			<div class="in-foatual">
				<label>Foto Atual:</label><br><img src="imagens/<?php echo $imagem; ?>" class="rounded" name="foto" width="100px"> <br><br><!-- Foi incluido -->
			</div>





			<div class="in-bt">
				<input type="submit"  class="btn btn-primary btn-sm" value="Ok" style="margin-top: 20px;margin-bottom: 40px;">
				
				<input type="reset"  class="btn btn-primary btn-sm" value="Limpar" style="margin-top: 20px;margin-bottom: 40px;margin-left: 35px;margin-right: 35px;">
				
				<input type="button"  class="btn btn-primary btn-sm" onclick="window.location='index.php';" value="Voltar" style="margin-top: 20px;margin-bottom: 40px;">
			</div>
		</div>
		</form>
		<script>
	function mostrarMiniatura() {
    var arquivo = document.querySelector('input[name="imagem"]').files[0];
    var leitor = new FileReader();

    leitor.onload = function(e) {
        document.querySelector('#miniatura').src = e.target.result;
        document.querySelector('#miniatura').style.display = 'block';
    }

    leitor.readAsDataURL(arquivo);
}

document.querySelector('input[name="imagem"]').addEventListener('change', mostrarMiniatura);

		</script>
	</body>
</html>
