def input param vlcentrada as longchar. /* JSON ENTRADA */
def input param vtmp       as char.     /* CAMINHO PROGRESS_TMP */

def var vlcsaida   as longchar.         /* JSON SAIDA */

def var lokjson as log.                 /* LOGICAL DE APOIO */
def var hentrada as handle.             /* HANDLE ENTRADA */
def var hsaida   as handle.             /* HANDLE SAIDA */

def temp-table ttentrada no-undo serialize-name "dadosEntrada"   /* JSON ENTRADA */
    field DtEmissaoInicial  like boletagparcela.DtEmissao
    field DtEmissaoFinal  like boletagparcela.DtEmissao.

def temp-table ttboletagparcela  no-undo serialize-name "boletagparcela"  /* JSON SAIDA */
    like boletagparcela.

def temp-table ttsaida  no-undo serialize-name "conteudoSaida"  /* JSON SAIDA CASO ERRO */
    field tstatus        as int serialize-name "status"
    field descricaoStatus      as char.

hEntrada = temp-table ttentrada:HANDLE.
lokJSON = hentrada:READ-JSON("longchar",vlcentrada, "EMPTY") no-error.
find first ttentrada no-error.

IF ttentrada.DtEmissaoInicial <> ? AND ttentrada.DtEmissaoFinal <> ? OR (ttentrada.DtEmissaoInicial = ? AND ttentrada.DtEmissaoFinal = ? )   
THEN DO:  

    for each boletagparcela where
        boletagparcela.DtEmissao >= ttentrada.DtEmissaoInicial AND
        boletagparcela.DtEmissao <=  ttentrada.DtEmissaoFinal
        no-lock.

        
        create ttboletagparcela.
        BUFFER-COPY boletagparcela TO ttboletagparcela.

    end.
END.


find first ttboletagparcela no-error.

if not avail ttboletagparcela
then do:
    create ttsaida.
    ttsaida.tstatus = 400.
    ttsaida.descricaoStatus = "parametros nao encontrado".

    hsaida  = temp-table ttsaida:handle.

    lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).
    message string(vlcSaida).
    return.
end.

hsaida  = TEMP-TABLE ttboletagparcela:handle.


lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).
put unformatted string(vlcSaida).


