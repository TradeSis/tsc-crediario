<?php
// Lucas 07082024  

include_once __DIR__ . "/../conexao.php";

function buscaBoleto($bolcod)
{
	$boleto = array();
	$retorno = array();
	$apiEntrada =
		array(
			"dadosEntrada" => array(
				array('bolcod' => $bolcod)
			)
		);
	$retorno = chamaAPI(null, '/crediario/boletos', json_encode($apiEntrada), 'GET');
	$boleto = $retorno[0];
	return $boleto;
}

if (isset($_GET['operacao'])) {

	$operacao = $_GET['operacao'];
	
	if ($operacao == "buscar") {

		$CliFor = isset($_POST["CliFor"]) && $_POST["CliFor"] !== "" ? $_POST["CliFor"] : null;
		$cpfcnpj = isset($_POST["cpfcnpj"]) && $_POST["cpfcnpj"] !== "" ? $_POST["cpfcnpj"] : null;
		$bolcod = isset($_POST["bolcod"]) && $_POST["bolcod"] !== "" ? $_POST["bolcod"] : null;
		$bancod = isset($_POST["bancod"]) && $_POST["bancod"] !== "" ? $_POST["bancod"] : null;
		$NossoNumero = isset($_POST["NossoNumero"]) && $_POST["NossoNumero"] !== "" ? $_POST["NossoNumero"] : null;
		$dtini = isset($_POST["dtini"]) && $_POST["dtini"] !== "" ? $_POST["dtini"] : null;
		$dtfim = isset($_POST["dtfim"]) && $_POST["dtfim"] !== "" ? $_POST["dtfim"] : null;
		
		$apiEntrada = array("dadosEntrada" => array(array(
			'CliFor' => $CliFor,
			'cpfcnpj' => $cpfcnpj,
			'bolcod' => $bolcod,
			'bancod' => $bancod,
			'NossoNumero' => $NossoNumero,
			'dtini' => $dtini,
			'dtfim' => $dtfim
		)));
		$_SESSION['filtro_boletos'] = $apiEntrada;
		$boletos = chamaAPI(null, '/crediario/boletos', json_encode($apiEntrada), 'GET');

		echo json_encode($boletos);
		return $boletos;
	}

	if ($operacao == "buscarBoletagem") {

		$acao = "boletagem";
		$dtbol = isset($_POST["dtbol"]) && $_POST["dtbol"] !== "" ? $_POST["dtbol"] : null;
		$contnum = isset($_POST["contnum"]) && $_POST["contnum"] !== "" ? $_POST["contnum"] : null;
		$etbcod = isset($_POST["etbcod"]) && $_POST["etbcod"] !== "" ? $_POST["etbcod"] : null;
		$dtini = isset($_POST["dtini"]) && $_POST["dtini"] !== "" ? $_POST["dtini"] : null;
		$dtfim = isset($_POST["dtfim"]) && $_POST["dtfim"] !== "" ? $_POST["dtfim"] : null;
		

		$apiEntrada = 
		array("dadosEntrada" => array(
			array(
				'acao' => $acao,
				'boletavel' => $_POST["boletavel"],
				'dtbol' => $dtbol,
				'contnum' => $contnum,
				'etbcod' => $etbcod,
				'dtini' => $dtini,
				'dtfim' => $dtfim
			)
		));
		$_SESSION['filtro_boletagem'] = $apiEntrada['dadosEntrada'][0];
		$boletagem = chamaAPI(null, '/crediario/assinatura', json_encode($apiEntrada), 'GET');
		if (isset ($boletagem["contrassin"])) {
			if (isset ($boletagem["contrassin"])) {
				$boletagem = $boletagem["contrassin"]; // TRATAMENTO DO RETORNO
			}
		}
		echo json_encode($boletagem);
		return $boletagem;
	}

	if ($operacao == "emitirboleto") {
		$contnum = isset($_POST["contnum"]) ? $_POST["contnum"] : null;

        if ($contnum == "") {
			$contnum = null;
		}

		$apiEntrada = 
		array("dadosEntrada" => array(
			array('numeroContrato' => $contnum)
		));
		/* gabriel - aguardando 
		$boletoemit = chamaAPI(null, '/crediario/emitirBoleto', json_encode($apiEntrada), 'POST'); */
		if (isset ($boletoemit["conteudoSaida"])) {
			if (isset ($boletoemit["conteudoSaida"])) {
				$boletoemit = $boletoemit["conteudoSaida"][0]; // TRATAMENTO DO RETORNO
			}
		}
		echo json_encode($boletoemit);
		return $boletoemit;
	}

}