<?php
// PROGRESS
// ALTERAR E INSERIR


$log_datahora_ini = date("dmYHis");
$acao="rfnparam_inserir"; 
$arqlog = defineCaminhoLog()."apilebes_".$acao."_".date("dmY").".log";
$arquivo = fopen($arqlog,"a");
$identificacao=$log_datahora_ini.$acao;
fwrite($arquivo,$identificacao."-ENTRADA->".json_encode($jsonEntrada)."\n");

    try {

        $progr = new chamaprogress();
        $retorno = $progr->executarprogress("crediario/app/1/financeira/rfnparam_inserir",json_encode($jsonEntrada));
        fwrite($arquivo,$identificacao."-RETORNO->".$retorno."\n");
        $conteudoSaida = json_decode($retorno,true);
        if (isset($conteudoSaida["conteudoSaida"][0])) { // Conteudo Saida - Caso de erro
            $jsonSaida = $conteudoSaida["conteudoSaida"][0];
        } 
    } 
    catch (Exception $e) {
        $jsonSaida = array(
            "status" => 500,
            "retorno" => $e->getMessage()
        );
        if ($LOG_NIVEL >= 1) {
            fwrite($arquivo, $identificacao . "-ERRO->" . $e->getMessage() . "\n");
        }
    } finally {
        // ACAO EM CASO DE ERRO (CATCH), que mesmo assim precise
    }
    //TRY-CATCH


//LOG
if (isset($LOG_NIVEL)) {
    if ($LOG_NIVEL >= 2) {
        fwrite($arquivo, $identificacao . "-SAIDA->" . json_encode($jsonSaida) . "\n\n");
    }
}
//LOG



fclose($arquivo);

?>