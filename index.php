<?php
include './banco/conexao.php';

if (isset($_POST['produtos'])) {//insert

	$produtos = $_POST['produtos'];
	$preco = $_POST['preco'];
	$cor = $_POST['cor'];

	$corLower = strtolower($cor);

	if($corLower=='azul' || $corLower=='vermelho'){

		$preco = $preco *0.8;

	}

	if($corLower == 'amarelo'){
		$preco = $preco *0.9;
	}

	if ($corLower=='vermelho' && $preco>50){
		$preco = $preco *0.95;

	}
	




	$stmt = $pdo->prepare('INSERT INTO preco (preco) VALUES(:preco)');
	$stmt->execute(array(
		':preco' => $preco
	));

	$id = $pdo->lastInsertId();

	$stmt = $pdo->prepare('INSERT INTO produtos (nome,cor, idpreco) VALUES(:nome, :cor, :preco)');
	$stmt->execute(array(
		':nome' => $produtos,
		':cor' => $cor,
		':preco' => $id
	));

	echo '<script>alert("Produto cadastrado com sucesso!")</script>';
}

if (isset($_GET['situacao'])) {
	$situacao = $_GET['situacao'];

	if ($situacao == 1) {
		//editar
	} else if ($situacao == 2) {
		//excluir
		$idprod = $_GET['idprod'];

		$stmt = $pdo->prepare('DELETE FROM produtos WHERE idprod = :idprod');
		$stmt->bindParam(':idprod', $idprod);
		$stmt->execute();
		echo '<script>alert("Produto deletado com sucesso!")</script>';
	} else {
		//??
	}
}
if (isset($_GET['atualizaId'])) {
	$idprodAtualiza = $_GET['atualizaId'];
	$atualizaProdutos = $_GET['atualizaProd'];
	$atualizaPreco = $_GET['atualizaPreco'];
	$atualizaCor = $_GET['atualizaCor'];

	$stmt = $pdo->prepare('update produtos set nome=:nome, cor=:cor WHERE idprod = :idprod');
	$stmt->execute(array(
		':nome' => $atualizaProdutos,
		':cor' => $atualizaCor,
		':idprod' => $idprodAtualiza

	));

	$query = $pdo->prepare("SELECT * FROM produtos p INNER JOIN preco pp ON p.idpreco=pp.idpreco 
	AND p.idprod=" . $idprodAtualiza);
	$query->execute();
	$dado = $query->fetch();

	$stmt = $pdo->prepare('update preco set  preco=:preco WHERE idpreco = :idpreco');
	$stmt->execute(array(
		':idpreco' => $dado['IDPRECO'],
		':preco' => $atualizaPreco

	));



	echo '<script>alert("Produto atualizado com sucesso!")</script>';
}

?>


<!DOCTYPE html>
<html>

<head>
	<title>Teste PHP</title>


	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

</head>

<body>


	<div id="accordion">
		<div class="card">
			<div class="card-header" id="headingOne">
				<h5 class="mb-0">
					<button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
						Inserir Novo Produto
					</button>
				</h5>
			</div>

			<div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
				<div class="card-body">

					<?php
					if (isset($_GET['situacao']) && $_GET['situacao'] == 1) {
						$idprodEditar = $_GET['idprod'];
						$query = $pdo->prepare("SELECT * FROM produtos p INNER JOIN preco pp ON p.idpreco=pp.idpreco 
						AND p.idprod=" . $idprodEditar);
						$query->execute();
						$dado = $query->fetch();

					?>

						<form class="form-group formulario" method="GET">
							<input value="<?php echo $dado['IDPROD']; ?>" type="text" name="atualizaId" class="form-control" id="atualizaId" placeholder="ID" readonly></input>
							<input value="<?php echo $dado['NOME']; ?>" type="text" name="atualizaProd" class="form-control" id="atualizaProd" placeholder="Produtos"></input>
							<input value="<?php echo $dado['PRECO']; ?>" type="text" name="atualizaPreco" class="form-control" id="atualizaPreco" placeholder="Preço"></input>
							<input value="<?php echo $dado['COR']; ?>" type="text" name="atualizaCor" class="form-control" id="cor" placeholder="Cor"></input>

							<input type="submit" name="inserir" value="Atualizar">

						</form>


					<?php
					} else {


					?>
						<form class="form-group formulario" method="POST">
							<input type="text" name="produtos" class="form-control" id="produtos" placeholder="Produtos"></input>
							<input type="text" name="preco" class="form-control" id="preco" placeholder="Preço"></input>
							<input type="text" name="cor" class="form-control" id="cor" placeholder="Cor"></input>

							<input type="submit" name="inserir" value="Inserir">

						</form>


					<?php
					}
					?>


				</div>
			</div>
		</div>


		<div class="card">
			<div class="card-header" id="headingOne">
				<h5 class="mb-0">
					<button class="btn btn-link" data-toggle="collapse" data-target="#collapseDois" aria-expanded="true" aria-controls="collapseDois">
						Listagem de produtos
					</button>
				</h5>
			</div>

			<div id="collapseDois" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
				<div class="card-body">


					<table id="teste" class="table">
						<thead>
							<tr>
								<th>Produtos</th>
								<th>Preço</th>
								<th>Cor</th>
								<th>Ação</th>
							</tr>
						</thead>
						<tbody>

							<?php

							$query = $pdo->prepare("SELECT * FROM produtos p INNER JOIN preco pp ON p.idpreco=pp.idpreco");
							$query->execute();
							$dado = $query->fetchAll();

							$valorTotal = 0;
							foreach ($dado as $i => $v) {
								$preco = $v['PRECO'];
								$nome = $v['NOME'];
								$cor = $v['COR'];
								$valorTotal += $preco;
								echo "<tr><td>" . $nome . "</td>
								<td>R$ " . $preco . "</td>
								<td>" . $cor . "</td>";
								echo '<td>
								
								
								<a type="submit" class="btn btn-outline-info" href="?situacao=1&idprod=' . $v['IDPROD'] . '"> Editar </a>
								<a type="submit" class="btn btn-outline-danger" href="?situacao=2&idprod=' . $v['IDPROD'] . '">Excluir</a>
								</td></tr>';
							}

							?>
							<th>Valor Total</th>
							<th></th>
							<th> R$ <?php echo $valorTotal; ?></th>
							<th></th>
						</tbody>
					</table>


				</div>
			</div>
		</div>

	</div>




</body>

</html>