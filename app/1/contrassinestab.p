def input param vlcentrada as longchar. /* JSON ENTRADA */
def input param vtmp       as char.     /* CAMINHO PROGRESS_TMP */

def var vlcsaida   as longchar.         /* JSON SAIDA */

def var lokjson as log.                 /* LOGICAL DE APOIO */
def var hentrada as handle.             /* HANDLE ENTRADA */
def var hsaida   as handle.             /* HANDLE SAIDA */


def temp-table ttentrada no-undo serialize-name "dadosEntrada"   /* JSON ENTRADA */
    field etbcod  like estab.etbcod
    field pagina  AS INT.

/* {sistema/database/acentos.i} */

def temp-table ttcontrassinestab  no-undo serialize-name "contrassinestab"  /* JSON SAIDA */
    FIELD etbcod like estab.etbcod
    FIELD etbnom like estab.etbnom.

def temp-table ttsaida  no-undo serialize-name "conteudoSaida"  /* JSON SAIDA CASO ERRO */
    field tstatus        as int serialize-name "status"
    field retorno      as char.

def VAR vetbcod like ttentrada.etbcod.
DEF VAR contador AS INT.
DEF VAR varPagina AS INT.

hEntrada = temp-table ttentrada:HANDLE.
lokJSON = hentrada:READ-JSON("longchar",vlcentrada, "EMPTY") no-error.
find first ttentrada no-error.

contador = 0.
varPagina = ttentrada.pagina + 10.

vetbcod = ?.
if avail ttentrada
then do:
    vetbcod = ttentrada.etbcod.
end.

for each contrassin where
    (if vetbcod = ?
     then true /* TODOS */
     else contrassin.etbcod = vetbcod) 
     no-lock.
     
     contador = contador + 1.
     IF contador > ttentrada.pagina and contador <= varPagina THEN DO:
        
        find first ttcontrassinestab where ttcontrassinestab.etbcod = contrassin.etbcod no-lock no-error.
        if not avail ttcontrassinestab then do:
            create ttcontrassinestab.
            ttcontrassinestab.etbcod    = contrassin.etbcod.

            find estab where estab.etbcod = contrassin.etbcod no-lock no-error.
            if avail estab then
                ttcontrassinestab.etbnom   = estab.etbnom.
        end.

    end.
end.


find first ttcontrassinestab no-error.

if not avail ttcontrassinestab
then do:
    create ttsaida.
    ttsaida.tstatus = 400.
    ttsaida.retorno = "estab nao encontrado".

    hsaida  = temp-table ttsaida:handle.

    lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).
    message string(vlcSaida).
    return.
end.

hsaida  = TEMP-TABLE ttcontrassinestab:handle.


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


