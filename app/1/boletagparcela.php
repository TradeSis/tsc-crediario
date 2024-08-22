<?php

$log_datahora_ini = date("dmYHis");
$acao="boletagparcela"; 
$arqlog = defineCaminhoLog()."apilebes_".$acao."_".date("dmY").".log";
$arquivo = fopen($arqlog,"a");
$identificacao=$log_datahora_ini.$acao;
fwrite($arquivo,$identificacao."-ENTRADA->".json_encode($jsonEntrada)."\n");

$contas = array();

  $progr = new chamaprogress();
  
  $retorno = $progr->executarprogress("crediario/app/1/boletagparcela",json_encode($jsonEntrada));
  fwrite($arquivo,$identificacao."-RETORNO->".$retorno."\n");

  $contas = json_decode($retorno,true);
  if (isset($contas["conteudoSaida"][0])) { // Conteudo Saida - Caso de erro
      $contas = $contas["conteudoSaida"][0];
  } else {
    
     if (!isset($contas["boletagparcela"][0]) && ($jsonEntrada['DtEmissao'] != null)) {  // Verifica se tem mais de 1 registro
      $contas = $contas["boletagparcela"][0]; // Retorno sem array
    } else {
      $contas = $contas["boletagparcela"];  
    }

  }


$jsonSaida = $contas;


//LOG
if (isset($LOG_NIVEL)) {
  if ($LOG_NIVEL >= 2) {
    fwrite($arquivo, $identificacao . "-SAIDA->" . json_encode($jsonSaida) . "\n\n");
  }
}
//LOG

fclose($arquivo);


?>

