def input param vlcentrada as longchar. /* JSON ENTRADA */
def input param vtmp       as char.     /* CAMINHO PROGRESS_TMP */

def var vlcsaida   as longchar.         /* JSON SAIDA */

def var lokjson as log.                 /* LOGICAL DE APOIO */
def var hentrada as handle.             /* HANDLE ENTRADA */
def var hsaida   as handle.             /* HANDLE SAIDA */

def temp-table ttentrada no-undo serialize-name "dadosEntrada"   /* JSON ENTRADA */
    field id_recid as int64.

def temp-table ttaoacparcela  no-undo serialize-name "aoacparcela"  /* JSON SAIDA */
    FIELD parcela like aoacparcela.parcela 
        FIELD dtvencimento LIKE aoacparcela.dtvencimento
        FIELD vlcobrado LIKE aoacparcela.vlcobrado
        FIELD contnum LIKE aoacparcela.contnum
        FIELD dtbaixa LIKE aoacparcela.dtbaixa
        FIELD situacao LIKE aoacparcela.situacao 
    FIELD nossonumero LIKE banbolorigem.nossonumero
    FIELD dtenvio LIKE banboleto.dtenvio
    FIELD bol_situacao LIKE banboleto.situacao
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

for each aoacparcela of aoacordo NO-LOCK
by aoacparcela.parcela.

  if true /*aoacordo.situacao <> "A"*/
    then do:
        find first banbolOrigem  where 
            banbolorigem.tabelaOrigem = "aoacparcela" and
            banbolorigem.chaveOrigem  = "idacordo,parcela" and
            banbolorigem.dadosOrigem  = string(aoacordo.idacordo) + "," +
                           string(aoacparcela.parcela)
            no-lock no-error.
        if avail banbolorigem
        then do:
            find banboleto of banbolorigem no-lock no-error.
        end.                    
        else do:
            find first banbolOrigem  where 
                banbolorigem.tabelaOrigem = "promessa" and
                banbolorigem.chaveOrigem  = "idacordo,contnum,parcela" and
                banbolorigem.dadosOrigem  = string(aoacordo.idacordo) + "," + string(aoacparcela.contnum) + "," +
                           string(aoacparcela.parcela)
                no-lock no-error.
            if avail banbolorigem
            then do:
                find banboleto of banbolorigem no-lock no-error.
            end.                    
        end.
        if not avail banboleto
        then do:
            find first banbolOrigem  where 
                banbolorigem.tabelaOrigem = "api/acordo,negociacaoboleto" and
                banbolorigem.chaveOrigem  = "idacordo,parcela" and
                banbolorigem.dadosOrigem  = string(aoacordo.idacordo) + "," + 
                           string(aoacparcela.parcela)
                no-lock no-error.
            if avail banbolorigem
            then do:
                find banboleto of banbolorigem no-lock no-error.
            end.
        end.

    end.

    create ttaoacparcela.
    BUFFER-COPY aoacparcela TO ttaoacparcela.
    
    IF AVAIL banbolorigem
    THEN DO:
        ttaoacparcela.nossonumero = banbolorigem.nossonumero.   
    END.
    IF AVAIL banboleto
    THEN DO:
       ttaoacparcela.dtenvio = banboleto.dtenvio.
       ttaoacparcela.bol_situacao = banboleto.situacao. 
    END.
  
    ttaoacparcela.id_recid = RECID(aoacparcela).
END.



find first ttaoacparcela no-error.
if not avail ttaoacparcela
then do:
    create ttsaida.
    ttsaida.tstatus = 400.
    ttsaida.descricaoStatus = "Nao encontrado".

    hsaida  = temp-table ttsaida:handle.

    lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).
    message string(vlcSaida).
    return.
end.

hsaida  = TEMP-TABLE ttaoacparcela:handle.


lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).
put unformatted string(vlcSaida).
return string(vlcSaida).


