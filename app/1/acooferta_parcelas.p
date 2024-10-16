def input param vlcentrada as longchar. /* JSON ENTRADA */
def input param vtmp       as char.     /* CAMINHO PROGRESS_TMP */

def var vlcsaida   as longchar.         /* JSON SAIDA */

def var lokjson as log.                 /* LOGICAL DE APOIO */
def var hentrada as handle.             /* HANDLE ENTRADA */
def var hsaida   as handle.             /* HANDLE SAIDA */

def temp-table ttentrada no-undo serialize-name "dadosEntrada"   /* JSON ENTRADA */
    field ptpnegociacao as CHAR
    field clicod like clien.clicod
    field negcod like aconegoc.negcod
    FIELD placod LIKE acoplanos.placod INITIAL ?.

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

def var vmessage as log.
def var ptpseguro as int.
def var pvalorTotalSeguroPrestamista as dec.

vmessage = no.
{acha.i}
{aco/acordo.i new}

ptpseguro = 1.
    FIND clien WHERE clien.clicod = ttentrada.clicod NO-LOCK.

    FIND aconegoc WHERE aconegoc.negcod = ttentrada.negcod NO-LOCK.
    run calcelegiveis (input aconegoc.tpNegociacao, input ttentrada.clicod, ttentrada.negcod).
    
    FIND FIRST ttnegociacao .
    run montacondicoes (INPUT ttentrada.negcod, ttentrada.placod).
    for EACH ttparcelas:
        FIND  acoplanos OF ttparcelas NO-LOCK.
        ttparcelas.planom = acoplanos.planom.
        
        find first segprestpar where 
            segprestpar.tpseguro  = ptpseguro and
            segprestpar.categoria = "MOVEIS" and
            segprestpar.etbcod    = 0
        no-lock no-error.
                  
        pvalorTotalSeguroPrestamista    = 0.
        
        if avail segprestpar AND ttparcelas.titpar <> 0 
        then do: 
            pvalorTotalSeguroPrestamista = ttparcelas.vlr_parcela * segprestpar.percentualSeguro / 100.
            ttparcelas.segprestamista = pvalorTotalSeguroPrestamista. 
            ttparcelas.totalsegprestamista = ttparcelas.vlr_parcela + pvalorTotalSeguroPrestamista.
        end.
    end.


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


