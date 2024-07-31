def input param vlcentrada as longchar. /* JSON ENTRADA */
def input param vtmp       as char.     /* CAMINHO PROGRESS_TMP */

def var vlcsaida   as longchar.         /* JSON SAIDA */

def var lokjson as log.                 /* LOGICAL DE APOIO */
def var hentrada as handle.             /* HANDLE ENTRADA */
def var hsaida   as handle.             /* HANDLE SAIDA */


def temp-table ttentrada no-undo serialize-name "termos"   /* JSON ENTRADA */
    field IDtermo  like termos.IDtermo.

/* {sistema/database/acentos.i} */

def temp-table tttermos  no-undo serialize-name "termos"  /* JSON SAIDA */
    FIELD IDtermo       like termos.IDtermo
    FIELD termoNome     like termos.termoNome
    FIELD termoCopias   like termos.termoCopias
    FIELD termo         as CHAR
    FIELD rascunho      as CHAR.

def temp-table ttsaida  no-undo serialize-name "conteudoSaida"  /* JSON SAIDA CASO ERRO */
    field tstatus        as int serialize-name "status"
    field retorno      as char.

def VAR vIDtermo like ttentrada.IDtermo.
def var vtexto as longchar no-undo.
def var vrascunho as longchar no-undo.

hEntrada = temp-table ttentrada:HANDLE.
lokJSON = hentrada:READ-JSON("longchar",vlcentrada, "EMPTY") no-error.
find first ttentrada no-error.


vIDtermo = ?.
if avail ttentrada
then do:
    vIDtermo = ttentrada.IDtermo.
end.

for each termos where
    (if vIDtermo = ?
     then true /* TODOS */
     else termos.IDtermo = vIDtermo) 
     no-lock.
     
    create tttermos.
    tttermos.IDtermo    = termos.IDtermo.
    tttermos.termoNome   = termos.termoNome.
    tttermos.termoCopias   = termos.termoCopias.
    
    if vIDtermo <> ?
    then do:
        copy-lob from termos.termo to vtexto.
        tttermos.termo   = vtexto.
        
        if termos.rascunho = ?
        then do:
            copy-lob from termos.termo to vrascunho.
        end.
        else do:
            copy-lob from termos.rascunho to vrascunho.
        end.
        tttermos.rascunho   = vrascunho.
    end.
    
     
end.


find first tttermos no-error.

if not avail tttermos
then do:
    create ttsaida.
    ttsaida.tstatus = 400.
    ttsaida.retorno = "termo nao encontrado".

    hsaida  = temp-table ttsaida:handle.

    lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).
    message string(vlcSaida).
    return.
end.

hsaida  = TEMP-TABLE tttermos:handle.


lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).

/* export LONG VAR*/
DEF VAR vMEMPTR AS MEMPTR  NO-UNDO.
DEF VAR vloop   AS INT     NO-UNDO.
if length(vlcsaida) > 30000
then do:
    COPY-LOB FROM vlcsaida TO vMEMPTR.
    DO vLOOP = 1 TO LENGTH(vlcsaida): 
        put unformatted GET-STRING(vMEMPTR, vLOOP, 1). 
    END.
end.
else do:
    put unformatted string(vlcSaida).
end.


