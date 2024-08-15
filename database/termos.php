<?php
include_once __DIR__ . "/../conexao.php";

function buscaTermos($IDtermo=null)
{
	
	$termos = array();
	
	$apiEntrada = array(
		'IDtermo' => $IDtermo,
	);
	
	$termos = chamaAPI(null, '/crediario/termos', json_encode($apiEntrada), 'GET');
	
	return $termos;
}
function buscaMnemos()
{
	
	$mnemos = array();
	
	$mnemos = chamaAPI(null, '/crediario/mnemos', null, 'GET');
	
	return $mnemos;
}


if (isset($_GET['operacao'])) {

	$operacao = $_GET['operacao'];

	if ($operacao=="inserir") {

    $apiEntrada = array(
      'IDtermo' => $_POST['IDtermo'],
      'termoNome' => $_POST['termoNome'],
      'termoCopias' => $_POST['termoCopias'],
      'termo' => $_POST['termo'] 
    );
  
		$termos = chamaAPI(null, '/crediario/termos', json_encode($apiEntrada), 'PUT');
		header('Location: ../clientes/termos.php');	
	}

	if ($operacao=="alterar") {

    $apiEntrada = array(
      'IDtermo' => $_POST['IDtermo'],
      'termoNome' => $_POST['termoNome'],
      'termoCopias' => $_POST['termoCopias']
    );
  
	
		$termos = chamaAPI(null, '/crediario/termos', json_encode($apiEntrada), 'POST');

	}
	if ($operacao=="rascunho") {

    $apiEntrada = array(
      'acao' => $_POST['acao'],
      'rascunho' => $_POST['rascunho'],
      'IDtermo' => $_POST['IDtermo']
    );
	
		$termos = chamaAPI(null, '/crediario/termos/rascunho', json_encode($apiEntrada), 'POST');


	}
    
    if ($operacao == "buscaTermos") {

		$IDtermo = isset($_POST["IDtermo"])  && $_POST["IDtermo"] !== "" && $_POST["IDtermo"] !== "null" ? $_POST["IDtermo"]  : null;

		$apiEntrada = array(
			'IDtermo' => $IDtermo
		);
		$termos = chamaAPI(null, '/crediario/termos', json_encode($apiEntrada), 'GET');
		echo json_encode($termos);
		return $termos;

	}
    
    if ($operacao == "buscaTermosJSON") {

		$termos = chamaAPI(null, '/crediario/buscaTermos', $_POST["jsonEntrada"], 'POST');
		echo json_encode($termos);
		return $termos;

	}
    if ($operacao == "buscaRascunhoJSON") {

		$termos = chamaAPI(null, '/crediario/buscaRascunho', $_POST["jsonEntrada"], 'POST');
		echo json_encode($termos);
		return $termos;

	}

	
	
}

?>

