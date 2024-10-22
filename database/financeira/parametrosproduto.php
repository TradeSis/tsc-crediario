<?php
// Lucas 21102024  

include_once __DIR__ . "/../../conexao.php";


if (isset($_GET['operacao'])) {

	$operacao = $_GET['operacao'];

	if ($operacao == "inserir") {
	
		$apiEntrada = array("dadosEntrada" => array(array(
			'tipoOperacao' => $_POST['tipoOperacao'],
			'codpro' => $_POST['codpro'],
			'assEletronico' => $_POST['assEletronico'],
			'boletado' => $_POST['boletado'],
			'vlrMinAcrescimo' => $_POST['vlrMinAcrescimo']
		)));
		
		$parametros = chamaAPI(null, '/crediario/parametrosproduto', json_encode($apiEntrada), 'PUT');
		echo json_encode($parametros);
		return $parametros;
	}

	if ($operacao == "alterar") {
	
		$apiEntrada = array("dadosEntrada" => array(array(
			'tipoOperacao' => $_POST['tipoOperacao'],
			'codpro' => $_POST['codpro'],
			'assEletronico' => $_POST['assEletronico'],
			'boletado' => $_POST['boletado'],
			'vlrMinAcrescimo' => $_POST['vlrMinAcrescimo']
		)));
	
		$parametros = chamaAPI(null, '/crediario/parametrosproduto', json_encode($apiEntrada), 'POST');

	}

    if ($operacao == "excluir") {
	
		$apiEntrada = array("dadosEntrada" => array(array(
			'tipoOperacao' => $_POST['tipoOperacao'],
			'codpro' => $_POST['codpro']
		)));
	
		$parametros = chamaAPI(null, '/crediario/parametrosproduto', json_encode($apiEntrada), 'DELETE');

	}

	

	if ($operacao == "buscar") {

		$codpro = isset($_POST["codpro"]) && $_POST["codpro"] !== "" ? $_POST["codpro"] : null;
		$tipoOperacao = isset($_POST["tipoOperacao"]) && $_POST["tipoOperacao"] !== "" ? $_POST["tipoOperacao"] : null;
		
		$apiEntrada = array("dadosEntrada" => array(array(
			'codpro' => $codpro,
			'tipoOperacao' => $tipoOperacao
		)));
	
		$parametros = chamaAPI(null, '/crediario/parametrosproduto', json_encode($apiEntrada), 'GET');
	
		echo json_encode($parametros);
		return $parametros;
		

		
	}



}