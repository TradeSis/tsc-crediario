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
   
def temp-table ttsaida  no-undo serialize-name "conteudoSaida"  /* JSON SAIDA CASO ERRO */
    field tstatus        as int serialize-name "status"
    field descricaoStatus      as char.

def var vmessage as log.
vmessage = no.

{acha.i}
{aco/acordo.i new} 

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

    FIND clien WHERE clien.clicod = ttentrada.clicod NO-LOCK.

    FIND aconegoc WHERE aconegoc.negcod = ttentrada.negcod NO-LOCK.
    run calcelegiveis (input aconegoc.tpNegociacao, input ttentrada.clicod, ttentrada.negcod).
    
    FIND FIRST ttnegociacao .
    run montacondicoes (INPUT ttentrada.negcod, ?).
        
/*

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
       
  */

        

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


