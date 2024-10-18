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
ttmnemos.mnemo = "~{codCli~}".
ttmnemos.nome  = "Codigo do cliente".
create ttmnemos.
ttmnemos.mnemo = "~{nomeCliente~}".
ttmnemos.nome  = "Nome do cliente".
create ttmnemos.
ttmnemos.mnemo = "~{nomeSocial~}".
ttmnemos.nome  = "Nome Social".
create ttmnemos.
ttmnemos.mnemo = "~{cpfCnpj~}".
ttmnemos.nome  = "CPF/CNPJ do cliente".
create ttmnemos.
ttmnemos.mnemo = "~{rg~}".
ttmnemos.nome  = "RG do cliente".
create ttmnemos.
ttmnemos.mnemo = "~{dtNascimento~}".
ttmnemos.nome  = "Data de nascimento do cliente".
create ttmnemos.
ttmnemos.mnemo = "~{end.logradouro~}".
ttmnemos.nome  = "Endereco do cliente".
create ttmnemos.
ttmnemos.mnemo = "~{end.numero~}".
ttmnemos.nome  = "Numero do Endereco do cliente".
create ttmnemos.
ttmnemos.mnemo = "~{end.complemento~}".
ttmnemos.nome  = "Complemento do Endereco do cliente".
create ttmnemos.
ttmnemos.mnemo = "~{end.bairro~}".
ttmnemos.nome  = "Bairro do Endereco do cliente".
create ttmnemos.
ttmnemos.mnemo = "~{end.cidade~}".
ttmnemos.nome  = "Cidade do Endereco do cliente".
create ttmnemos.
ttmnemos.mnemo = "~{end.estado~}".
ttmnemos.nome  = "Estado do Endereco do cliente".
create ttmnemos.
ttmnemos.mnemo = "~{end.cep~}".
ttmnemos.nome  = "Endereco do cliente".
create ttmnemos.
ttmnemos.mnemo = "~{end.pais~}".
ttmnemos.nome  = "Origem do cliente".
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
ttmnemos.mnemo = "~{codLoja~}".
ttmnemos.nome  = "Filial do Contrato".
create ttmnemos.
ttmnemos.mnemo = "~{codVend~}".
ttmnemos.nome  = "Vendedor do Contrato".
create ttmnemos.
ttmnemos.mnemo = "~{dtTransacao~}".
ttmnemos.nome  = "Data de Emissao".
create ttmnemos.
ttmnemos.mnemo = "~{dtTransacao.extenso~}".
ttmnemos.nome  = "Data de Emissao por Extenso".
create ttmnemos.
ttmnemos.mnemo  = "~{nroComp~}".
ttmnemos.nome   = "Caixa da Emissao".
create ttmnemos.
ttmnemos.mnemo = "~{nroNF~}".
ttmnemos.nome  = "Numero da NF do Contrato".

create ttmnemos. 
ttmnemos.mnemo =  "<b>DADOS DO CONTRATO</b>". 
ttmnemos.nome  = "".
create ttmnemos.
ttmnemos.mnemo = "~{nroContrato~}".
ttmnemos.nome  = "Numero do Contrato".
create ttmnemos.
ttmnemos.mnemo  = "~{dtPriVen~}".
ttmnemos.nome   = "Primeiro vencimento".
create ttmnemos.
ttmnemos.mnemo  = "~{dtUltVen~}".
ttmnemos.nome   = "Ultimo vencimento".
create ttmnemos.
ttmnemos.mnemo  = "~{parc.valor~}".
ttmnemos.nome   = "Valor das parcelas do Contrato ".
create ttmnemos.
ttmnemos.mnemo  = "~{qtdParc~}".
ttmnemos.nome   = "Qtd de parcelas do Contrato ".

create ttmnemos. 
ttmnemos.mnemo =  "<b>LISTAGEM DE CONTRATOS</b>". 
ttmnemos.nome  = "".
create ttmnemos.
ttmnemos.mnemo  = "~{cont.lista~}".
ttmnemos.nome   = "".

create ttmnemos. 
ttmnemos.mnemo =  "<b>LISTAGEM DE PRODUTOS DO CONTRATO</b>". 
ttmnemos.nome  = "".
create ttmnemos.
ttmnemos.mnemo  = "~{prod.lista~}".
ttmnemos.nome   = "".

create ttmnemos. 
ttmnemos.mnemo =  "<b>LISTAGEM DE PARCELAS DO CONTRATO</b>". 
ttmnemos.nome  = "".
create ttmnemos.
ttmnemos.mnemo  = "~{parc.lista~}".
ttmnemos.nome   = "".

create ttmnemos. 
ttmnemos.mnemo =  "<b>VALORES DO CONTRATO</b>". 
ttmnemos.nome  = "".
create ttmnemos.
ttmnemos.mnemo  = "~{vlTotal~}".
ttmnemos.nome   = "valor total do contrato".
create ttmnemos.
ttmnemos.mnemo  = "~{vlEntrada~}".
ttmnemos.nome   = "valor da entrada do contrato".
create ttmnemos.
ttmnemos.mnemo  = "~{vlFinanciado~}".
ttmnemos.nome   = "vlPrinc + vlIof + vlTFC + spVlTotal".
create ttmnemos.
ttmnemos.mnemo  = "~{vlPrinc~}".
ttmnemos.nome   = "valor do principal".
create ttmnemos.
ttmnemos.mnemo  = "~{princ.perc~}".
ttmnemos.nome   = "percentual do valor do principal".
create ttmnemos.
ttmnemos.mnemo  = "~{vlAcrescimo~}".
ttmnemos.nome   = "valor do acrescimo do contrato".
create ttmnemos.
ttmnemos.mnemo  = "~{taxaMes~}".
ttmnemos.nome   = "Taxa de Juros Mensal do contrato".
create ttmnemos.
ttmnemos.mnemo  = "~{taxaAno~}".
ttmnemos.nome   = "Taxa de Juros Anual do contrato".
create ttmnemos.
ttmnemos.mnemo  = "~{cetAno~}".
ttmnemos.nome   = "CET Anual do contrato".
create ttmnemos.
ttmnemos.mnemo  = "~{cet~}".
ttmnemos.nome   = "CET do contrato".
create ttmnemos.
ttmnemos.mnemo  = "~{seguro.perc~}".
ttmnemos.nome   = "percentual seguro do contrato".
create ttmnemos.
ttmnemos.mnemo  = "~{vlIof~}".
ttmnemos.nome   = "valor IOF do contrato".
create ttmnemos.
ttmnemos.mnemo  = "~{iof.perc~}".
ttmnemos.nome   = "percentual IOF do contrato".
create ttmnemos.
ttmnemos.mnemo  = "~{vlTFC~}".
ttmnemos.nome   = "valor TFC do contrato".
create ttmnemos.
ttmnemos.mnemo  = "~{tfc.perc~}".
ttmnemos.nome   = "percentual TFC do contrato".


create ttmnemos. 
ttmnemos.mnemo =  "<b>DADOS DO SEGURO</b>". 
ttmnemos.nome  = "".
create ttmnemos.
ttmnemos.mnemo = "~{nroBilheteSP~}".
ttmnemos.nome  = "Numero Bilhete".
create ttmnemos.
ttmnemos.mnemo = "~{nroSorte~}".
ttmnemos.nome  = "Numero da Sorte".
create ttmnemos.
ttmnemos.mnemo = "~{spVlTotal~}".
ttmnemos.nome  = "Valor Total Seguro".
create ttmnemos.
ttmnemos.mnemo = "~{spVlLiq~}".
ttmnemos.nome  = "Valor Liquido Seguro".
create ttmnemos.
ttmnemos.mnemo = "~{spVlIof~}".
ttmnemos.nome  = "Valor IOF Seguro".
create ttmnemos.
ttmnemos.mnemo = "~{spIof.perc##~}".
ttmnemos.nome  = "percentual IOF Seguro (dinâmico)".
create ttmnemos.
ttmnemos.mnemo = "~{spRR~}".
ttmnemos.nome  = "remuneracao representante".
create ttmnemos.
ttmnemos.mnemo = "~{spRR.perc##~}".
ttmnemos.nome  = "percentual remuneracao representante (dinâmico)".
create ttmnemos.
ttmnemos.mnemo = "~{spDtVigIni~}".
ttmnemos.nome  = "data inicio de vigencia".
create ttmnemos.
ttmnemos.mnemo = "~{spDtVigFim~}".
ttmnemos.nome  = "data fim de vigencia".
create ttmnemos.
ttmnemos.mnemo = "~{sp27~}".
ttmnemos.nome  = "Profissional CLT (x)".
create ttmnemos.
ttmnemos.mnemo = "~{sp28~}".
ttmnemos.nome  = "Profissional Autonomo (x)".


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


