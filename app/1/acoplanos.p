def input param vlcentrada as longchar. /* JSON ENTRADA */
def input param vtmp       as char.     /* CAMINHO PROGRESS_TMP */

def var vlcsaida   as longchar.         /* JSON SAIDA */

def var lokjson as log.                 /* LOGICAL DE APOIO */
def var hentrada as handle.             /* HANDLE ENTRADA */
def var hsaida   as handle.             /* HANDLE SAIDA */

def temp-table ttentrada no-undo serialize-name "dadosEntrada"   /* JSON ENTRADA */
    field placod like acoplanos.placod
    field negcod like aconegoc.negcod.

def temp-table ttacoplanos  no-undo serialize-name "acoplanos"  /* JSON SAIDA */
    like acoplanos
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

IF ttentrada.placod <> ?
then do:
        find acoplanos WHERE acoplanos.placod = ttentrada.placod AND
        acoplanos.negcod = ttentrada.negcod no-lock.
        
        create ttacoplanos.
        BUFFER-COPY acoplanos TO ttacoplanos.
        ttacoplanos.id_recid = RECID(acoplanos).
       
END.
ELSE DO:
    for each acoplanos where acoplanos.negcod = ttentrada.negcod  NO-LOCK.
        create ttacoplanos.
        BUFFER-COPY acoplanos TO ttacoplanos.
        ttacoplanos.id_recid = RECID(acoplanos).
    END.
    
end.


find first ttacoplanos no-error.
if not avail ttacoplanos
then do:
    create ttsaida.
    ttsaida.tstatus = 400.
    ttsaida.descricaoStatus = "Nao encontrado".

    hsaida  = temp-table ttsaida:handle.

    lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).
    message string(vlcSaida).
    return.
end.

hsaida  = TEMP-TABLE ttacoplanos:handle.


lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).
put unformatted string(vlcSaida).
return string(vlcSaida).


