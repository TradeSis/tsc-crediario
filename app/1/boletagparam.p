def input param vlcentrada as longchar. /* JSON ENTRADA */
def input param vtmp       as char.     /* CAMINHO PROGRESS_TMP */

def var vlcsaida   as longchar.         /* JSON SAIDA */

def var lokjson as log.                 /* LOGICAL DE APOIO */
def var hentrada as handle.             /* HANDLE ENTRADA */
def var hsaida   as handle.             /* HANDLE SAIDA */

def temp-table ttentrada no-undo serialize-name "dadosEntrada"   /* JSON ENTRADA */
    field dtIniVig  like boletagparam.dtIniVig
    field listaModalidades  like boletagparam.listaModalidades.

def temp-table ttboletagparam  no-undo serialize-name "boletagparam"  /* JSON SAIDA */
    like boletagparam
    index X dtIniVig DESC dtfimvig DESC.

def temp-table ttsaida  no-undo serialize-name "conteudoSaida"  /* JSON SAIDA CASO ERRO */
    field tstatus        as int serialize-name "status"
    field descricaoStatus      as char.

hEntrada = temp-table ttentrada:HANDLE.
lokJSON = hentrada:READ-JSON("longchar",vlcentrada, "EMPTY") no-error.
find first ttentrada no-error.

IF ttentrada.dtIniVig <> ? AND ttentrada.listaModalidades <> ? OR (ttentrada.dtIniVig = ? AND ttentrada.listaModalidades = ?)    
THEN DO:  

    for each boletagparam where
        (if ttentrada.dtIniVig = ? AND ttentrada.listaModalidades = ?
        then true /* TODOS */
        ELSE boletagparam.dtIniVig = ttentrada.dtIniVig AND boletagparam.listaModalidades = ttentrada.listaModalidades)
        no-lock.

        
        create ttboletagparam.
        BUFFER-COPY boletagparam TO ttboletagparam.

    end.
END.


find first ttboletagparam no-error.

if not avail ttboletagparam
then do:
    create ttsaida.
    ttsaida.tstatus = 400.
    ttsaida.descricaoStatus = "parametros nao encontrado".

    hsaida  = temp-table ttsaida:handle.

    lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).
    message string(vlcSaida).
    return.
end.

hsaida  = TEMP-TABLE ttboletagparam:handle.


lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).
put unformatted string(vlcSaida).



