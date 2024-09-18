def input param vlcentrada as longchar. /* JSON ENTRADA */
def input param vtmp       as char.     /* CAMINHO PROGRESS_TMP */

def var vlcsaida   as longchar.         /* JSON SAIDA */

def var lokjson as log.                 /* LOGICAL DE APOIO */
def var hentrada as handle.             /* HANDLE ENTRADA */
def var hsaida   as handle.             /* HANDLE SAIDA */

def temp-table ttentrada no-undo serialize-name "dadosEntrada"   /* JSON ENTRADA */
    field ptpnegociacao as CHAR
    field clicod like clien.clicod
    field negcod like aconegoc.negcod.

def temp-table ttparcelas  no-undo serialize-name "parcelas"  /* JSON SAIDA */
    field negcod        like aconegoc.negcod
    field planom        like acoplanos.planom
    field placod        like acoplanos.placod
    field titpar        as int format ">>9" label "parc"
    field perc_parcela  as dec decimals 6 format ">>>9.999999%" label "perc"
    field dtvenc        as date format "99/99/9999"
    field vlr_parcela   as dec format ">>>>>9.99" label "vlr parcela"
    index idx is unique primary negcod asc placod asc planom asc titpar asc.


def temp-table ttsaida  no-undo serialize-name "conteudoSaida"  /* JSON SAIDA CASO ERRO */
    field tstatus        as int serialize-name "status"
    field descricaoStatus      as char.

hEntrada = temp-table ttentrada:HANDLE.
lokJSON = hentrada:READ-JSON("longchar",vlcentrada, "EMPTY") no-error.

find first ttentrada no-error.
if not avail ttentrada
then do:
    create ttsaida.
    ttsaida.tstatus = 400.
    ttsaida.descricaoStatus = "Dados de Entrada nao encontrados".

    hsaida  = temp-table ttsaida:handle.

    lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).
    message string(vlcSaida).
    return.
end.

def var ptpnegociacao as char.
def var par-clicod like clien.clicod.
def var vmessage as log.

ptpnegociacao = ttentrada.ptpnegociacao.
par-clicod = ttentrada.clicod.
vmessage = no.

/*{/admcom/progr/aco/acordo.i new} */

 create ttparcelas.
 ttparcelas.negcod = 1.
 ttparcelas.planom = "1+5".
 ttparcelas.placod = 1. 
 ttparcelas.titpar = 1.
 ttparcelas.perc_parcela = 10.
 ttparcelas.dtvenc = today.
 ttparcelas.vlr_parcela = 110.
 
 create ttparcelas.
 ttparcelas.negcod = 2.
 ttparcelas.planom = "1+7".
 ttparcelas.placod = 2. 
 ttparcelas.titpar = 2.
 ttparcelas.perc_parcela = 20.
 ttparcelas.dtvenc = today.
 ttparcelas.vlr_parcela = 220.

  

find first ttparcelas no-error.
if not avail ttparcelas
then do:
    create ttsaida.
    ttsaida.tstatus = 400.
    ttsaida.descricaoStatus = "Nao encontrado".

    hsaida  = temp-table ttsaida:handle.

    lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).
    message string(vlcSaida).
    return.
end. 

hsaida  = TEMP-TABLE ttparcelas:handle.


lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).
put unformatted string(vlcSaida).
return string(vlcSaida).


