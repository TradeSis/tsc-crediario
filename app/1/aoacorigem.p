def input param vlcentrada as longchar. /* JSON ENTRADA */
def input param vtmp       as char.     /* CAMINHO PROGRESS_TMP */

def var vlcsaida   as longchar.         /* JSON SAIDA */

def var lokjson as log.                 /* LOGICAL DE APOIO */
def var hentrada as handle.             /* HANDLE ENTRADA */
def var hsaida   as handle.             /* HANDLE SAIDA */

def temp-table ttentrada no-undo serialize-name "dadosEntrada"   /* JSON ENTRADA */
    field id_recid as int64.

def temp-table ttaoacorigem  no-undo serialize-name "aoacorigem"  /* JSON SAIDA */
    like aoacorigem
    FIELD nossonumero LIKE banbolorigem.nossonumero
    FIELD dtenvio LIKE banboleto.dtenvio
    FIELD situacao LIKE banboleto.situacao
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

find aoacordo where recid(aoacordo) = ttentrada.id_recid no-lock.

for each aoacorigem of aoacordo NO-LOCK.
    find first banbolOrigem  where 
                banbolorigem.tabelaOrigem = "api/acordo,parcelasboleto" and
                banbolorigem.chaveOrigem  = "idacordo,contnum,titpar" and
                banbolorigem.dadosOrigem  = string(aoacordo.idacordo) + "," + 
                           string(aoacorigem.contnum) + "," +
                           string(aoacorigem.titpar)
                no-lock no-error.
            if avail banbolorigem
            then do:
                find banboleto of banbolorigem no-lock no-error.
            end.
    
    create ttaoacorigem.
    BUFFER-COPY aoacorigem TO ttaoacorigem.
    
    IF AVAIL banbolorigem
    THEN DO:
        ttaoacorigem.nossonumero = banbolorigem.nossonumero.   
    END.
    IF AVAIL banboleto
    THEN DO:
       ttaoacorigem.dtenvio = banboleto.dtenvio.
    ttaoacorigem.situacao = banboleto.situacao. 
    END.
    
    ttaoacorigem.id_recid = RECID(aoacorigem).
END.



find first ttaoacorigem no-error.
if not avail ttaoacorigem
then do:
    create ttsaida.
    ttsaida.tstatus = 400.
    ttsaida.descricaoStatus = "Nao encontrado".

    hsaida  = temp-table ttsaida:handle.

    lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).
    message string(vlcSaida).
    return.
end.

hsaida  = TEMP-TABLE ttaoacorigem:handle.


lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).
put unformatted string(vlcSaida).
return string(vlcSaida).


