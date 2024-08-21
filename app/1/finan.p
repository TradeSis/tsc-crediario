def input param vlcentrada as longchar. /* JSON ENTRADA */
def input param vtmp       as char.     /* CAMINHO PROGRESS_TMP */

def var vlcsaida   as longchar.         /* JSON SAIDA */

def var lokjson as log.                 /* LOGICAL DE APOIO */
def var hentrada as handle.             /* HANDLE ENTRADA */
def var hsaida   as handle.             /* HANDLE SAIDA */


def temp-table ttentrada no-undo serialize-name "finan"   /* JSON ENTRADA */
    field fincod  like finan.fincod
    field pagina  AS INT.

def temp-table ttfinan  no-undo serialize-name "finan"  /* JSON SAIDA */
    like finan.

def temp-table ttsaida  no-undo serialize-name "conteudoSaida"  /* JSON SAIDA CASO ERRO */
    field tstatus        as int serialize-name "status"
    field retorno      as char.

def VAR vfincod like ttentrada.fincod.
DEF VAR contador AS INT.
DEF VAR varPagina AS INT.

hEntrada = temp-table ttentrada:HANDLE.
lokJSON = hentrada:READ-JSON("longchar",vlcentrada, "EMPTY") no-error.
find first ttentrada no-error.

contador = 0.
varPagina = ttentrada.pagina + 10.

vfincod = ?.
if avail ttentrada
then do:
    vfincod = ttentrada.fincod.
end.

IF ttentrada.fincod <> ? OR (ttentrada.fincod = ?)
THEN DO:
    for each finan where
        (if vfincod = ?
         then true /* TODOS */
         else finan.fincod = vfincod) 
         no-lock.
         
         contador = contador + 1.
        IF contador > ttentrada.pagina and contador <= varPagina THEN DO:
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
            
            //ttfincod.etbnom   = removeacento(estab.etbnom).
            //ttfincod.munic   = removeacento(estab.munic).
        end.
    end.
END.


find first ttfinan no-error.

if not avail ttfinan
then do:
    create ttsaida.
    ttsaida.tstatus = 400.
    ttsaida.retorno = "estab nao encontrado".

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


