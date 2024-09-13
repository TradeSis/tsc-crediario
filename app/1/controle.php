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

      case "aconegoc":
        include 'aconegoc.php';
      break;

      case "acoplanos":
        include 'acoplanos.php';

      break;

      case "acoplanparcel":
        include 'acoplanparcel.php';
      break;

      case "serasacli":
        include 'serasacli.php';
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


      case "aconegoc":
        include 'aconegoc_inserir.php';
      break;

      case "acoplanos":
        include 'acoplanos_inserir.php';
      break;

      case "serasacli":
        include 'serasacli_inserir.php';
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

      case "aconegoc":
        include 'aconegoc_alterar.php';
      break;

      case "acoplanos":
        include 'acoplanos_alterar.php';
      break;

      case "acoplanparcel":
        include 'acoplanparcel_alterar.php';
      break;

      case "serasacli_arquivo":
        include 'serasacli_arquivo.php';
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
      case "aconegoc":
        include 'aconegoc_excluir.php';
      break;

      case "acoplanos":
        include 'acoplanos_excluir.php';
      break;

      case "serasacli":
        include 'serasacli_excluir.php';
      break;

      default:
        $jsonSaida = json_decode(json_encode(
        array("status" => "400",
            "retorno" => "Aplicacao " . $aplicacao . " Versao ".$versao." Funcao ".$funcao." Invalida"." Metodo ".$metodo." Invalido ")
          ), TRUE);
      break;
    }
  }
  

