def input param vlcentrada as longchar. /* JSON ENTRADA */
def input param vtmp       as char.     /* CAMINHO PROGRESS_TMP */

def var vlcsaida   as longchar.         /* JSON SAIDA */

def var lokjson as log.                 /* LOGICAL DE APOIO */
def var hentrada as handle.             /* HANDLE ENTRADA */
def var hsaida   as handle.             /* HANDLE SAIDA */

def temp-table ttentrada no-undo serialize-name "dadosEntrada"   /* JSON ENTRADA */
    field negcod like aconegoc.negcod
    field placod like acoplanos.placod
    FIELD titpar LIKE acoplanparcel.titpar.

def temp-table ttacoplanparcel  no-undo serialize-name "acoplanparcel"  /* JSON SAIDA */
    like acoplanparcel
    FIELD id_recid      AS INT64.    

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

IF ttentrada.titpar <> ?
then do:
        find acoplanparcel WHERE acoplanparcel.negcod = ttentrada.negcod AND
                                 acoplanparcel.placod = ttentrada.placod AND
                                 acoplanparcel.titpar = ttentrada.titpar   
                                 no-lock.
        
        create ttacoplanparcel.
        BUFFER-COPY acoplanparcel TO ttacoplanparcel.
        ttacoplanparcel.id_recid = RECID(acoplanparcel).
       
END.
ELSE DO:
    for each acoplanparcel where acoplanparcel.negcod = ttentrada.negcod  AND
                                 acoplanparcel.placod = ttentrada.placod
                                 NO-LOCK.
        create ttacoplanparcel.
        BUFFER-COPY acoplanparcel TO ttacoplanparcel.
        ttacoplanparcel.id_recid = RECID(acoplanparcel).
    END.
    
end.


find first ttacoplanparcel no-error.
if not avail ttacoplanparcel
then do:
    create ttsaida.
    ttsaida.tstatus = 400.
    ttsaida.descricaoStatus = "Nao encontrado".

    hsaida  = temp-table ttsaida:handle.

    lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).
    message string(vlcSaida).
    return.
end.

hsaida  = TEMP-TABLE ttacoplanparcel:handle.


lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).
put unformatted string(vlcSaida).
return string(vlcSaida).


