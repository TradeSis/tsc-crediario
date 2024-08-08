<?php
// PROGRESS


//LOG
$LOG_CAMINHO = defineCaminhoLog();
if (isset($LOG_CAMINHO)) {
  $LOG_NIVEL = defineNivelLog();
  $identificacao = date("dmYHis") . "-PID" . getmypid() . "-" . "buscaRascunho";
  if (isset($LOG_NIVEL)) {
    if ($LOG_NIVEL >= 1) {
      $arquivo = fopen(defineCaminhoLog() . "apilebes_buscaRascunho" . date("dmY") . ".log", "a");
    }
  }
}

if (isset($LOG_NIVEL)) {
  if ($LOG_NIVEL == 1) {
    fwrite($arquivo, $identificacao . "\n");
  }
  if ($LOG_NIVEL >= 2) {
    //fwrite($arquivo, $identificacao . "-ENTRADA->" . json_encode($jsonEntrada) . "\n");
  }
}
//LOG

$termos = array();

if (isset($jsonEntrada["dadosEntrada"][0])) {
  $dadosEntrada = $jsonEntrada["dadosEntrada"];

}

$chamadaPREVENDA = "";

$progr = new chamaprogress();

if (!isset($jsonEntrada["dadosEntrada"])) {
  $jsonEntrada = (object) $jsonEntrada;
  $jsonEntradaCartaoLebes = isset($jsonEntrada->cartaoLebes[0]) ? (object) $jsonEntrada->cartaoLebes[0] : null;

  $conteudoEntrada = json_encode(
    array(
      "dadosEntrada" => array(
        "pedidoCartaoLebes" => array(
          array(
            "formatoTermo" => $jsonEntrada->formatoTermo ?? null,
            "tipoOperacao" => $jsonEntrada->tipoOperacao ?? null,
            "codigoLoja" => $jsonEntrada->codigoLoja ?? null,
            "dataTransacao" => $jsonEntrada->dataTransacao ?? null,
            "codigoCliente" => $jsonEntrada->codigoCliente ?? null,
            "idBiometria" => $jsonEntrada->idBiometria ?? null,
            "neuroIdOperacao" => $jsonEntrada->neuroIdOperacao ?? null,
            "codigoProdutoFinanceiro" => $jsonEntrada->codigoProdutoFinanceiro ?? null,
            "valorEmprestimo" => $jsonEntrada->valorEmprestimo ?? null,
            "codigoVendedor" => $jsonEntrada->codigoVendedor ?? null,
            "codigoOperador" => $jsonEntrada->codigoOperador ?? null,
            "valorTotal" => $jsonEntrada->valorTotal ?? null,
            "recebimentos" => $jsonEntrada->recebimentos ?? [],
            "cartaoLebes" => array(
              array(
                "seqForma" => $jsonEntradaCartaoLebes->seqForma ?? null,
                "numeroContrato" => $jsonEntradaCartaoLebes->numeroContrato ?? null,
                "contratoFinanceira" => $jsonEntradaCartaoLebes->contratoFinanceira ?? null,
                "cet" => $jsonEntradaCartaoLebes->cet ?? null,
                "cetAno" => $jsonEntradaCartaoLebes->cetAno ?? null,
                "taxaMes" => $jsonEntradaCartaoLebes->taxaMes ?? null,
                "valorIof" => $jsonEntradaCartaoLebes->valorIof ?? null,
                "qtdParcelas" => $jsonEntradaCartaoLebes->qtdParcelas ?? null,
                "valorTFC" => $jsonEntradaCartaoLebes->valorTFC ?? null,
                "valorAcrescimo" => $jsonEntradaCartaoLebes->valorAcrescimo ?? null,
                "parcelas" => $jsonEntradaCartaoLebes->parcelas ?? [],
                "seguroPrestamista" => array($jsonEntradaCartaoLebes->seguroPrestamista) ?? []
              )
            ),
            "contratosRenegociados" => $jsonEntrada->contratosRenegociados ?? [],
            "produtos" => $jsonEntrada->produtos ?? []
          )
        )
      )
    )
  );

  // var_dump(json_decode($conteudoEntrada));
} else {
  $conteudoEntrada = json_encode($jsonEntrada);
  $chamadaPREVENDA = "SIM";
  // var_dump($jsonEntrada);
}

fwrite($arquivo, $identificacao . "-FORMATADO->" . $conteudoEntrada . "\n");
$retorno = $progr->executarprogress("crediario/app/1/buscarascunho", $conteudoEntrada);
fwrite($arquivo, $identificacao . "-RETORNO->" . $retorno . "\n");
$termos = json_decode($retorno, true);
if (isset($termos["conteudoSaida"][0])) { // Conteudo Saida - Caso de erro
  $termos = $termos["conteudoSaida"][0];
} else {

  $termos = $termos["termos"];

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