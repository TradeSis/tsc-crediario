<?php
// PROGRESS


//LOG
$LOG_CAMINHO = defineCaminhoLog();
if (isset($LOG_CAMINHO)) {
    $LOG_NIVEL = defineNivelLog();
    $identificacao = date("dmYHis") . "-PID" . getmypid() . "-" . "ttermos";
    if (isset($LOG_NIVEL)) {
        if ($LOG_NIVEL >= 1) {
            $arquivo = fopen(defineCaminhoLog() . "apilebes_ttermos" . date("dmY") . ".log", "a");
        }
    }
}
if (isset($LOG_NIVEL)) {
    if ($LOG_NIVEL == 1) {
        fwrite($arquivo, $identificacao . "\n");
    }
    if ($LOG_NIVEL >= 2) {
        fwrite($arquivo, $identificacao . "-ENTRADA->" . json_encode($jsonEntrada) . "\n");
    }
}
//LOG

$termos = array();


$progr = new chamaprogress();

$retorno = $progr->executarprogress("crediario/app/1/termos", json_encode($jsonEntrada));
fwrite($arquivo, $identificacao . "-RETORNO->" . $retorno . "\n");
$termos = json_decode($retorno, true);
if (isset($termos["conteudoSaida"][0])) { // Conteudo Saida - Caso de erro
    $termos = $termos["conteudoSaida"][0];
} else {

    if (!isset($termos["termos"][1]) && ($jsonEntrada['IDtermo'] != null)) {  // Verifica se tem mais de 1 registro
        $termos = $termos["termos"][0]; // Retorno sem array
      } else {
        $termos = $termos["termos"];
      }
  

}


$jsonSaida = $termos;


//LOG
if (isset($LOG_NIVEL)) {
    if ($LOG_NIVEL >= 2) {
        fwrite($arquivo, $identificacao . "-SAIDA->" . json_encode($jsonSaida) . "\n\n");
    }
}
//LOG

fclose($arquivo);

?>