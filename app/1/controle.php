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

      case "termos":
        include 'termos.php';
      break;

      case "mnemos":
        include 'mnemos.php';
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
      case "termos":
        include 'termos_inserir.php';
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
    if ($funcao == "termos" && $parametro == "efetivar") {
      $funcao = "termos/efetivar";
      $parametro = null;
    }

    switch ($funcao) {
      case "assinaContrato":
        include 'assinaContrato.php';
        break;
    
      case "buscaTermos":
        include 'buscaTermos.php';
        break;

      case "buscaRascunho":
        include 'buscaRascunho.php';
        break;

      case "termos":
        include 'termos_alterar.php';
        break;

      case "termos/efetivar":
        include 'termos_efetivar.php';
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
      default:
        $jsonSaida = json_decode(json_encode(
        array("status" => "400",
            "retorno" => "Aplicacao " . $aplicacao . " Versao ".$versao." Funcao ".$funcao." Invalida"." Metodo ".$metodo." Invalido ")
          ), TRUE);
      break;
    }
  }
  

