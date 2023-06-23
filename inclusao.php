<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title> CRUD - PHP com mysqli </title>
		<link rel="stylesheet" type="text/css" href="./css/styleS.css">
		<link rel="stylesheet" type="text/css" href="./css/style.css">
    	<link rel="stylesheet" type="text/css" href="./bootstrap/css/bootstrap.min.css">
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
	<body class="container">
		
		<div class="qua">
	<h3 class="tit" style="margin-top: 50px;">Cadastrar produto</h3>

	
	<form style="margin-left:15%;" name="produto" action="incluir.php" method="post" enctype="multipart/form-data"> <!-- ALTERADO -->
		<div class="in-cod">
			<label>Código:</label> <input type="number" class="form-control" name="codigo" required><br><br>
		</div>
		<div class="in-nome">
				<label>Produto:</label> <input type="text" class="form-control" name="produto"  required maxlength='80' style="width:550px"><br><br>
		</div>
		<div class="in-nome">
				<label>Modelo:</label> <input type="text" class="form-control" name="modelo"  required maxlength='80' style="width:550px"><br><br>
		</div>
		<div class="in-nome">
				<label>Marca:</label> <input type="text" class="form-control" name="marca" required maxlength='80' style="width:550px"><br><br>
		</div>
		<div class="in-nome">
				<label>Faixa etaria:</label> <input type="text" class="form-control"  required name="faixa_etaria" maxlength='3' style="width:550px"><br><br>
		</div>
		<div class="in-des">
				<label>Descrição: </label><br><textarea class="form-control"  required name="descricao" rows='3' cols='100' style="resize: none;"></textarea><br><br>
		</div>
		<div class="in-data">
				<label>Data do cadastro: </label> <input type="date"  required class="form-control" name="data"><br><br>
		</div>
		<div class="in-va">
				<label>Valor: R$ </label><input type="number"  required class="form-control" step="0.01" name="valor"> <br><br>
		</div>
	
<div class="input-group">
    <input type="file" class="form-control" id="inputGroupFile04" name="imagem" aria-describedby="inputGroupFileAddon04" aria-label="Upload">
</div>

<img id="miniatura" src="#" alt="Miniatura da imagem" style="display: none;margin-top: 10%;width: 250px;">




		</script>
	
		<div class="in-bt">
		<input type="submit" id="b1" class="btn btn-primary btn-sm" value="Ok" style="margin-top: 20px;margin-bottom: 40px;">
	
	<input type="reset" id="b2" class="btn btn-primary btn-sm" value="Limpar" style="margin-top: 20px;margin-bottom: 40px;margin-left: 35px;margin-right: 35px;">
		
		<input type="button" id="b3" class="btn btn-primary btn-sm" onclick="window.location='index.php';" value="Voltar" style="margin-top: 20px;margin-bottom: 40px;">
		</div>

	</form>
	</div>
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
