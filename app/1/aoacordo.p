def input param vlcentrada as longchar. /* JSON ENTRADA */
def input param vtmp       as char.     /* CAMINHO PROGRESS_TMP */

def var vlcsaida   as longchar.         /* JSON SAIDA */

def var lokjson as log.                 /* LOGICAL DE APOIO */
def var hentrada as handle.             /* HANDLE ENTRADA */
def var hsaida   as handle.             /* HANDLE SAIDA */

def temp-table ttentrada no-undo serialize-name "dadosEntrada"   /* JSON ENTRADA */
    field IDAcordo like aoacordo.IDAcordo.

def temp-table ttaoacordo  no-undo serialize-name "aoacordo"  /* JSON SAIDA */
    like aoacordo
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

IF ttentrada.IDAcordo <> ?
then do:
        find aoacordo WHERE aoacordo.IDAcordo = ttentrada.IDAcordo no-lock.
        
        create ttaoacordo.
        BUFFER-COPY aoacordo TO ttaoacordo.
        ttaoacordo.id_recid = RECID(aoacordo).
       
END.
ELSE DO:
    for each aoacordo NO-LOCK.
        create ttaoacordo.
        BUFFER-COPY aoacordo TO ttaoacordo.
        ttaoacordo.id_recid = RECID(aoacordo).
    END.
    
end.


find first ttaoacordo no-error.
if not avail ttaoacordo
then do:
    create ttsaida.
    ttsaida.tstatus = 400.
    ttsaida.descricaoStatus = "Nao encontrado".

    hsaida  = temp-table ttsaida:handle.

    lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).
    message string(vlcSaida).
    return.
end.

hsaida  = TEMP-TABLE ttaoacordo:handle.


lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).
put unformatted string(vlcSaida).
return string(vlcSaida).


