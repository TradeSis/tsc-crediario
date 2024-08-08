/* helio 17022022 - 263458 - Revis√£o da regra de nova√ß√µes  */

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
    FIELD   formatoTermo          as char 
    FIELD   tipoOperacao          as char 
    FIELD   codigoLoja          as char 
    FIELD   dataTransacao          as char 
    FIELD   codigoCliente          as char 
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
    field dataVencimento as char.


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



procedure trocamnemos.


if avail ttpedidoCartaoLebes
then do:
    if ttpedidoCartaoLebes.codigoLoja <> ?
    then tttermos.termoBase64 = replace(tttermos.termoBase64,"~{codigoLoja~}",ttpedidoCartaoLebes.codigoLoja).
    if vdataTransacao <> ?
    then tttermos.termoBase64 = replace(tttermos.termoBase64,"~{dataTransacao~}",string(vdataTransacao,"99/99/9999")).
    if vdataTransacaoExtenso <> ?
    then tttermos.termoBase64 = replace(tttermos.termoBase64,"~{dataTransacao.extenso~}",vdataTransacaoExtenso).

    /*if ttpedidoCartaoLebes.numeroComponente <> ?
    then tttermos.termoBase64 = replace(tttermos.termoBase64,"~{numeroComponente~}",ttpedidoCartaoLebes.numeroComponente).*/ /* helio-gabriel sem campo componente*/
    if ttpedidoCartaoLebes.codigoVendedor <> ?
    then tttermos.termoBase64 = replace(tttermos.termoBase64,"~{codigoVendedor~}",ttpedidoCartaoLebes.codigoVendedor).
    if ttpedidoCartaoLebes.valorTotal <> ?
    then  tttermos.termoBase64 = replace(tttermos.termoBase64,"~{valorTotal~}",ttpedidoCartaoLebes.valorTotal).
    if ttpedidoCartaoLebes.codigoCliente <>?
    then tttermos.termoBase64 = replace(tttermos.termoBase64,"~{codigoCliente~}",ttpedidoCartaoLebes.codigoCliente).
    /*if ttpedidoCartaoLebes.numeroNotaFiscal <> ?
    then tttermos.termoBase64 = replace(tttermos.termoBase64,"~{numeroNotaFiscal~}",ttpedidoCartaoLebes.numeroNotaFiscal).*/ /* helio-gabriel sem campo notafiscal*/
end.

if avail clien
then do:
    if clien.ciccgc <> ?
    then tttermos.termoBase64 = replace(tttermos.termoBase64,"~{cpfCnpjCliente~}",clien.ciccgc).

    if clien.ciins <> ?
    then tttermos.termoBase64 = replace(tttermos.termoBase64,"~{rg~}",clien.ciins). /* helio-gabriel confirmar se È o campo RG*/
    if clien.clinom <> ?
    then tttermos.termoBase64 = replace(tttermos.termoBase64,"~{nomeCliente~}",clien.clinom).
    if clien.dtnasc <> ?
    then do:
        vdataNascimento = STRING(DAY(clien.dtnasc), "99") + "/" +
                          STRING(MONTH(clien.dtnasc), "99") + "/" +
                          STRING(YEAR(clien.dtnasc), "9999").
        tttermos.termoBase64 = replace(tttermos.termoBase64,"~{dataNascimento~}",vdataNascimento).
    end.
    if clien.cep[1] <> ?
    then tttermos.termoBase64 = replace(tttermos.termoBase64,"~{endereco.cep~}",clien.cep[1]).
    if clien.endereco[1] <> ?
    then tttermos.termoBase64 = replace(tttermos.termoBase64,"~{endereco.logradouro~}",clien.endereco[1]).
    if clien.numero[1] <> ?
    then tttermos.termoBase64 = replace(tttermos.termoBase64,"~{endereco.numero~}",string(clien.numero[2])).
    if clien.compl[1] <> ?
    then tttermos.termoBase64 = replace(tttermos.termoBase64,"~{endereco.complemento~}",clien.compl[1]).
    if clien.bairro[1] <> ?
    then tttermos.termoBase64 = replace(tttermos.termoBase64,"~{endereco.bairro~}",clien.bairro[1]).
    if clien.cidade[1] <> ?
    then tttermos.termoBase64 = replace(tttermos.termoBase64,"~{endereco.cidade~}",clien.cidade[1]).
    if clien.ufecod[1] <> ?
    then tttermos.termoBase64 = replace(tttermos.termoBase64,"~{endereco.estado~}",clien.ufecod[1]).
    /*if clien.pais <> ?
    then tttermos.termoBase64 = replace(tttermos.termoBase64,"~{endereco.pais~}",clien.pais). */ /* helio-gabriel nao encontrei campo pais*/
    if clien.zona <> ?
    then tttermos.termoBase64 = replace(tttermos.termoBase64,"~{email~}",clien.zona).
    if clien.fone = ?
    then clien.fone= "".
    tttermos.termoBase64 = replace(tttermos.termoBase64,"~{telefone~}",clien.fone).

end. 

if avail ttcartaolebes
then do:

    if vparcelas-lista <> ?
    then tttermos.termoBase64 = replace(tttermos.termoBase64,"~{parcelas.lista~}",vparcelas-lista).
    if vparcelas-valor <> ?
    then tttermos.termoBase64 = replace(tttermos.termoBase64,"~{parcelas.valor~}",vparcelas-valor).
    if ttcartaoLebes.qtdParcelas <> ?
    then tttermos.termoBase64 = replace(tttermos.termoBase64,"~{qtdParcelas~}",ttcartaoLebes.qtdParcelas).
    if ttcartaoLebes.valorAcrescimo <> ?
    then tttermos.termoBase64 = replace(tttermos.termoBase64,"~{valorAcrescimo~}",ttcartaoLebes.valorAcrescimo).
    if ttcartaoLebes.numeroContrato <> ?
    then tttermos.termoBase64 = replace(tttermos.termoBase64,"~{numeroContrato~}",ttcartaoLebes.numeroContrato).
    if ttcartaoLebes.cet <> ?
    then tttermos.termoBase64 = replace(tttermos.termoBase64,"~{cet~}",ttcartaoLebes.cet).
    if ttcartaoLebes.cetAno <> ?
    then tttermos.termoBase64 = replace(tttermos.termoBase64,"~{cetAno~}",ttcartaoLebes.cetAno).
    if ttcartaoLebes.taxaMes <> ?
    then tttermos.termoBase64 = replace(tttermos.termoBase64,"~{taxaMes~}",ttcartaoLebes.taxaMes).
    if ttcartaoLebes.valorIOF <> ?
    then tttermos.termoBase64 = replace(tttermos.termoBase64,"~{valorIOF~}",ttcartaoLebes.valorIOF).
    if viofPerc <> ?
    then tttermos.termoBase64 = replace(tttermos.termoBase64,"~{iof.perc~}",trim(string(viofPerc,">>>>>>>>9.99"))).
    if vprincipal <> ?
    then tttermos.termoBase64 = replace(tttermos.termoBase64,"~{principal~}",trim(string(vprincipal,">>>>>>>>9.99"))).
    if vprincipalPerc <> ?
    then tttermos.termoBase64 = replace(tttermos.termoBase64,"~{principal.perc~}",trim(string(vprincipalPerc,">>>>>>>>9.99"))).
    
   

end.

if avail ttseguroprestamista
then do:
    
    if ttseguroprestamista.numeroApoliceSeguroPrestamista <> ?
    then tttermos.termoBase64 = replace(tttermos.termoBase64,"~{numeroApoliceSeguroPrestamista~}",ttseguroprestamista.numeroApoliceSeguroPrestamista). 

    if ttseguroprestamista.numeroSorteioSeguroPrestamista <> ?
    then tttermos.termoBase64 = replace(tttermos.termoBase64,"~{numeroSorte~}",ttseguroprestamista.numeroSorteioSeguroPrestamista).    
    
    if vvalorSeguroPrestamista <> ?
    then tttermos.termoBase64 = replace(tttermos.termoBase64,"~{sp18~}",trim(string(vvalorSeguroPrestamista,">>>>>>>>9.99"))).
    if vvalorSeguroPrestamistaLiquido <> ?                                    
    then tttermos.termoBase64 = replace(tttermos.termoBase64,"~{sp16~}",trim(string(vvalorSeguroPrestamistaLiquido,">>>>>>>>9.99"))). 
    if vvalorSeguroPrestamistaIof <> ?
    then tttermos.termoBase64 = replace(tttermos.termoBase64,"~{sp17~}",trim(string(vvalorSeguroPrestamistaIof,">>>>>>>>9.99"))).
    if vvalorSeguroPrestamista29 <> ?
    then tttermos.termoBase64 = replace(tttermos.termoBase64,"~{sp29~}",trim(string(vvalorSeguroPrestamista29,">>>>>>>>9.99"))).
    if vvalorSeguroPrestamista30 <> ?
    then tttermos.termoBase64 = replace(tttermos.termoBase64,"~{sp30~}",trim(string(vvalorSeguroPrestamista30,">>>>>>>>9.99"))). 
    
    
    if vdatainivigencia12 <> ?
    then tttermos.termoBase64 = replace(tttermos.termoBase64,"~{sp12~}",string(vdatainivigencia12,"99/99/9999")).
    else tttermos.termoBase64 = replace(tttermos.termoBase64,"~{sp12~}","").
    
    if vdatafimvigencia13 <> ?
    then tttermos.termoBase64 = replace(tttermos.termoBase64,"~{sp13~}",string(vdatafimvigencia13,"99/99/9999")).
    else tttermos.termoBase64 = replace(tttermos.termoBase64,"~{sp13~}","").
   

end.

    if vdtPriVen <> ?
        then tttermos.termoBase64 = replace(tttermos.termoBase64,"~{dataPrimeiroVencimento~}",string(vdtPriVen,"99/99/9999")).
    if vdtUltVen <> ?
        then tttermos.termoBase64 = replace(tttermos.termoBase64,"~{dataUltimoVencimento~}",string(vdtUltVen,"99/99/9999")). 
    if vvalorEntrada <> ?
        then tttermos.termoBase64 = replace(tttermos.termoBase64,"~{valorEntrada~}",string(vvalorEntrada,">>>>>>>>9.99")). /* helio-gabriel valorentrada n„o trocou mnemo*/

    if vprodutos-lista <> ?
    then tttermos.termoBase64 = replace(tttermos.termoBase64,"~{produtos.lista~}",vprodutos-lista).

end procedure.

procedure encodebase64.

set-size(vtexto) = length(tttermos.termoBase64) + 1. 
put-string(vtexto,1) = tttermos.termoBase64.
textFile = tttermos.termoBase64.
copy-lob from textFile to vtexto.
tttermos.termoBase64 = base64-encode(vtexto).
SET-SIZE(vtexto) = 0.

end procedure.


