<?php
// lucas 12092024 

include_once __DIR__ . "/../conexao.php";

function buscaAcordo($Tipo, $IDAcordo = null)
{
	
	$acordo = array();
	$apiEntrada = 
		array(
			"dadosEntrada" => array(
				array(
					'Tipo' => $Tipo,
					'IDAcordo' => $IDAcordo
				)
			)
		);

	$acordo = chamaAPI(null, '/crediario/aoacordo', json_encode($apiEntrada), 'GET');
	return $acordo;
}

if (isset($_GET['operacao'])) {

	$operacao = $_GET['operacao'];


	if ($operacao == "buscar") {

        $IDAcordo = isset($_POST["IDAcordo"]) && $_POST["IDAcordo"] !== ""  ? $_POST["IDAcordo"]  : null;
		$DtAcordoini = isset($_POST["DtAcordoini"]) && $_POST["DtAcordoini"] !== "null" && $_POST["DtAcordoini"] !== ""  ? $_POST["DtAcordoini"]  : null;
		$DtAcordofim = isset($_POST["DtAcordofim"]) && $_POST["DtAcordofim"] !== "null" && $_POST["DtAcordofim"] !== ""  ? $_POST["DtAcordofim"]  : null;
		$CliFor = isset($_POST["CliFor"]) && $_POST["CliFor"] !== "" ? $_POST["CliFor"] : null;
		$cpfcnpj = isset($_POST["cpfcnpj"]) && $_POST["cpfcnpj"] !== "" ? $_POST["cpfcnpj"] : null;
		$etbcod = isset($_POST["etbcod"]) && $_POST["etbcod"] !== "" ? $_POST["etbcod"] : null;

		$apiEntrada = 
		array(
			"dadosEntrada" => array(
				array(
					'Tipo' => $_POST["Tipo"],
					'IDAcordo' => $IDAcordo,
					'DtAcordoini' => $DtAcordoini,
					'DtAcordofim' => $DtAcordofim,
					'CliFor' => $CliFor,
					'cpfcnpj' => $cpfcnpj,
					'etbcod' => $etbcod
				)
			)
		);
		
		$acordo = chamaAPI(null, '/crediario/aoacordo', json_encode($apiEntrada), 'GET');

		echo json_encode($acordo);
		return $acordo;
	}


}