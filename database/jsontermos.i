/* helio 17022022 - 263458 - Revisão da regra de novações  */

def var vconteudo as char.
def var vlinha as char.
def var vid as int.
def var vparcelas-lista as char.
def var vparcelas-valor as char.
def var viofPerc as dec.
def var vvalorIOF as dec.
def var vprincipal as dec.
def var vprincipalPerc as dec.
def var vprodutos-Lista as char.
def var vcatcod as int init 0.

def var textFile AS longchar NO-UNDO.
DEF VAR vtexto     AS MEMPTR    NO-UNDO.
DEF VAR textFile64 AS LONGCHAR  NO-UNDO.
DEF VAR vlength    AS INTEGER   NO-UNDO.
def var vdataNascimento AS CHAR.
def var vdataVencimento as date.
def var vdataTransacao as date.
def var vdataTransacaoExtenso as char.
def var vdia as int.
def var vmes as int.
def var vano as int.

def var vmesext         as char format "x(10)"  extent 12
                        initial ["Janeiro" ,"Fevereiro","Marco"   ,"Abril",
                                 "Maio"    ,"Junho"    ,"Julho"   ,"Agosto",
                                 "Setembro","Outubro"  ,"Novembro","Dezembro"] .


def var vvalorSeguroPrestamista as dec init 0.
def var vcopias as int.

def var vdatainivigencia12 as date.
def var vdatafimvigencia13 as date.
def var vvalorSeguroPrestamistaLiquido as dec.
def var vvalorSeguroPrestamistaIof as dec.
def var vvalorSeguroPrestamista29 as dec.
def var vvalorSeguroPrestamista30 as dec.

  

def  temp-table tttermos no-undo serialize-name "termos"
  field sequencial as char
  field tipo    as char
  field termoBase64 as char
  field quantidadeVias  as char
  field formato    as char.


def var hEntrada     as handle.
def var hSAIDA            as handle.

DEFINE {1} shared TEMP-TABLE ttpedidoCartaoLebes NO-UNDO SERIALIZE-NAME "pedidoCartaoLebes"
    field id as char serialize-hidden
    field   rascunho              as char
    FIELD   formatoTermo          as char 
    FIELD   tipoOperacao          as char 
    FIELD   codigoLoja          as char 
    FIELD   numeroComponente     AS CHAR
    FIELD   dataTransacao          as char 
    FIELD   codigoCliente          as char 
    FIELD    numeroNotaFiscal       AS CHAR
    FIELD   idBiometria as char 
    FIELD   neuroIdOperacao as char 
    FIELD   codigoProdutoFinanceiro as char 
    FIELD   valorEmprestimo as char 
    FIELD   codigoVendedor as char 
    FIELD   codigoOperador as char 
    FIELD   valorTotal as char. 

    
DEFINE {1} shared TEMP-TABLE ttrecebimentos NO-UNDO SERIALIZE-NAME "recebimentos"
    field idpai as char serialize-hidden
    field formaPagamento as char 
    field codigoPlano as char
    field valorPago as char
    field seqForma as char.

DEFINE {1} shared TEMP-TABLE ttcartaoLebes NO-UNDO SERIALIZE-NAME "cartaoLebes"
    field idpai as char serialize-hidden
    FIELD   seqForma as char
    FIELD   numeroContrato as char 
    FIELD   contratoFinanceira as char 
    FIELD   cet as char
    FIELD   cetAno as char 
    FIELD   taxaMes as char  
    field   valorIof as char
    field   qtdParcelas as char
    field   valorTFC as char
    field   valorAcrescimo as char.
            
            

DEFINE {1} shared TEMP-TABLE ttparcelas NO-UNDO SERIALIZE-NAME "parcelas"
    field idpai as char serialize-hidden
    field seqParcela as char 
    field valorParcela as char
    field dataVencimento as char
    INDEX X seqparcela ASC.


DEFINE {1} shared TEMP-TABLE ttseguroprestamista NO-UNDO SERIALIZE-NAME "seguroprestamista"
    field idpai as char serialize-hidden
    field numeroApoliceSeguroPrestamista as char
    field numeroSorteioSeguroPrestamista as char
    field codigoSeguroPrestamista as char
    field valorSeguroPrestamista as char
    field dataInicioVigencia as char
    field dataFimVigencia as char.

DEFINE {1} shared TEMP-TABLE ttcontratosrenegociados NO-UNDO SERIALIZE-NAME "contratosrenegociados"
    field idpai as char serialize-hidden
    field contratoRenegociado as char
    field valorRenegociado as char.


DEFINE {1} shared TEMP-TABLE ttprodutos NO-UNDO SERIALIZE-NAME "produtos"
    field idpai as char serialize-hidden
    field codigoProduto as char
    field codigoMercadologico as char
    field quantidade as char
    field valorTotal as char 
    field valorUnitario as char 
    field valorTotalDesconto as char
    field tipoProduto as char.
    

DEFINE DATASET dadosEntrada FOR ttpedidoCartaoLebes, ttrecebimentos, ttcartaoLebes, ttparcelas, ttseguroprestamista, ttcontratosrenegociados, ttprodutos
    DATA-RELATION for1 FOR ttpedidoCartaoLebes, ttrecebimentos      RELATION-FIELDS(ttpedidoCartaoLebes.id,ttrecebimentos.idpai) NESTED
    DATA-RELATION for2 FOR ttpedidoCartaoLebes, ttcartaoLebes      RELATION-FIELDS(ttpedidoCartaoLebes.id,ttcartaoLebes.idpai) NESTED
    DATA-RELATION for3 FOR ttcartaoLebes, ttparcelas               RELATION-FIELDS(ttcartaoLebes.id,ttparcelas.idpai) NESTED
    DATA-RELATION for4 FOR ttcartaoLebes, ttseguroprestamista      RELATION-FIELDS(ttcartaoLebes.id,ttseguroprestamista.idpai) NESTED
    DATA-RELATION for5 FOR ttpedidoCartaoLebes, ttcontratosrenegociados RELATION-FIELDS(ttpedidoCartaoLebes.id,ttcontratosrenegociados.idpai) NESTED
    DATA-RELATION for6 FOR ttpedidoCartaoLebes, ttprodutos         RELATION-FIELDS(ttpedidoCartaoLebes.id,ttprodutos.idpai) NESTED.


DEFINE {1} shared TEMP-TABLE ttcobparam NO-UNDO SERIALIZE-NAME "parametros"
    field id as char serialize-hidden
    field carteira as char.
/*
DEFINE {1} shared TEMP-TABLE ttsaidaparcelas NO-UNDO SERIALIZE-NAME "parcelas"
    field idPai as char serialize-hidden
    field seqParcela as char 
    field valorParcela as char
    field dataVencimento as char
    field valorSeguroRateado as char.
*/

DEFINE DATASET dadosSaida FOR ttcobparam. /*, ttsaidaparcelas
    DATA-RELATION for1 FOR ttcobparam, ttsaidaparcelas         RELATION-FIELDS(ttcobparam.id,ttsaidaparcelas.idpai) NESTED.
*/
hentrada = DATASET dadosEntrada:HANDLE.
hsaida   = DATASET dadosSaida:HANDLE.

function freplace RETURNS char ( 
        input pentrada as char,
        input pmnemo as char,
        input pcampo as char):
DEF VAR psaida AS CHAR.        
    if pcampo = ? then pcampo = "".
    psaida = replace(pentrada,pmnemo,pcampo). 
    if psaida = ? THEN psaida = "".
    RETURN psaida.
END FUNCTION.



procedure trocamnemos.


if avail ttpedidoCartaoLebes
then do:
    tttermos.termoBase64 = freplace(tttermos.termoBase64,"~{codigoLoja~}",ttpedidoCartaoLebes.codigoLoja).
    tttermos.termoBase64 = freplace(tttermos.termoBase64,"~{dataTransacao~}",string(vdataTransacao,"99/99/9999")).
    tttermos.termoBase64 = freplace(tttermos.termoBase64,"~{dataTransacao.extenso~}",vdataTransacaoExtenso).
    tttermos.termoBase64 = freplace(tttermos.termoBase64,"~{numeroComponente~}",ttpedidoCartaoLebes.numeroComponente).
    tttermos.termoBase64 = freplace(tttermos.termoBase64,"~{codigoVendedor~}",ttpedidoCartaoLebes.codigoVendedor).
    tttermos.termoBase64 = freplace(tttermos.termoBase64,"~{valorTotal~}",ttpedidoCartaoLebes.valorTotal).
    tttermos.termoBase64 = freplace(tttermos.termoBase64,"~{codigoCliente~}",ttpedidoCartaoLebes.codigoCliente).
    tttermos.termoBase64 = freplace(tttermos.termoBase64,"~{numeroNotaFiscal~}",ttpedidoCartaoLebes.numeroNotaFiscal).
end.

if avail clien
then do:
    tttermos.termoBase64 = freplace(tttermos.termoBase64,"~{cpfCnpjCliente~}",clien.ciccgc).
    tttermos.termoBase64 = freplace(tttermos.termoBase64,"~{rg~}",clien.ciins). /* helio-gabriel confirmar se � o campo RG*/
    tttermos.termoBase64 = freplace(tttermos.termoBase64,"~{nomeCliente~}",clien.clinom).
    vdataNascimento = STRING(DAY(clien.dtnasc), "99") + "/" +
                          STRING(MONTH(clien.dtnasc), "99") + "/" +
                          STRING(YEAR(clien.dtnasc), "9999").
    tttermos.termoBase64 = freplace(tttermos.termoBase64,"~{dataNascimento~}",vdataNascimento).
    tttermos.termoBase64 = freplace(tttermos.termoBase64,"~{endereco.cep~}",clien.cep[1]).
    tttermos.termoBase64 = freplace(tttermos.termoBase64,"~{endereco.logradouro~}",clien.endereco[1]).
    tttermos.termoBase64 = freplace(tttermos.termoBase64,"~{endereco.numero~}",string(clien.numero[2])).
    tttermos.termoBase64 = freplace(tttermos.termoBase64,"~{endereco.complemento~}",clien.compl[1]). 
    tttermos.termoBase64 = freplace(tttermos.termoBase64,"~{endereco.bairro~}",clien.bairro[1]).
    tttermos.termoBase64 = freplace(tttermos.termoBase64,"~{endereco.cidade~}",clien.cidade[1]).
    tttermos.termoBase64 = freplace(tttermos.termoBase64,"~{endereco.estado~}",clien.ufecod[1]).
    tttermos.termoBase64 = freplace(tttermos.termoBase64,"~{endereco.pais~}","BRASIL"). 
    tttermos.termoBase64 = freplace(tttermos.termoBase64,"~{email~}",clien.zona).
    tttermos.termoBase64 = freplace(tttermos.termoBase64,"~{telefone~}",clien.fone).

end. 

if avail ttcartaolebes
then do:

    tttermos.termoBase64 = freplace(tttermos.termoBase64,"~{parcelas.lista~}",vparcelas-lista).
    tttermos.termoBase64 = freplace(tttermos.termoBase64,"~{parcelas.valor~}",vparcelas-valor).
    tttermos.termoBase64 = freplace(tttermos.termoBase64,"~{qtdParcelas~}",ttcartaoLebes.qtdParcelas).
    tttermos.termoBase64 = freplace(tttermos.termoBase64,"~{valorAcrescimo~}",ttcartaoLebes.valorAcrescimo).
    tttermos.termoBase64 = freplace(tttermos.termoBase64,"~{numeroContrato~}",ttcartaoLebes.numeroContrato).
    tttermos.termoBase64 = freplace(tttermos.termoBase64,"~{cet~}",ttcartaoLebes.cet).
    tttermos.termoBase64 = freplace(tttermos.termoBase64,"~{cetAno~}",ttcartaoLebes.cetAno).
    tttermos.termoBase64 = freplace(tttermos.termoBase64,"~{taxaMes~}",ttcartaoLebes.taxaMes).
    tttermos.termoBase64 = freplace(tttermos.termoBase64,"~{valorIOF~}",ttcartaoLebes.valorIOF).
    tttermos.termoBase64 = freplace(tttermos.termoBase64,"~{iof.perc~}",trim(string(viofPerc,">>>>>>>>9.99"))).
    tttermos.termoBase64 = freplace(tttermos.termoBase64,"~{principal~}",trim(string(vprincipal,">>>>>>>>9.99"))).
    tttermos.termoBase64 = freplace(tttermos.termoBase64,"~{principal.perc~}",trim(string(vprincipalPerc,">>>>>>>>9.99"))).
    
   

end.

if avail ttseguroprestamista
then do:
    
    tttermos.termoBase64 = freplace(tttermos.termoBase64,"~{numeroBilheteSeguroPrestamista~}",ttseguroprestamista.numeroApoliceSeguroPrestamista). 
    tttermos.termoBase64 = freplace(tttermos.termoBase64,"~{numeroSorte~}",ttseguroprestamista.numeroSorteioSeguroPrestamista).    
    tttermos.termoBase64 = freplace(tttermos.termoBase64,"~{sp18~}",trim(string(vvalorSeguroPrestamista,">>>>>>>>9.99"))).
    tttermos.termoBase64 = freplace(tttermos.termoBase64,"~{sp16~}",trim(string(vvalorSeguroPrestamistaLiquido,">>>>>>>>9.99"))). 
    tttermos.termoBase64 = freplace(tttermos.termoBase64,"~{sp17~}",trim(string(vvalorSeguroPrestamistaIof,">>>>>>>>9.99"))).
    tttermos.termoBase64 = freplace(tttermos.termoBase64,"~{sp29~}",trim(string(vvalorSeguroPrestamista29,">>>>>>>>9.99"))).
    tttermos.termoBase64 = freplace(tttermos.termoBase64,"~{sp30~}",trim(string(vvalorSeguroPrestamista30,">>>>>>>>9.99"))). 
    tttermos.termoBase64 = freplace(tttermos.termoBase64,"~{sp12~}",string(vdatainivigencia12,"99/99/9999")).
    tttermos.termoBase64 = freplace(tttermos.termoBase64,"~{sp13~}",string(vdatafimvigencia13,"99/99/9999")).

end.

    tttermos.termoBase64 = freplace(tttermos.termoBase64,"~{dataPrimeiroVencimento~}",vdtPriVen).
    tttermos.termoBase64 = freplace(tttermos.termoBase64,"~{dataUltimoVencimento~}",vdtUltVen). 
    tttermos.termoBase64 = freplace(tttermos.termoBase64,"~{valorEntrada~}",trim(string(vvalorEntrada,">>>>>>>>9.99"))).
    tttermos.termoBase64 = freplace(tttermos.termoBase64,"~{produtos.lista~}",vprodutos-lista).

end procedure.

procedure encodebase64.

set-size(vtexto) = length(tttermos.termoBase64) + 1. 
put-string(vtexto,1) = tttermos.termoBase64.
textFile = tttermos.termoBase64.
copy-lob from textFile to vtexto.
tttermos.termoBase64 = base64-encode(vtexto).
SET-SIZE(vtexto) = 0.

end procedure.





