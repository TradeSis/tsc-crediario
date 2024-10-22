<?php

$log_datahora_ini = date("dmYHis");
$acao="parametrosproduto"; 
$arqlog = defineCaminhoLog()."apilebes_".$acao."_".date("dmY").".log";
$arquivo = fopen($arqlog,"a");
$identificacao=$log_datahora_ini.$acao;
fwrite($arquivo,$identificacao."-ENTRADA->".json_encode($jsonEntrada)."\n");

$dados = array();

  $progr = new chamaprogress();
  
  $retorno = $progr->executarprogress("crediario/app/1/parametrosproduto",json_encode($jsonEntrada));

  //$jsonSaida = json_decode($retorno,true);
  $dados = json_decode($retorno,true);
  if (isset($dados["conteudoSaida"][0])) { // Conteudo Saida - Caso de erro
      $dados = $dados["conteudoSaida"][0];
  } else { 
     if (($jsonEntrada['dadosEntrada'][0]['codpro'] != null)) {  // Verifica se tem mais de 1 registro
      $dados = $dados["sicproparam"][0]; // Retorno sem array
    } else {
      $dados = $dados["sicproparam"]; 
    }

  }


$jsonSaida = $dados;


//LOG
if (isset($LOG_NIVEL)) {
  if ($LOG_NIVEL >= 2) {
    fwrite($arquivo, $identificacao . "-SAIDA->" . json_encode($jsonSaida) . "\n\n");
  }
}
//LOG

fclose($arquivo);


?>

