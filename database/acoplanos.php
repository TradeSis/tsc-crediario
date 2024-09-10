<?php
// lucas 09092024 

include_once __DIR__ . "/../conexao.php";

function buscaPlano($negcod = null, $placod = null)
{
	
	$acordo = array();
	$apiEntrada = 
		array(
			"dadosEntrada" => array(
				array(
					'negcod' => $negcod,
					'placod' => $placod
				)
			)
		);

	$acordo = chamaAPI(null, '/crediario/acoplanos', json_encode($apiEntrada), 'GET');
	return $acordo;
}

if (isset($_GET['operacao'])) {

	$operacao = $_GET['operacao'];

	if ($operacao == "inserir") {
  
		$apiEntrada = 
		array(
			"acoplanos" => array(
				array(
					'id_recid_neg' => $_POST['id_recid'],
            		//'negcod' => $_POST['negcod'],
                    
                    'planom' => $_POST['planom'],
                    'calc_juro_titulo' => $_POST['calc_juro_titulo'],
                    'com_entrada' => $_POST['com_entrada'],
                    'perc_min_entrada' => $_POST['perc_min_entrada'],
                    'dias_max_primeira' => $_POST['dias_max_primeira'],
                    'qtd_vezes' => $_POST['qtd_vezes'],
                    'perc_desconto' => $_POST['perc_desconto'],
                    'perc_acres' => $_POST['perc_acres'],
                    'permite_alt_vezes' => $_POST['permite_alt_vezes'],
                    'valor_acres' => $_POST['valor_acres'],
                    'valor_desc' => $_POST['valor_desc']
				)
			)
		);
	
		$acordo = chamaAPI(null, '/crediario/acoplanos', json_encode($apiEntrada), 'PUT');
	
	}

	if ($operacao == "alterar") {

		$apiEntrada = 
		array(
			"acoplanos" => array(
				array(
					'id_recid' => $_POST['id_recid_plan'],
            		'negcod' => $_POST['negcod'],
                    'placod' => $_POST['placod'],
                    'planom' => $_POST['planom'],
                    'calc_juro_titulo' => $_POST['calc_juro_titulo'],
                    'com_entrada' => $_POST['com_entrada'],
                    'perc_min_entrada' => $_POST['perc_min_entrada'],
                    'dias_max_primeira' => $_POST['dias_max_primeira'],
                    'qtd_vezes' => $_POST['qtd_vezes'],
                    'perc_desconto' => $_POST['perc_desconto'],
                    'perc_acres' => $_POST['perc_acres'],
                    'permite_alt_vezes' => $_POST['permite_alt_vezes'],
                    'valor_acres' => $_POST['valor_acres'],
                    'valor_desc' => $_POST['valor_desc']
				)
			)
		);
	
		$acordo = chamaAPI(null, '/crediario/acoplanos', json_encode($apiEntrada), 'POST');
	}

    if ($operacao == "excluir") {

		$apiEntrada = 
		array(
			"acoplanos" => array(
				array(
					'id_recid' => $_POST['id_recid']
				)
			)
		);
	
		$planos = chamaAPI(null, '/crediario/acoplanos', json_encode($apiEntrada), 'DELETE');
	}

	if ($operacao == "buscar") {

        $negcod = isset($_POST["negcod"]) && $_POST["negcod"] !== "null"  ? $_POST["negcod"]  : null;
		$placod = isset($_POST["placod"]) && $_POST["placod"] !== "null"  ? $_POST["placod"]  : null;

		$apiEntrada = 
		array(
			"dadosEntrada" => array(
				array(
					'placod' => $placod,
					'negcod' => $negcod
				)
			)
		);
		
		$acordo = chamaAPI(null, '/crediario/acoplanos', json_encode($apiEntrada), 'GET');

		echo json_encode($acordo);
		return $acordo;
	}

}