<?php
// Lucas 21102024  

include_once __DIR__ . "/../../conexao.php";


if (isset($_GET['operacao'])) {

	$operacao = $_GET['operacao'];

	if ($operacao == "inserir") {
	
		$apiEntrada = array("dadosEntrada" => array(array(
			'tipoOperacao' => $_POST['tipoOperacao'],
			'cobcod' => $_POST['cobcod'],
			'valMinParc' => $_POST['valMinParc'],
			'qtdMinParc' => $_POST['qtdMinParc'],
			'valorMinimoAcrescimoTotal' => $_POST['valorMinimoAcrescimoTotal']
		)));
		
		$parametros = chamaAPI(null, '/crediario/parametroscarteira', json_encode($apiEntrada), 'PUT');
		echo json_encode($parametros);
		return $parametros;
	}

	if ($operacao == "alterar") {
	
		$apiEntrada = array("dadosEntrada" => array(array(
			'tipoOperacao' => $_POST['tipoOperacao'],
			'cobcod' => $_POST['cobcod'],
			'valMinParc' => $_POST['valMinParc'],
			'qtdMinParc' => $_POST['qtdMinParc'],
			'valorMinimoAcrescimoTotal' => $_POST['valorMinimoAcrescimoTotal']
		)));
	
		$parametros = chamaAPI(null, '/crediario/parametroscarteira', json_encode($apiEntrada), 'POST');

	}

    if ($operacao == "excluir") {
	
		$apiEntrada = array("dadosEntrada" => array(array(
			'tipoOperacao' => $_POST['tipoOperacao'],
			'cobcod' => $_POST['cobcod']
		)));
	
		$parametros = chamaAPI(null, '/crediario/parametroscarteira', json_encode($apiEntrada), 'DELETE');

	}

	

	if ($operacao == "buscar") {

		$cobcod = isset($_POST["cobcod"]) && $_POST["cobcod"] !== "" ? $_POST["cobcod"] : null;
		$tipoOperacao = isset($_POST["tipoOperacao"]) && $_POST["tipoOperacao"] !== "" ? $_POST["tipoOperacao"] : null;
		
		$apiEntrada = array("dadosEntrada" => array(array(
			'cobcod' => $cobcod,
			'tipoOperacao' => $tipoOperacao
		)));
	
		$parametros = chamaAPI(null, '/crediario/parametroscarteira', json_encode($apiEntrada), 'GET');
	
		echo json_encode($parametros);
		return $parametros;
		

		
	}



}