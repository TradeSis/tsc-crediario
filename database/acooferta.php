<?php
// lucas 05092024 

include_once __DIR__ . "/../conexao.php";

function buscaOfertasAcordoOnline($ptpnegociacao = null, $clicod = null)
{
	
	$acordo = array();
	$apiEntrada = 
		array(
			"dadosEntrada" => array(
				array(
					'ptpnegociacao' => $ptpnegociacao,
					'clicod' => $clicod
				)
			)
		);

	$acordo = chamaAPI(null, '/crediario/acoofertas', json_encode($apiEntrada), 'GET');
	return $acordo;
}

function buscaOfertaAcordoOnline($ptpnegociacao = null, $clicod = null, $negcod = null)
{
	
	$acordo = array();
	$apiEntrada = 
		array(
			"dadosEntrada" => array(
				array(
					'ptpnegociacao' => $ptpnegociacao,
					'clicod' => $clicod,
					'negcod' => $negcod
				)
			)
		);

	$acordo = chamaAPI(null, '/crediario/acooferta', json_encode($apiEntrada), 'GET');
	return $acordo;
}

if (isset($_GET['operacao'])) {

	$operacao = $_GET['operacao'];


	if ($operacao == "buscar") {

        $ptpnegociacao = isset($_POST["ptpnegociacao"]) && $_POST["ptpnegociacao"] !== "null"  ? $_POST["ptpnegociacao"]  : null;
        $clicod = isset($_POST["clicod"]) && $_POST["clicod"] !== "null"  ? $_POST["clicod"]  : null;
        $negcod = isset($_POST["negcod"]) && $_POST["negcod"] !== "null"  ? $_POST["negcod"]  : null;

		$apiEntrada = 
		array(
			"dadosEntrada" => array(
				array(
					'ptpnegociacao' => $ptpnegociacao,
					'clicod' => $clicod,
					'negcod' => $negcod
				)
			)
		);
		
		$acordo = chamaAPI(null, '/crediario/acooferta', json_encode($apiEntrada), 'GET');

		echo json_encode($acordo);
		return $acordo;
	}

	if ($operacao == "buscarCondicoes") {

		$ptpnegociacao = isset($_POST["ptpnegociacao"]) && $_POST["ptpnegociacao"] !== "null"  ? $_POST["ptpnegociacao"]  : null;
        $negcod = isset($_POST["negcod"]) && $_POST["negcod"] !== "null"  ? $_POST["negcod"]  : null;
        $clicod = isset($_POST["clicod"]) && $_POST["clicod"] !== "null"  ? $_POST["clicod"]  : null;

		$apiEntrada = 
		array(
			"dadosEntrada" => array(
				array(
					'ptpnegociacao' => $ptpnegociacao,
					'clicod' => $clicod,
					'negcod' => $negcod
				)
			)
		);
		
		$acordo = chamaAPI(null, '/crediario/acooferta/condicoes', json_encode($apiEntrada), 'GET');

		echo json_encode($acordo);
		return $acordo;
	}

	if ($operacao == "buscarContratos") {

		$ptpnegociacao = isset($_POST["ptpnegociacao"]) && $_POST["ptpnegociacao"] !== "null"  ? $_POST["ptpnegociacao"]  : null;
        $negcod = isset($_POST["negcod"]) && $_POST["negcod"] !== "null"  ? $_POST["negcod"]  : null;
        $clicod = isset($_POST["clicod"]) && $_POST["clicod"] !== "null"  ? $_POST["clicod"]  : null;

		$apiEntrada = 
		array(
			array(
				'ptpnegociacao' => $ptpnegociacao,
				'clicod' => $clicod,
				'negcod' => $negcod
			)
	);
		
		$acordo = chamaAPI(null, '/crediario/acooferta/contratos', json_encode($apiEntrada), 'GET');

		echo json_encode($acordo);
		return $acordo;
	}

	if ($operacao == "buscarParcelas") {

		$ptpnegociacao = isset($_POST["ptpnegociacao"]) && $_POST["ptpnegociacao"] !== "null"  ? $_POST["ptpnegociacao"]  : null;
        $negcod = isset($_POST["negcod"]) && $_POST["negcod"] !== "null"  ? $_POST["negcod"]  : null;
        $clicod = isset($_POST["clicod"]) && $_POST["clicod"] !== "null"  ? $_POST["clicod"]  : null;
		$placod = isset($_POST["placod"]) && $_POST["placod"] !== "null"  ? $_POST["placod"]  : null;

		$apiEntrada = 
		array(
			"dadosEntrada" => array(
				array(
					'ptpnegociacao' => $ptpnegociacao,
					'clicod' => $clicod,
					'negcod' => $negcod,
					'placod' => $placod
				)
			)
		);
		
		$acordo = chamaAPI(null, '/crediario/acooferta/parcelas', json_encode($apiEntrada), 'GET');

		echo json_encode($acordo);
		return $acordo;
	}

}