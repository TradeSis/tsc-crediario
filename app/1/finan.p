def input param vlcentrada as longchar. /* JSON ENTRADA */
def input param vtmp       as char.     /* CAMINHO PROGRESS_TMP */

def var vlcsaida   as longchar.         /* JSON SAIDA */

def var lokjson as log.                 /* LOGICAL DE APOIO */
def var hentrada as handle.             /* HANDLE ENTRADA */
def var hsaida   as handle.             /* HANDLE SAIDA */


def temp-table ttentrada no-undo serialize-name "dadosEntrada"   /* JSON ENTRADA */
    field fincod  like finan.fincod
    field pagina  AS INT.

def temp-table ttfinan  no-undo serialize-name "finan"  /* JSON SAIDA */
    like finan.

def temp-table ttsaida  no-undo serialize-name "conteudoSaida"  /* JSON SAIDA CASO ERRO */
    field tstatus        as int serialize-name "status"
    field retorno      as char.

DEF VAR contador AS INT.
DEF VAR varPagina AS INT.

hEntrada = temp-table ttentrada:HANDLE.
lokJSON = hentrada:READ-JSON("longchar",vlcentrada, "EMPTY") no-error.
find first ttentrada no-error.

contador = 0.
varPagina = ttentrada.pagina + 10.


IF ttentrada.fincod <> ?
then do:
    find finan where finan.fincod = ttentrada.fincod no-lock no-error.
    if avail finan
    then do:
        create ttfinan.
        ttfinan.fincod    = finan.fincod.
        ttfinan.finnom    = finan.finnom.
        ttfinan.finent    = finan.finent.
        ttfinan.finnpc    = finan.finnpc.
        ttfinan.finfat    = finan.finfat.
        ttfinan.datexp    = finan.datexp.
        ttfinan.txjurosmes    = finan.txjurosmes.
        ttfinan.txjurosano    = finan.txjurosano.
        ttfinan.DPriPag    = finan.DPriPag.
        ttfinan.recorrencia    = finan.recorrencia.
    end.
end. 
ELSE DO:
    for each finan no-lock.
         
        contador = contador + 1.
        
        if contador <= ttentrada.pagina THEN NEXT.
        if contador > varPagina         THEN LEAVE.

        create ttfinan.
        ttfinan.fincod    = finan.fincod.
        ttfinan.finnom    = finan.finnom.
        ttfinan.finent    = finan.finent.
        ttfinan.finnpc    = finan.finnpc.
        ttfinan.finfat    = finan.finfat.
        ttfinan.datexp    = finan.datexp.
        ttfinan.txjurosmes    = finan.txjurosmes.
        ttfinan.txjurosano    = finan.txjurosano.
        ttfinan.DPriPag    = finan.DPriPag.  
        ttfinan.recorrencia    = finan.recorrencia.   
    end.
END.


find first ttfinan no-error.

if not avail ttfinan
then do:
    create ttsaida.
    ttsaida.tstatus = 400.
    ttsaida.retorno = "plano nao encontrado".

    hsaida  = temp-table ttsaida:handle.

    lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).
    message string(vlcSaida).
    return.
end.

hsaida  = TEMP-TABLE ttfinan:handle.


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


