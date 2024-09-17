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

def temp-table ttcondicoes  no-undo serialize-name "acoofertacond"  /* JSON SAIDA */
    field negcod        like aconegoc.negcod
    field planom        like acoplanos.planom
    field placod        like acoplanos.placod
    field vlr_entrada   as dec
    field min_entrada    as dec
    field vlr_acordo    as dec
    field vlr_juroacordo as dec
    field dtvenc1       as date
    field vlr_parcela   as dec
    field especial as log
    index idx is unique primary negcod asc placod asc planom asc.


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


/*def buffer bttnegociacao for ttnegociacao. */


 create ttcondicoes.
 ttcondicoes.negcod = 1.
 ttcondicoes.planom = "1+5".
 ttcondicoes.placod = 1.
 ttcondicoes.vlr_entrada = 100.
 ttcondicoes.min_entrada = 20.
 ttcondicoes.vlr_acordo = 500.
 ttcondicoes.vlr_juroacordo = 550.
 ttcondicoes.dtvenc1  = TODAY.
 ttcondicoes.vlr_parcela = 30.
 ttcondicoes.especial = TRUE.
 
 create ttcondicoes.
 ttcondicoes.negcod = 2.
 ttcondicoes.planom = "1+7".
 ttcondicoes.placod = 2.
 ttcondicoes.vlr_entrada = 200.
 ttcondicoes.min_entrada = 40.
 ttcondicoes.vlr_acordo = 1000.
 ttcondicoes.vlr_juroacordo = 1550.
 ttcondicoes.dtvenc1  = TODAY.
 ttcondicoes.vlr_parcela = 60.
 ttcondicoes.especial = FALSE.
       


        

find first ttcondicoes no-error.
if not avail ttcondicoes
then do:
    create ttsaida.
    ttsaida.tstatus = 400.
    ttsaida.descricaoStatus = "Nao encontrado".

    hsaida  = temp-table ttsaida:handle.

    lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).
    message string(vlcSaida).
    return.
end. 

hsaida  = TEMP-TABLE ttcondicoes:handle.


lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).
put unformatted string(vlcSaida).
return string(vlcSaida).


