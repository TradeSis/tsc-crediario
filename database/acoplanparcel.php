<?php
// lucas 10092024 

include_once __DIR__ . "/../conexao.php";
function buscaParcelaAcordo($negcod = null, $placod = null)
{
	
	$acordo = array();
	$apiEntrada = 
		array(
			"dadosEntrada" => array(
				array(
					'negcod' => $negcod,
					'placod' => $placod,
					'titpar' => null
				)
			)
		);

	$acordo = chamaAPI(null, '/crediario/acoplanparcel', json_encode($apiEntrada), 'GET');
	return $acordo;
}

if (isset($_GET['operacao'])) {

	$operacao = $_GET['operacao'];

	if ($operacao == "alterar") {

		$apiEntrada = 
		array(
			"acoplanparcel" => array(
				array(
					'id_recid_plan' => $_POST['id_recid_plan'],
            		'perc_parcela' => $_POST['perc_parcela'],

					'negcod' => $_POST['negcod'],
					'placod' => $_POST['placod'],
					'titpar' => $_POST['titpar']
				)
			)
		);
	
		$acordo = chamaAPI(null, '/crediario/acoplanparcel', json_encode($apiEntrada), 'POST');
	}


	if ($operacao == "buscar") {

        $negcod = isset($_POST["negcod"]) && $_POST["negcod"] !== "null"  ? $_POST["negcod"]  : null;
		$placod = isset($_POST["placod"]) && $_POST["placod"] !== "null"  ? $_POST["placod"]  : null;
		$titpar = isset($_POST["titpar"]) && $_POST["titpar"] !== "null"  ? $_POST["titpar"]  : null;

		$apiEntrada = 
		array(
			"dadosEntrada" => array(
				array(
					'placod' => $placod,
					'negcod' => $negcod,
					'titpar' => $titpar
				)
			)
		);
		
		$acordo = chamaAPI(null, '/crediario/acoplanparcel', json_encode($apiEntrada), 'GET');

		echo json_encode($acordo);
		return $acordo;
	}

}