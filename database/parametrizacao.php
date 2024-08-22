<?php
// Lucas 05082024  

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

		$apiEntrada = array(
			'dtIniVig' => $_POST['dtIniVig'],
			'listaModalidades' => $modalidade,
			'QtdParcMin' => $_POST['QtdParcMin'],
			'QtdParcMax' => $_POST['QtdParcMax'],
			'listaCarterias' => $_POST['listaCarterias'],
			'AssinaturaDigital' => $_POST['AssinaturaDigital'],
			'IdadeMin' => $_POST['IdadeMin'],
			'IdadeMax' => $_POST['IdadeMax'],
			'DiasPrimeiroVencMin' => $_POST['DiasPrimeiroVencMin'],
			'DiasPrimeiroVencMax' => $_POST['DiasPrimeiroVencMax'],
			'valorParcelMin' => $_POST['valorParcelMin'],
			'valorParcelaMax' => $_POST['valorParcelaMax'],
			'listaPlanos' => $_POST['listaPlanos']
		);
		
		$parametros = chamaAPI(null, '/crediario/parametrizacao', json_encode($apiEntrada), 'PUT');
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

		$apiEntrada = array(
			'dtIniVig' => $_POST['dtIniVig'],
			'listaModalidades' => $modalidade,
			'QtdParcMin' => intval($_POST['QtdParcMin']),
			'QtdParcMax' => intval($_POST['QtdParcMax']),
			'listaCarterias' => $_POST['listaCarterias'],
			'AssinaturaDigital' => $_POST['AssinaturaDigital'],
			'IdadeMin' => intval($_POST['IdadeMin']),
			'IdadeMax' => intval($_POST['IdadeMax']),
			'DiasPrimeiroVencMin' => intval($_POST['DiasPrimeiroVencMin']),
			'DiasPrimeiroVencMax' => intval($_POST['DiasPrimeiroVencMax']),
			'valorParcelMin' => intval($_POST['valorParcelMin']),
			'valorParcelaMax' => intval($_POST['valorParcelaMax']),
			'listaPlanos' => $_POST['listaPlanos']
		);
	
		$parametros = chamaAPI(null, '/crediario/parametrizacao', json_encode($apiEntrada), 'POST');

	}

	

	if ($operacao == "buscar") {

		$dtIniVig = isset($_POST["dtIniVig"]) && $_POST["dtIniVig"] !== "" ? $_POST["dtIniVig"] : null;
		$listaModalidades = isset($_POST["listaModalidades"]) && $_POST["listaModalidades"] !== "" ? $_POST["listaModalidades"] : null;
		
		$apiEntrada = array(
			'dtIniVig' => $dtIniVig,
			'listaModalidades' => $listaModalidades
		);
		$parametros = chamaAPI(null, '/crediario/parametrizacao', json_encode($apiEntrada), 'GET');

		echo json_encode($parametros);
		return $parametros;
	}

}