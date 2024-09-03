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
    if ($funcao == "termos" && $parametro == "rascunho") {
      $funcao = "termos/rascunho";
      $parametro = null;
    }

    switch ($funcao) {
      case "assinaContrato":
        include 'assinaContrato.php';
        break;
    
      case "termos":
        include 'termos_alterar.php';
        break;

      case "termos/rascunho":
        include 'termos_rascunho.php';
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
  

