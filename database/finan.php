<?php
//lucas 21082024

/* include_once('../conexao.php'); */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once __DIR__ . "/../conexao.php";


if (isset($_GET['operacao'])) {

	$operacao = $_GET['operacao'];

	if ($operacao == "buscar") {

		$fincod = isset($_POST["fincod"])  && $_POST["fincod"] !== "" && $_POST["fincod"] !== "null" ? $_POST["fincod"]  : null;
		$pagina = isset($_POST["pagina"])  && $_POST["pagina"] !== "" && $_POST["pagina"] !== "null" ? $_POST["pagina"]  : 0;
		
		$apiEntrada = 
		array(
			'fincod' => $fincod,
			'pagina' => $pagina
		);
		$finan = chamaAPI(null, '/crediario/finan', json_encode($apiEntrada), 'GET');

		echo json_encode($finan);
		return $finan;
	}


	header('Location: ../crediario/finan.php');

}