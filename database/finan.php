<?php
//lucas 21082024

/* include_once('../conexao.php'); */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once __DIR__ . "/../conexao.php";


if (isset($_GET['operacao'])) {

	$operacao = $_GET['operacao'];

	if ($operacao == "inserir") {
	
		$apiEntrada = array("finan" => array(array(
			'fincod' => $_POST['fincod'],
			'finnom' => $_POST['finnom'],
			'finent' => ($_POST['finent'] == "Sim" ? true : false),
			'finnpc' => $_POST['finnpc'],
			'finfat' => $_POST['finfat'],
			'datexp' => $_POST['datexp'],
			'txjurosmes' => $_POST['txjurosmes'],
			'txjurosano' => $_POST['txjurosano'],
			'DPriPag' => $_POST['DPriPag'],
			'recorrencia' => ($_POST['recorrencia'] == "Sim" ? true : false)

		)));
		
		$parametros = chamaAPI(null, '/crediario/finan', json_encode($apiEntrada), 'PUT');
		echo json_encode($parametros);
		return $parametros;
	}

	if ($operacao == "alterar") {
	
		$apiEntrada = array("finan" => array(array(
			'fincod' => $_POST['fincod'],
			'finnom' => $_POST['finnom'],
			'finent' => ($_POST['finent'] == "Sim" ? true : false),
			'finnpc' => $_POST['finnpc'],
			'finfat' => $_POST['finfat'],
			'datexp' => $_POST['datexp'],
			'txjurosmes' => $_POST['txjurosmes'],
			'txjurosano' => $_POST['txjurosano'],
			'DPriPag' => $_POST['DPriPag'],
			'recorrencia' => ($_POST['recorrencia'] == "Sim" ? true : false)
		)));
	
		$parametros = chamaAPI(null, '/crediario/finan', json_encode($apiEntrada), 'POST');
		echo json_encode($parametros);
		return $parametros;
	}

    if ($operacao == "excluir") {
	
		$apiEntrada = array("finan" => array(array(
			'fincod' => $_POST['fincod']
		)));
	
		$parametros = chamaAPI(null, '/crediario/finan', json_encode($apiEntrada), 'DELETE');
		echo json_encode($parametros);
		return $parametros;
	}

	if ($operacao == "buscar") {

		$fincod = isset($_POST["fincod"])  && $_POST["fincod"] !== "" && $_POST["fincod"] !== "null" ? $_POST["fincod"]  : null;
		$pagina = isset($_POST["pagina"])  && $_POST["pagina"] !== "" && $_POST["pagina"] !== "null" ? $_POST["pagina"]  : 0;
		
		$apiEntrada = 
		array(
			"dadosEntrada" => array(
				array(
					'fincod' => $fincod,
					'pagina' => $pagina
				)
			)
		);
		$finan = chamaAPI(null, '/crediario/finan', json_encode($apiEntrada), 'GET');

		echo json_encode($finan);
		return $finan;
	}


	header('Location: ../crediario/finan.php');

}