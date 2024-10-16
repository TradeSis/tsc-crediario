<?php
// lucas 12092024 

include_once __DIR__ . "/../conexao.php";

if (isset($_GET['operacao'])) {

	$operacao = $_GET['operacao'];

	if ($operacao == "buscar") {

		$apiEntrada = 
		array(
			"dadosEntrada" => array(
				array(
					'id_recid' => $_POST["id_recid"]
				)
			)
		);
		
		$parcela = chamaAPI(null, '/crediario/aoacparcela', json_encode($apiEntrada), 'GET');

		echo json_encode($parcela);
		return $parcela;
	}


}