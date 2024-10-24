<?php
$log_datahora_ini = date("dmYHis");
$acao="contrassin"; 
$arqlog = defineCaminhoLog()."apilebes_".$acao."_".date("dmY").".log";
$arquivo = fopen($arqlog,"a");
$identificacao=$log_datahora_ini.$acao;
fwrite($arquivo,$identificacao."-ENTRADA->".json_encode($jsonEntrada)."\n");

$contrassin = array();

    $progr = new chamaprogress();
    $retorno = $progr->executarprogress("crediario/app/1/contrassin",json_encode($jsonEntrada));
    fwrite($arquivo,$identificacao."-RETORNO->".$retorno."\n");

    $contrassin = json_decode($retorno,true);
    if (isset($contrassin["conteudoSaida"][0])) { // Conteudo Saida - Caso de erro
        $contrassin = $contrassin["conteudoSaida"][0];
    } else {
      
      $contrassin = $contrassin["conteudoSaida"];  
  
    }
  
  
$jsonSaida = $contrassin;


//LOG
if (isset($LOG_NIVEL)) {
    if ($LOG_NIVEL >= 2) {
      fwrite($arquivo, $identificacao . "-SAIDA->" . json_encode($jsonSaida) . "\n\n");
    }
  }
//LOG

fclose($arquivo);
    
?>