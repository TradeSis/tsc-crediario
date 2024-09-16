<?php
// lucas 12092024 

include_once __DIR__ . "/../conexao.php";

function buscaAcordo($IDAcordo = null)
{
	
	$acordo = array();
	$apiEntrada = 
		array(
			"dadosEntrada" => array(
				array(
					'IDAcordo' => $IDAcordo
				)
			)
		);

	$acordo = chamaAPI(null, '/crediario/aoacordo', json_encode($apiEntrada), 'GET');
	return $acordo;
}

if (isset($_GET['operacao'])) {

	$operacao = $_GET['operacao'];


	if ($operacao == "buscar") {

        $IDAcordo = isset($_POST["IDAcordo"]) && $_POST["IDAcordo"] !== "null"  ? $_POST["IDAcordo"]  : null;
	
		$apiEntrada = 
		array(
			"dadosEntrada" => array(
				array(
					'IDAcordo' => $IDAcordo
				)
			)
		);
		
		$acordo = chamaAPI(null, '/crediario/aoacordo', json_encode($apiEntrada), 'GET');

		echo json_encode($acordo);
		return $acordo;
	}


}