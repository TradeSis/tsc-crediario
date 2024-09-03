def input param vlcentrada as longchar. /* JSON ENTRADA */
def input param vtmp       as char.     /* CAMINHO PROGRESS_TMP */

def var vlcsaida   as longchar.         /* JSON SAIDA */

def var lokjson as log.                 /* LOGICAL DE APOIO */
def var hentrada as handle.             /* HANDLE ENTRADA */
def var hsaida   as handle.             /* HANDLE SAIDA */



def temp-table ttmnemos  no-undo serialize-name "mnemos"  /* JSON SAIDA */
    field mnemo as char format "x(25)"
    field nome   as char format "x(25)".

def temp-table ttsaida  no-undo serialize-name "conteudoSaida"  /* JSON SAIDA CASO ERRO */
    field tstatus        as int serialize-name "status"
    field retorno      as char.

create ttmnemos. 
ttmnemos.mnemo =  "<b>DADOS DO CLIENTE</b>". 
ttmnemos.nome  = "".
create ttmnemos.
ttmnemos.mnemo = "~{codigoCliente~}".
ttmnemos.nome  = "Codigo do cliente".
create ttmnemos.
ttmnemos.mnemo = "~{nomeCliente~}".
ttmnemos.nome  = "Nome do cliente".
create ttmnemos.
ttmnemos.mnemo = "~{cpfCnpjCliente~}".
ttmnemos.nome  = "CPF/CNPJdo cliente".
create ttmnemos.
ttmnemos.mnemo = "~{rg~}".
ttmnemos.nome  = "RG do cliente".
create ttmnemos.
ttmnemos.mnemo = "~{endereco.logradouro~}".
ttmnemos.nome  = "Endereco do cliente".
create ttmnemos.
ttmnemos.mnemo = "~{endereco.numero~}".
ttmnemos.nome  = "Numero do Endereco do cliente".
create ttmnemos.
ttmnemos.mnemo = "~{endereco.complemento~}".
ttmnemos.nome  = "Complemento do Endereco do cliente".
create ttmnemos.
ttmnemos.mnemo = "~{endereco.bairro~}".
ttmnemos.nome  = "Bairro do Endereco do cliente".
create ttmnemos.
ttmnemos.mnemo = "~{endereco.cidade~}".
ttmnemos.nome  = "Cidade do Endereco do cliente".
create ttmnemos.
ttmnemos.mnemo = "~{endereco.estado~}".
ttmnemos.nome  = "Estado do Endereco do cliente".
create ttmnemos.
ttmnemos.mnemo = "~{endereco.cep~}".
ttmnemos.nome  = "Endereco do cliente".
create ttmnemos.
ttmnemos.mnemo = "~{email~}".
ttmnemos.nome  = "Email do cliente".
create ttmnemos.
ttmnemos.mnemo = "~{telefone~}".
ttmnemos.nome  = "Telefone do cliente".


create ttmnemos. 
ttmnemos.mnemo =  "<b>DADOS DA OPERACAO</b>". 
ttmnemos.nome  = "".
create ttmnemos.
ttmnemos.mnemo = "~{codigoLoja~}".
ttmnemos.nome  = "Filial do Contrato".
create ttmnemos.
ttmnemos.mnemo = "~{codigoVendedor~}".
ttmnemos.nome  = "Vendedor do Contrato".
create ttmnemos.
ttmnemos.mnemo = "~{dataTransacao~}".
ttmnemos.nome  = "Data de Emissao".
create ttmnemos.
ttmnemos.mnemo  = "~{numeroComponente~}".
ttmnemos.nome   = "Caixa da Emissao".
create ttmnemos.
ttmnemos.mnemo = "~{numeroNotaFiscal~}".
ttmnemos.nome  = "Numero da NF do Contrato".

create ttmnemos. 
ttmnemos.mnemo =  "<b>DADOS DO CONTRATO</b>". 
ttmnemos.nome  = "".
create ttmnemos.
ttmnemos.mnemo = "~{numeroContrato~}".
ttmnemos.nome  = "Numero do Contrato".
create ttmnemos.
ttmnemos.mnemo  = "~{dataPrimeiroVencimento~}".
ttmnemos.nome   = "Primeiro vencimento".
create ttmnemos.
ttmnemos.mnemo  = "~{dataUltimoVencimento~}".
ttmnemos.nome   = "Ultimo vencimento".
create ttmnemos.
ttmnemos.mnemo  = "~{parcelas.valor}~}".
ttmnemos.nome   = "Valor das parcelas do Contrato ".
create ttmnemos.
ttmnemos.mnemo  = "~{qtdParcelas}~}".
ttmnemos.nome   = "Qtd de parcelas do Contrato ".

create ttmnemos. 
ttmnemos.mnemo =  "<b>LISTAGEM DE PRODUTOS DO CONTRATO</b>". 
ttmnemos.nome  = "".
create ttmnemos.
ttmnemos.mnemo  = "~{produtos.lista}~}".
ttmnemos.nome   = "".

create ttmnemos. 
ttmnemos.mnemo =  "<b>LISTAGEM DE PARCELAS DO CONTRATO</b>". 
ttmnemos.nome  = "".
create ttmnemos.
ttmnemos.mnemo  = "~{parcelas.lista}~}".
ttmnemos.nome   = "".

create ttmnemos. 
ttmnemos.mnemo =  "<b>VALORES DO CONTRATO</b>". 
ttmnemos.nome  = "".
create ttmnemos.
ttmnemos.mnemo  = "~{valorTotal~}".
ttmnemos.nome   = "valor total do contrato".
create ttmnemos.
ttmnemos.mnemo  = "~{valorEntrada~}".
ttmnemos.nome   = "valor da entrada do contrato".
create ttmnemos.
ttmnemos.mnemo  = "~{principal~}".
ttmnemos.nome   = "valor do principal".
create ttmnemos.
ttmnemos.mnemo  = "~{valorAcrescimo~}".
ttmnemos.nome   = "valor do acrescimo do contrato".
create ttmnemos.
ttmnemos.mnemo  = "~{taxaMes~}".
ttmnemos.nome   = "Taxa de Juros do contrato".
create ttmnemos.
ttmnemos.mnemo  = "~{cetAno~}".
ttmnemos.nome   = "CET Anual do contrato".
create ttmnemos.
ttmnemos.mnemo  = "~{cet~}".
ttmnemos.nome   = "CET do contrato".
create ttmnemos.
ttmnemos.mnemo  = "~{valorIof~}".
ttmnemos.nome   = "valor IOF do contrato".
create ttmnemos.
ttmnemos.mnemo  = "~{iof.perc~}".
ttmnemos.nome   = "percentual IOF do contrato".

create ttmnemos. 
ttmnemos.mnemo =  "<b>DADOS DO SEGURO</b>". 
ttmnemos.nome  = "".
create ttmnemos.
ttmnemos.mnemo = "~{numeroBilheteSeguroPrestamista~}".
ttmnemos.nome  = "Numero Bilhete".


hsaida  = TEMP-TABLE ttmnemos:handle.


lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).

/* export LONG VAR*/
DEF VAR vMEMPTR AS MEMPTR  NO-UNDO.
DEF VAR vloop   AS INT     NO-UNDO.
if length(vlcsaida) > 30000
then do:
    COPY-LOB FROM vlcsaida TO vMEMPTR.
    DO vLOOP = 1 TO LENGTH(vlcsaida): 
        put unformatted GET-STRING(vMEMPTR, vLOOP, 1). 
    END.
end.
else do:
    put unformatted string(vlcSaida).
end.


