<?php

//echo "metodo=".$metodo."\n";
//echo "funcao=".$funcao."\n";
//echo "parametro=".$parametro."\n";

if ($metodo=="GET"){
    switch ($funcao) {
      case "cliente":
        include 'crediariocliente.php';
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

      case "estab":
        include 'estab.php';
      break;

      case "assinatura":
        include 'contrassin.php';
      break;

      case "aconegoc":
        include 'aconegoc.php';
      break;

      case "acoplanos":
        include 'acoplanos.php';
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
      case "aconegoc":
        include 'aconegoc_inserir.php';
      break;

      case "acoplanos":
        include 'acoplanos_inserir.php';
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

      case "aconegoc":
        include 'aconegoc_alterar.php';
      break;

      case "acoplanos":
        include 'acoplanos_alterar.php';
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

      default:
        $jsonSaida = json_decode(json_encode(
        array("status" => "400",
            "retorno" => "Aplicacao " . $aplicacao . " Versao ".$versao." Funcao ".$funcao." Invalida"." Metodo ".$metodo." Invalido ")
          ), TRUE);
      break;
    }
  }
  

