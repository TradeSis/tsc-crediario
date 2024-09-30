<?php
// lucas 12092024 

include_once __DIR__ . "/../conexao.php";

if (isset($_GET['operacao'])) {

	$operacao = $_GET['operacao'];

	if ($operacao == "inserir") {
        
     
		$apiEntrada = 
		array(
			"serasacli" => array(
				array(
            		'diasdeatraso' => $_POST['diasdeatraso']
				)
			)
		);
	
		$serasacli = chamaAPI(null, '/crediario/serasacli', json_encode($apiEntrada), 'PUT');
	
	}

    if ($operacao == "excluir") {

		$apiEntrada = 
		array(
			"serasacli" => array(
				array(
					'clicod' => $_POST['clicod']
				)
			)
		);
	
		$serasacli = chamaAPI(null, '/crediario/serasacli', json_encode($apiEntrada), 'DELETE');
		
	}

	if ($operacao == "buscar") {

        $dtenvioini = isset($_POST["dtenvioini"]) && $_POST["dtenvioini"] !== "null"  ? $_POST["dtenvioini"]  : null;
		$dtenviofim = isset($_POST["dtenviofim"]) && $_POST["dtenviofim"] !== "null"  ? $_POST["dtenviofim"]  : null;
		$clicod = isset($_POST["clicod"]) && $_POST["clicod"] !== "null"  ? $_POST["clicod"]  : null;

		$apiEntrada = 
		array(
			"dadosEntrada" => array(
				array(
					'dtenvioini' => $dtenvioini,
					'dtenviofim' => $dtenviofim,
					'clicod' => $clicod
				)
			)
		);
		
		$serasacli = chamaAPI(null, '/crediario/serasacli', json_encode($apiEntrada), 'GET');

		echo json_encode($serasacli);
		return $serasacli;
	}

	if ($operacao == "arquivo") {
		
		$apiEntrada = 
		array(
			"serasacli" => array(
				array(
					
				)
			)
		);

		$serasacli = chamaAPI(null, '/crediario/serasacli_arquivo', json_encode($apiEntrada), 'POST');

		echo json_encode($serasacli);
		return $serasacli;
	}

}