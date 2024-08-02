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

DEFINE VARIABLE textFile AS LONGCHAR NO-UNDO.
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
  field id as char
  field data    as char
  field codigo  as char
  field conteudo as char
  field extensao    as char
  field nome        as char
  field tipo as char.


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
    then tttermos.conteudo = replace(tttermos.conteudo,"~{codigoLoja~}",ttpedidoCartaoLebes.codigoLoja).
    if vdataTransacao <> ?
    then tttermos.conteudo = replace(tttermos.conteudo,"~{dataTransacao~}",string(vdataTransacao,"99/99/9999")).
    if vdataTransacaoExtenso <> ?
    then tttermos.conteudo = replace(tttermos.conteudo,"~{dataTransacao.extenso~}",vdataTransacaoExtenso).

    /*if ttpedidoCartaoLebes.numeroComponente <> ?
    then tttermos.conteudo = replace(tttermos.conteudo,"~{numeroComponente~}",ttpedidoCartaoLebes.numeroComponente).*/ /* helio-gabriel sem campo componente*/
    if ttpedidoCartaoLebes.codigoVendedor <> ?
    then tttermos.conteudo = replace(tttermos.conteudo,"~{codigoVendedor~}",ttpedidoCartaoLebes.codigoVendedor).
    if ttpedidoCartaoLebes.valorTotal <> ?
    then  tttermos.conteudo = replace(tttermos.conteudo,"~{valorTotal~}",ttpedidoCartaoLebes.valorTotal).
    if ttpedidoCartaoLebes.codigoCliente <>?
    then tttermos.conteudo = replace(tttermos.conteudo,"~{codigoCliente~}",ttpedidoCartaoLebes.codigoCliente).
    /*if ttpedidoCartaoLebes.numeroNotaFiscal <> ?
    then tttermos.conteudo = replace(tttermos.conteudo,"~{numeroNotaFiscal~}",ttpedidoCartaoLebes.numeroNotaFiscal).*/ /* helio-gabriel sem campo notafiscal*/
end.

if avail clien
then do:
    if clien.ciccgc <> ?
    then tttermos.conteudo = replace(tttermos.conteudo,"~{cpfCnpjCliente~}",clien.ciccgc).

    if clien.ciins <> ?
    then tttermos.conteudo = replace(tttermos.conteudo,"~{rg~}",clien.ciins). /* helio-gabriel confirmar se È o campo RG*/
    if clien.clinom <> ?
    then tttermos.conteudo = replace(tttermos.conteudo,"~{nomeCliente~}",clien.clinom).
    if clien.dtnasc <> ?
    then do:
        vdataNascimento = STRING(DAY(clien.dtnasc), "99") + "/" +
                          STRING(MONTH(clien.dtnasc), "99") + "/" +
                          STRING(YEAR(clien.dtnasc), "9999").
        tttermos.conteudo = replace(tttermos.conteudo,"~{dataNascimento~}",vdataNascimento).
    end.
    if clien.cep[1] <> ?
    then tttermos.conteudo = replace(tttermos.conteudo,"~{endereco.cep~}",clien.cep[1]).
    if clien.endereco[1] <> ?
    then tttermos.conteudo = replace(tttermos.conteudo,"~{endereco.logradouro~}",clien.endereco[1]).
    if clien.numero[1] <> ?
    then tttermos.conteudo = replace(tttermos.conteudo,"~{endereco.numero~}",string(clien.numero[2])).
    if clien.compl[1] <> ?
    then tttermos.conteudo = replace(tttermos.conteudo,"~{endereco.complemento~}",clien.compl[1]).
    if clien.bairro[1] <> ?
    then tttermos.conteudo = replace(tttermos.conteudo,"~{endereco.bairro~}",clien.bairro[1]).
    if clien.cidade[1] <> ?
    then tttermos.conteudo = replace(tttermos.conteudo,"~{endereco.cidade~}",clien.cidade[1]).
    if clien.ufecod[1] <> ?
    then tttermos.conteudo = replace(tttermos.conteudo,"~{endereco.estado~}",clien.ufecod[1]).
    /*if clien.pais <> ?
    then tttermos.conteudo = replace(tttermos.conteudo,"~{endereco.pais~}",clien.pais). */ /* helio-gabriel nao encontrei campo pais*/
    if clien.zona <> ?
    then tttermos.conteudo = replace(tttermos.conteudo,"~{email~}",clien.zona).
    if clien.fone = ?
    then clien.fone= "".
    tttermos.conteudo = replace(tttermos.conteudo,"~{telefone~}",clien.fone).

end. 

if avail ttcartaolebes
then do:

    if vparcelas-lista <> ?
    then tttermos.conteudo = replace(tttermos.conteudo,"~{parcelas.lista~}",vparcelas-lista).
    if vparcelas-valor <> ?
    then tttermos.conteudo = replace(tttermos.conteudo,"~{parcelas.valor~}",vparcelas-valor).
    if ttcartaoLebes.qtdParcelas <> ?
    then tttermos.conteudo = replace(tttermos.conteudo,"~{qtdParcelas~}",ttcartaoLebes.qtdParcelas).
    if ttcartaoLebes.valorAcrescimo <> ?
    then tttermos.conteudo = replace(tttermos.conteudo,"~{valorAcrescimo~}",ttcartaoLebes.valorAcrescimo).
    if ttcartaoLebes.numeroContrato <> ?
    then tttermos.conteudo = replace(tttermos.conteudo,"~{numeroContrato~}",ttcartaoLebes.numeroContrato).
    if ttcartaoLebes.cet <> ?
    then tttermos.conteudo = replace(tttermos.conteudo,"~{cet~}",ttcartaoLebes.cet).
    if ttcartaoLebes.cetAno <> ?
    then tttermos.conteudo = replace(tttermos.conteudo,"~{cetAno~}",ttcartaoLebes.cetAno).
    if ttcartaoLebes.taxaMes <> ?
    then tttermos.conteudo = replace(tttermos.conteudo,"~{taxaMes~}",ttcartaoLebes.taxaMes).
    if ttcartaoLebes.valorIOF <> ?
    then tttermos.conteudo = replace(tttermos.conteudo,"~{valorIOF~}",ttcartaoLebes.valorIOF).
    if viofPerc <> ?
    then tttermos.conteudo = replace(tttermos.conteudo,"~{iof.perc~}",trim(string(viofPerc,">>>>>>>>9.99"))).
    if vprincipal <> ?
    then tttermos.conteudo = replace(tttermos.conteudo,"~{principal~}",trim(string(vprincipal,">>>>>>>>9.99"))).
    if vprincipalPerc <> ?
    then tttermos.conteudo = replace(tttermos.conteudo,"~{principal.perc~}",trim(string(vprincipalPerc,">>>>>>>>9.99"))).
    
   

end.

if avail ttseguroprestamista
then do:
    
    if ttseguroprestamista.numeroApoliceSeguroPrestamista <> ?
    then tttermos.conteudo = replace(tttermos.conteudo,"~{numeroApoliceSeguroPrestamista~}",ttseguroprestamista.numeroApoliceSeguroPrestamista). 

    if ttseguroprestamista.numeroSorteioSeguroPrestamista <> ?
    then tttermos.conteudo = replace(tttermos.conteudo,"~{numeroSorte~}",ttseguroprestamista.numeroSorteioSeguroPrestamista).    
    
    if vvalorSeguroPrestamista <> ?
    then tttermos.conteudo = replace(tttermos.conteudo,"~{sp18~}",trim(string(vvalorSeguroPrestamista,">>>>>>>>9.99"))).
    if vvalorSeguroPrestamistaLiquido <> ?                                    
    then tttermos.conteudo = replace(tttermos.conteudo,"~{sp16~}",trim(string(vvalorSeguroPrestamistaLiquido,">>>>>>>>9.99"))). 
    if vvalorSeguroPrestamistaIof <> ?
    then tttermos.conteudo = replace(tttermos.conteudo,"~{sp17~}",trim(string(vvalorSeguroPrestamistaIof,">>>>>>>>9.99"))).
    if vvalorSeguroPrestamista29 <> ?
    then tttermos.conteudo = replace(tttermos.conteudo,"~{sp29~}",trim(string(vvalorSeguroPrestamista29,">>>>>>>>9.99"))).
    if vvalorSeguroPrestamista30 <> ?
    then tttermos.conteudo = replace(tttermos.conteudo,"~{sp30~}",trim(string(vvalorSeguroPrestamista30,">>>>>>>>9.99"))). 
    
    
    if vdatainivigencia12 <> ?
    then tttermos.conteudo = replace(tttermos.conteudo,"~{sp12~}",string(vdatainivigencia12,"99/99/9999")).
    else tttermos.conteudo = replace(tttermos.conteudo,"~{sp12~}","").
    
    if vdatafimvigencia13 <> ?
    then tttermos.conteudo = replace(tttermos.conteudo,"~{sp13~}",string(vdatafimvigencia13,"99/99/9999")).
    else tttermos.conteudo = replace(tttermos.conteudo,"~{sp13~}","").
   

end.

    if vdtPriVen <> ?
        then tttermos.conteudo = replace(tttermos.conteudo,"~{dataPrimeiroVencimento~}",string(vdtPriVen,"99/99/9999")).
    if vdtUltVen <> ?
        then tttermos.conteudo = replace(tttermos.conteudo,"~{dataUltimoVencimento~}",string(vdtUltVen,"99/99/9999")). 
    if vvalorEntrada <> ?
        then tttermos.conteudo = replace(tttermos.conteudo,"~{valorEntrada~}",string(vvalorEntrada,">>>>>>>>9.99")). /* helio-gabriel valorentrada n„o trocou mnemo*/

    if vprodutos-lista <> ?
    then tttermos.conteudo = replace(tttermos.conteudo,"~{produtos.lista~}",vprodutos-lista).

end procedure.


