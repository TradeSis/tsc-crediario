def input param vlcentrada as longchar. /* JSON ENTRADA */
def input param vtmp       as char.     /* CAMINHO PROGRESS_TMP */

def var vlcsaida   as longchar.         /* JSON SAIDA */

def var lokjson as log.                 /* LOGICAL DE APOIO */
def var hentrada as handle.             /* HANDLE ENTRADA */
def var hsaida   as handle.             /* HANDLE SAIDA */

def temp-table ttentrada no-undo serialize-name "dadosEntrada"   /* JSON ENTRADA */
    field dtenvioini like serasacli.dtenvio
    field dtenviofim like serasacli.dtenvio
    field clicod  like serasacli.clicod.
    

def temp-table ttserasacli  no-undo serialize-name "serasacli"  /* JSON SAIDA */
    LIKE serasacli
    field clinom        like clien.clinom
    field ciccgc        like clien.ciccgc
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


IF ttentrada.clicod <> ?
then do:
        find serasacli WHERE serasacli.clicod = ttentrada.clicod no-lock.
        
        RUN criaSerasacli.
       
END.
ELSE DO:
    IF ttentrada.dtenvioini = ? AND ttentrada.dtenviofim = ?
    THEN DO:
        for each serasacli where serasacli.dtenvio = ? NO-LOCK.
        
            RUN criaSerasacli.
        END.
    END.

    IF ttentrada.dtenvioini <> ? AND ttentrada.dtenviofim <> ?
    THEN DO:
       for each serasacli where serasacli.dtenvio >= ttentrada.dtenvioini AND
                                 serasacli.dtenvio <= ttentrada.dtenviofim
                                 NO-LOCK.
            RUN criaSerasacli.
        END.
    END.
END.

find first ttserasacli no-error.
if not avail ttserasacli
then do:
    create ttsaida.
    ttsaida.tstatus = 400.
    ttsaida.descricaoStatus = "Nao encontrado".

    hsaida  = temp-table ttsaida:handle.

    lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).
    message string(vlcSaida).
    return.
end.

hsaida  = TEMP-TABLE ttserasacli:handle.


lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).
put unformatted string(vlcSaida).
return string(vlcSaida).

PROCEDURE criaSerasacli.

        FIND clien OF serasacli NO-LOCK NO-ERROR.
        IF AVAIL clien
        THEN DO:
           create ttserasacli.
            BUFFER-COPY serasacli TO ttserasacli.
            ttserasacli.clinom = clien.clinom. 
            ttserasacli.ciccgc = clien.ciccgc.
            ttserasacli.id_recid = RECID(serasacli). 
        END.

END PROCEDURE.


