<?php
// lucas 05092024 

include_once __DIR__ . "/../conexao.php";

function buscaAcordoOnline($tpNegociacao, $negcod = null)
{
	
	$acordo = array();
	$apiEntrada = 
		array(
			"dadosEntrada" => array(
				array(
					'tpNegociacao' => $tpNegociacao,
					'negcod' => $negcod
				)
			)
		);

	$acordo = chamaAPI(null, '/crediario/aconegoc', json_encode($apiEntrada), 'GET');
	return $acordo;
}

if (isset($_GET['operacao'])) {

	$operacao = $_GET['operacao'];

	if ($operacao == "inserir") {
        
        $dtfim = isset($_POST["dtfim"]) && $_POST["dtfim"] !== ""  ? $_POST["dtfim"]  : null;
        $dtemissao_de = isset($_POST["dtemissao_de"]) && $_POST["dtemissao_de"] !== ""  ? $_POST["dtemissao_de"]  : null;
        $dtemissao_ate = isset($_POST["dtemissao_ate"]) && $_POST["dtemissao_ate"] !== ""  ? $_POST["dtemissao_ate"]  : null;

		$apiEntrada = 
		array(
			"aconegoc" => array(
				array(
            		'negnom' => $_POST['negnom'],
                    'dtini' => $_POST['dtini'],
                    'dtfim' => $dtfim,
                    'vlr_total' => $_POST['vlr_total'],
                    'perc_pagas' => $_POST['perc_pagas'],
                    'qtd_pagas' => $_POST['qtd_pagas'],
                    'dtemissao_de' => $dtemissao_de,
                    'dtemissao_ate' => $dtemissao_ate,
                    'vlr_parcela' => $_POST['vlr_parcela'],
                    'dias_atraso' => $_POST['dias_atraso'],
                    'vlr_aberto' => $_POST['vlr_aberto'],
                    'modcod' => $_POST['modcod'],
                    'tpcontrato' => $_POST['tpcontrato'],
                    'ParcVencidaSo' => $_POST['ParcVencidaSo'],
                    'ParcVencidaQtd' => $_POST['ParcVencidaQtd'],
                    'ParcVencerQtd' => $_POST['ParcVencerQtd'],
                    'Arrasta' => $_POST['Arrasta'],
                    'PermiteTitProtesto' => $_POST['PermiteTitProtesto'],
					'ptpnegociacao' => $_POST['tpNegociacao']
				)
			)
		);
	
		$acordo = chamaAPI(null, '/crediario/aconegoc', json_encode($apiEntrada), 'PUT');
	
	}

	if ($operacao == "alterar") {

		$dtfim = isset($_POST["dtfim"]) && $_POST["dtfim"] !== ""  ? $_POST["dtfim"]  : null;
        $dtemissao_de = isset($_POST["dtemissao_de"]) && $_POST["dtemissao_de"] !== ""  ? $_POST["dtemissao_de"]  : null;
        $dtemissao_ate = isset($_POST["dtemissao_ate"]) && $_POST["dtemissao_ate"] !== ""  ? $_POST["dtemissao_ate"]  : null;

		$apiEntrada = 
		array(
			"aconegoc" => array(
				array(
					'negcod' => $_POST['negcod'],
            		'negnom' => $_POST['negnom'],
                    'dtini' => $_POST['dtini'],
                    'dtfim' => $dtfim,
                    'vlr_total' => $_POST['vlr_total'],
                    'perc_pagas' => $_POST['perc_pagas'],
                    'qtd_pagas' => $_POST['qtd_pagas'],
                    'dtemissao_de' => $dtemissao_de,
                    'dtemissao_ate' => $dtemissao_ate,
                    'vlr_parcela' => $_POST['vlr_parcela'],
                    'dias_atraso' => $_POST['dias_atraso'],
                    'vlr_aberto' => $_POST['vlr_aberto'],
                    'modcod' => $_POST['modcod'],
                    'tpcontrato' => $_POST['tpcontrato'],
                    'ParcVencidaSo' => $_POST['ParcVencidaSo'],
                    'ParcVencidaQtd' => $_POST['ParcVencidaQtd'],
                    'ParcVencerQtd' => $_POST['ParcVencerQtd'],
                    'Arrasta' => $_POST['Arrasta'],
                    'PermiteTitProtesto' => $_POST['PermiteTitProtesto']
				)
			)
		);
	
		$acordo = chamaAPI(null, '/crediario/aconegoc', json_encode($apiEntrada), 'POST');
	}

    if ($operacao == "excluir") {

		$apiEntrada = 
		array(
			"aconegoc" => array(
				array(
					'id_recid' => $_POST['id_recid']
				)
			)
		);
	
		$planos = chamaAPI(null, '/crediario/aconegoc', json_encode($apiEntrada), 'DELETE');
	}

	if ($operacao == "buscar") {

        $negcod = isset($_POST["negcod"]) && $_POST["negcod"] !== "null"  ? $_POST["negcod"]  : null;

		$apiEntrada = 
		array(
			"dadosEntrada" => array(
				array(
					'tpNegociacao' => $_POST["tpNegociacao"],
					'negcod' => $negcod
				)
			)
		);
		
		$acordo = chamaAPI(null, '/crediario/aconegoc', json_encode($apiEntrada), 'GET');

		echo json_encode($acordo);
		return $acordo;
	}

}