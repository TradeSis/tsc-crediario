<?php

//echo "metodo=".$metodo."\n";
//echo "funcao=".$funcao."\n";
//echo "parametro=".$parametro."\n";

if ($metodo=="GET"){
  if ($funcao == "cliente" && $parametro == "historico") {
    $funcao = "cliente/historico";
    $parametro = null;
  }

    switch ($funcao) {
      case "cliente":
        include 'crediariocliente.php';
      break;
      case "cliente/historico":
        include 'historicocliente.php';
      break;
      case "contrato":
        include 'crediariocontrato.php';
      break;

      case "cupomcashback":
        include 'cupomcashbackcliente.php';
      break;

      case "seguros":
        include 'seguros.php';
      break;

      case "filacredito":
        include 'filacredito.php';
      break;

      case "assinatura":
        include 'contrassin.php';
      break;

      case "parametrizacao":
        include 'boletagparam.php';
      break;

      case "boletos":
        include 'boletagbol.php';
      break;

      case "boleto":
        include 'boletagboleto.php';
      break;

      case "contrassinestab":
        include 'contrassinestab.php';
      break;

      case "finan":
        include 'finan.php';
      break;

      case "parametroscarteira":
        include 'parametroscarteira.php';
      break;

      case "parametrosproduto":
        include 'parametrosproduto.php';
      break;


      default:
        $jsonSaida = json_decode(json_encode(
        array("status" => "400",
            "retorno" => "Aplicacao " . $aplicacao . " Versao ".$versao." Funcao ".$funcao." Invalida"." Metodo ".$metodo." Invalido ")
          ), TRUE);
      break;
    }
  }

 if ($metodo=="PUT"){
    switch ($funcao) {
      case "parametrizacao":
        include 'boletagparam_inserir.php';
      break;

      case "parametroscarteira":
        include 'parametroscarteira_inserir.php';
      break;

      case "parametrosproduto":
        include 'parametrosproduto_inserir.php';
      break;

      default:
        $jsonSaida = json_decode(json_encode(
        array("status" => "400",
            "retorno" => "Aplicacao " . $aplicacao . " Versao ".$versao." Funcao ".$funcao." Invalida"." Metodo ".$metodo." Invalido ")
          ), TRUE);
      break;
    }
  }
  
  if ($metodo=="POST"){
    switch ($funcao) {
      case "assinaContrato":
        include 'assinaContrato.php';
        break;

      case "parametrizacao":
        include 'boletagparam_alterar.php';
      break;

      case "parametroscarteira":
        include 'parametroscarteira_alterar.php';
      break;

      case "parametrosproduto":
        include 'parametrosproduto_alterar.php';
      break;

      default:
        $jsonSaida = json_decode(json_encode(
        array("status" => "400",
            "retorno" => "Aplicacao " . $aplicacao . " Versao ".$versao." Funcao ".$funcao." Invalida"." Metodo ".$metodo." Invalido ")
          ), TRUE);
      break;
    }
  }
  
  if ($metodo=="DELETE"){
    switch ($funcao) {

      case "parametroscarteira":
        include 'parametroscarteira_excluir.php';
      break;

      case "parametrosproduto":
        include 'parametrosproduto_excluir.php';
      break;

      default:
        $jsonSaida = json_decode(json_encode(
        array("status" => "400",
            "retorno" => "Aplicacao " . $aplicacao . " Versao ".$versao." Funcao ".$funcao." Invalida"." Metodo ".$metodo." Invalido ")
          ), TRUE);
      break;
    }
  }
  

