<?php
// Lucas 25092024  

include_once __DIR__ . "/../conexao.php";


if (isset($_GET['operacao'])) {

	$operacao = $_GET['operacao'];

	if ($operacao == "inserir") {
		$modalidade = $_POST['listaModalidades'];
		if (count($modalidade) == 1) {
				$modalidade = implode($_POST['listaModalidades']);
		} else {
				$modalidade = implode(",", $_POST['listaModalidades']);
		}

		$apiEntrada = array("dadosEntrada" => array(array(
			'dtIniVig' => $_POST['dtIniVig'],
			'listaModalidades' => $modalidade,
			'diasAtrasoMax' => $_POST['diasAtrasoMax'],
			'carteirasPermitidas' => $_POST['carteirasPermitidas'],
			'testaNovacao' => $_POST['testaNovacao'],
			'contratoPago' => $_POST['contratoPago']
		)));
		
		$parametros = chamaAPI(null, '/crediario/rfnparam', json_encode($apiEntrada), 'PUT');
		echo json_encode($parametros);
		return $parametros;
	}

	if ($operacao == "alterar") {
		$modalidade = $_POST['listaModalidades'];
		if (count($modalidade) == 1) {
				$modalidade = implode($_POST['listaModalidades']);
		} else {
				$modalidade = implode(",", $_POST['listaModalidades']);
		}
    
		$apiEntrada = array("dadosEntrada" => array(array(
			'dtIniVig' => $_POST['dtIniVig'],
			'listaModalidades' => $modalidade,
			'diasAtrasoMax' => $_POST['diasAtrasoMax'],
			'carteirasPermitidas' => $_POST['carteirasPermitidas'],
			'testaNovacao' => $_POST['testaNovacao'],
			'contratoPago' => $_POST['contratoPago']
		)));
	
		$parametros = chamaAPI(null, '/crediario/rfnparam', json_encode($apiEntrada), 'POST');

	}

	

	if ($operacao == "buscar") {

		$dtIniVig = isset($_POST["dtIniVig"]) && $_POST["dtIniVig"] !== "" ? $_POST["dtIniVig"] : null;
		
		$apiEntrada = array("dadosEntrada" => array(array(
			'dtIniVig' => $dtIniVig
		)));
	
		$parametros = chamaAPI(null, '/crediario/rfnparam', json_encode($apiEntrada), 'GET');
	
		echo json_encode($parametros);
		return $parametros;
		

		
	}



}