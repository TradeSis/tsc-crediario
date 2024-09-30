def input param vlcentrada as longchar. /* JSON ENTRADA */
def input param vtmp       as char.     /* CAMINHO PROGRESS_TMP */

def var vlcsaida   as longchar.         /* JSON SAIDA */

def var lokjson as log.                 /* LOGICAL DE APOIO */
def var hentrada as handle.             /* HANDLE ENTRADA */
def var hsaida   as handle.             /* HANDLE SAIDA */
/*
def temp-table ttentrada no-undo serialize-name "serasacli"   /* JSON ENTRADA */
    field clicod as CHAR.
*/
def temp-table ttsaida  no-undo serialize-name "conteudoSaida"  /* JSON SAIDA CASO ERRO */
    field tstatus        as int serialize-name "status"
    field descricaoStatus      as char.
/*
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
*/

def var varqcsv as char format "x(65)".

    varqcsv = "/admcom/relat/serasacli_" + 
                string(today,"99999999") + "_" + replace(string(time,"HH:MM:SS"),":","") + ".csv".




output to value(varqcsv).
put unformatted  "CNPJ_CREDOR;" 
                 "DOCUMENTO;"
                 skip.

for each serasacli where serasacli.dtenvio = ?.

    FIND clien OF serasacli NO-LOCK NO-ERROR.
    IF AVAIL clien
    THEN DO:
        put unformatted
            "000000000000" ";"
            clien.ciccgc ";"
            skip.
    END.
end.  

do on error undo:
    for each serasacli where serasacli.dtenvio = ?.
        serasacli.dtenvio = today.
    end.
end.

output close.

create ttsaida.
ttsaida.tstatus = 200.
ttsaida.descricaoStatus = "Arquivo csv gerado " + varqcsv.

hsaida  = temp-table ttsaida:handle.

lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).
put unformatted string(vlcSaida).
