<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./CSS/style.css">
    <link rel="stylesheet" type="text/css" href="./bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>Pagina inicial</title>
	<style>
		.icon{
			width:10%;
			height:10%;
		}
		.icon2{
			padding-top: 5%;
			width:8%;
			height:6%;
		}
		.espa{
			margin-bottom:5%;
		}
		.text-input{
 			 width:30%%;
			  size:1;
		}
		.b{
				background-color:#6786CF;
		}
		.font{
				font-size:180%;
		}
		
		.cad{
			background-color:#c5d7f2;
		}
	</style>
</head>

<body class="container">


        <nav class="navbar">
            <div class="logo"><a href="./index.php"><img class="happy" src="./img/logo.png" alt=""></a>
			</div>
            <div class="links">
				<ul class="nav-itens">
				<li>	
						<form action="index.php" method="post">
							<div id="divBusca" class="form-floating mb-3">
							<input type="text" class="form-control text-input" id="fname" name="produto" placeholder="nome do jogo" style="margin-right: 200px;">
								<label for="fname">Procurar</label>
							</div>
					</li>
					<li style="align-items: center;padding-to: 2%;margin-right: 5%;padding-top: 1%;">
							<button class="btnimg" id="btnBusca" style="width: 40px;"><img class="icon2" src="./img/lupa.png" alt="" style="width: 100%;"></button>
						 
					</li>
					<li style="margin-right:3%;">
						<button value="incluir" class="btn cad" style="margin-top: 7%;"><a class="link" href="inclusao.php">Cadastrar</a></button>
					</li>
					
					

				</ul>
			</div>
        </nav>
		<?php
			include("conexao.php");
			
			// ajustando a instrução select para ordenar por produto
			$sql = "select * from brinquedos order by produto";
			// verificando se o form de consulta chamou a página
			if($_SERVER["REQUEST_METHOD"] == "POST"){
				$produto = $_POST['produto'];
				$sql = "select * from brinquedos where produto like '%" . $produto . "%' order by produto";
			}
			$query = mysqli_query($conexao, $sql);

			if (!$query) {
				echo '<input type="button" onclick="window.location='."'index.php'".';" value="Voltar"><br><br>';
				die('<b>Query Inválida:</b>' . @mysqli_error($conexao));  
			}

			echo "<table class=\" table table-striped b \" border='1px'>";
			echo "<tr>
					<th width='30px'>Id</th>
					<th width='100px'>Código</th>
					<th width='250px'>Produto</th>
					<th width='100px'>Valor</th>
					<th width='100px'>Produto</th>
					<th width='200px'>Opções</th>
				</tr>";

			while($dados=mysqli_fetch_array($query)) 
			{
				echo "<tr class=\"  table-primary   \"> ";
				echo "<td align='left'>". $dados['id']."</td>";
				echo "<td>". $dados['codigo']."</td>";
				echo "<td>". $dados['produto']."</td>";
				echo "<td align='left'> R$ ". number_format($dados['valor'],2,",",".")  ."</td>";		
				// buscando a na pasta imagem
				if (empty($dados['imagem'])){
					$imagem = 'SemImagem.png';
				} else {
					$imagem = $dados['imagem'];
				}
				$id = base64_encode($dados['id']);
				echo "<td align='left'>
						<a href='verproduto.php?id=$id'>
							<img src='imagens/$imagem' width='70px'>
						</a>
					</td>";
				echo "<td>
						<a href='verproduto.php?id=$id'><img class='icon' src=\"./img/olho.png\" alt=\"\"></a>
						<a  href='veralteracao.php?id=$id'><img class='icon' src=\"./img/editar.png\" alt=\"\"></a>
						<a href='verexclusao.php?id=$id'><img class='icon' src=\"./img/excluir2.png\" alt=\"\"></a>
					</td>";
				echo "</tr>";
			}
			echo "</table>";
			
			mysqli_close($conexao);
		?>
		</div>
		
	</body>
</html>
