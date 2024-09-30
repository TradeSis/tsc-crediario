output to value(varquivo).

/***       put chr(29) + chr(33) + chr(0)   skip  .      /* tamanho da fonte */
         
       
       put chr(27) + chr(97) + chr(49) /*skip*/ .       /* centraliza */

       put  chr(27) + chr(51) + chr(25)  /*skip*/   . /* espaco 1/6 entre lin */
       
       put  chr(27) + "!" + chr(30)  skip .
***/              
put "PROPOSTA DE FINANCIAMENTO/ADESAO" skip
    "PESSOA FISICA" skip.
       
/***put chr(27) + "!" + chr(8). ***/

put " " skip.

put "Filial" v-etbcod " - " string(v-pladat,"99/99/99") skip. 

put /***chr(27) + "a" + chr(48)***/ skip.    /* justifica esquerda */ 

/***put unformatted chr(27) "M" chr(49). /* Fonte B */
put unformatted chr(27) "3" chr(50). /* espaco entre lin */
***/
if contrato.modcod = "CRE" 
then do:
    put "TIPO DE OPERACAO" skip
        "(XX) CDC"  " (  ) CREDITO LOJISTA" skip
        " N: "  vcontrato  skip.
end.
if contrato.modcod begins "CP" 
then do:
    put "TIPO DE OPERACAO" skip
        "(  ) CDC"  " (  ) CREDITO LOJISTA  (XX) CREDITO PESSOAL" skip
        " N: "  vcontrato  skip.
end.
put unformatted 
    "DREBES & CIA LTDA, inscrito no CNPJ sob n 96.662.1680001-31,    " skip 
    "legalmente representado na forma do seu Contrato Social,        " skip 
    "doravante designado LOJA DREBES FINANCEIRA S.A. CREDITO " skip
    "FINANCIAMENTO E INVESTIMENTOS, inscrita no CNPJ " skip
    "sob n 11.271.860/0001-86, doravante designado FINANCEIRA." skip(2).


put "CLIENTE/FINANCIADO - Dados" skip.
put unformatted "Nome: " clien.clinom format "x(40)" skip.
put unformatted "CPF: "  clien.ciccgc format "x(16)" 
    "RG: "   clien.ciinsc format "x(11)" skip
    "Orgao Emissor: " skip
    "End.Residencial: " trim(vendereco)  skip
    "numero " trim(string(clien.numero[1]))
    " compl " trim(clien.compl[1]) skip
    "Cidade: " clien.cidade[1] skip
    "CEP: "  trim(string(clien.cep[1],"x(10)"))  " UF: " trim(string(clien.ufecod[1],"x(2)"))  skip
/*    "E-MAIL: " clien.zona format "x(50)"*/
    skip(1).                 

put "Especificacao do Credito " skip.
put unformatted "DT Financ: " string(contrato.dtinicial,"99/99/99") skip
    "DT 1Venc:  " vdtpri  skip
    "Ult.venc:  " vdtult  skip
    "CET: " vret-CET + " %" format "x(12)"
    " CET Ano: " vret-CETAnual + " %" format "x(14)" skip
    "Tx mes: " vret-Taxa + " %" format "x(8)" skip
    "N de Prest:" vparc skip
    "Valor da Prestacao: " + string(vprest,">>>>>>>9.99") format "x(40)" skip
    "         Valor IOF: " + string(dec(vret-ValorIOF),">>>>>>>9.99")
                                  + " " + 
      string((dec(vret-ValorIOF) / dec(vret-ValorFinanciado)) * 100,">>9.99%")
                                format "x(40)" skip.
if contrato.modcod <> "CRE"
then 
  put unformatted                                
    "   Outras Despesas: " + string((contrato.vlseguro + contrato.vltaxa),">>>>>>>9.99")   + " " +
       string(((contrato.vlseguro + contrato.vltaxa) / dec(vret-ValorFinanciado)) * 100,">>9.99%")  
                                    format "x(40)"  skip.
put unformatted    
    "    Valor da Venda: " + string(vvenda,">>>>>>>9.99")  + " " +
       string((vvenda / dec(vret-ValorFinanciado)) * 100,">>9.99%")  
                                    format "x(40)"  skip
    "  Valor Financiado: " + string(dec(vret-ValorFinanciado),">>>>>>>9.99")
                                    format "x(40)" skip
    "Valor Total Devido: " + string(valor-total,">>>>>>>9.99")
                                    format "x(40)"
                            /*contrato.vltotal format ">>>>>9.99"*/ skip(1).
    
if avail plani and contrato.modcod = "CRE"
then do:
    put unformatted  "Produto(s) Financiado(s):" skip.

    for each movim where movim.etbcod = plani.etbcod and
                         movim.placod = plani.placod and
                         movim.movtdc = plani.movtdc no-lock:
        find produ where produ.procod = movim.procod no-lock no-error.
        if avail produ and
           produ.proipiper <> 98
        then  
            put unformatted string(produ.procod) format "x(10)" " "
                         produ.pronom format "x(50)" skip.

    end. 
end.
else do:
    put unformatted skip(2).
end.
/* Helio 31052024 - 1.        Excluir as linhas dos prints a seguir tanto do contrato original quanto do contrato assinado/    
*put skip(1)
*    "Confirmo que os dados do CLIENTE/FINANCIADO foram" " verificados  mediante apresentacao dos documentos" skip
*    "originais necessarios."
*    skip(2).**

*put fill("-",30) format "x(30)" skip
*    "Loja/Correspondente" skip(1).
**/               
/***put unformatted chr(27) "a" chr(48).    /* justifica esquerda */ 
***/
put unformatted skip(1).
run imprime-texto.
             
put unformatted skip(1) space(30) "Eldorado do Sul, "  trim(string(day(v-pladat))) " de "
    vmescomp[month(v-pladat)] " de " string(year(v-pladat)) "."
    skip(2).
/*
put unformatted chr(27) "a" chr(49).       /* centraliza */
*/

if vassina
then do:
    put unformatted  skip(4) "<image=idbiometria>" skip.

    put unformatted
    space(30) "ASSINANTE" skip
    space(30) clien.clinom skip
    space(30) clien.ciccgc skip   
    space(30) "PDV: " v-cxacod "  Filial: " v-etbcod skip
    space(30) "Assinado em " string(contrassin.dtinclu,"99/99/9999") + " " + string(contrassin.HrIncl,"HH:MM:SS") skip
    space(30) "Metodos de autenticacao: Biometria Facial" 

    skip(1).
end.

put unformatted space(30) fill("-",65) format "x(65)" skip
    space(30) "CLIENTE"
    skip.

put unformatted space(30) fill("-",65) format "x(65)" skip
    space(30) "HASH CONTRATO ORIGINAL: " v-hash1
    skip.

if vassina
then do:
    put unformatted
    skip(1)
    space(30) "HASH CONTRATO ASSINADO: "   v-hash2
    skip.
end.

/***put unformatted chr(27) "a" chr(48).  /* justifica esquerda */
***/
/* 
put "TESTEMUNHAS:" skip(2)
    fill("-",65) format "x(65)" skip
    "Nome: " skip
    " CPF: " skip(2)
    fill("-",65) format "x(65)" skip
    "Nome: " skip
    " CPF: " skip.
*/

/**
put  unformatted skip(3)
     fill("-",65) format "x(65)" skip
    "LOJA: " v-etbcod " PDV: " v-cxacod " NSU: " v-nsu
    skip
    "HASH1: " v-hash1
    skip
    fill("-",65) format "x(65)" skip.
if vassina
then
    put  unformatted skip
    "HASH2: " v-hash2
    skip
    fill("-",65) format "x(65)" skip.
***/    


/***put unformatted chr(27) "M" chr(48). /* Fonte A */
put unformatted chr(29) "h" chr(70) /* Set bar code height */. 
put unformatted chr(29) "H" chr(2). /* Select printing position of HRI
                                       characters */
put unformatted chr(29) "w" chr(2).     /* Set bar code width */
put unformatted chr(29) "V" chr(66).    /* corta */ 
put unformatted chr(27) "@".            /* reseta */
***/
output close.

