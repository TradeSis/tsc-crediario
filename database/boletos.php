<?php
// Lucas 07082024  

include_once __DIR__ . "/../conexao.php";

if (isset($_GET['operacao'])) {

	$operacao = $_GET['operacao'];
	
	if ($operacao == "buscar") {

		$DtEmissaoInicial = isset($_POST["DtEmissaoInicial"]) && $_POST["DtEmissaoInicial"] !== "" ? $_POST["DtEmissaoInicial"] : null;
		$DtEmissaoFinal = isset($_POST["DtEmissaoFinal"]) && $_POST["DtEmissaoFinal"] !== "" ? $_POST["DtEmissaoFinal"] : null;
		
		$apiEntrada = array(
			'DtEmissaoInicial' => $DtEmissaoInicial,
			'DtEmissaoFinal' => $DtEmissaoFinal
		);
		$boletos = chamaAPI(null, '/crediario/boletos', json_encode($apiEntrada), 'GET');

		echo json_encode($boletos);
		return $boletos;
	}

}