def input param vlcentrada as longchar. /* JSON ENTRADA */
def input param vtmp       as char.     /* CAMINHO PROGRESS_TMP */

def var vlcsaida   as longchar.         /* JSON SAIDA */

def var lokjson as log.                 /* LOGICAL DE APOIO */
def var hentrada as handle.             /* HANDLE ENTRADA */
def var hsaida   as handle.             /* HANDLE SAIDA */

def temp-table ttentrada no-undo serialize-name "dadosEntrada"   /* JSON ENTRADA */
    field DtEmissaoInicial  AS DATE
    field DtEmissaoFinal    AS DATE.

def TEMP-TABLE ttboletagbol  no-undo serialize-name "boletagparcela"  /* JSON SAIDA */
    FIELD cpfcnpj           AS CHAR
    FIELD Documento         LIKE boletagbol.Documento
    FIELD Bancod            LIKE boletagbol.Bancod
    FIELD NossoNumero       LIKE boletagbol.NossoNumero
    FIELD NumeroBoleto      LIKE boletagbol.bolcod
    FIELD DtEmissao         LIKE boletagbol.DtEmissao
    FIELD DtVencimento      LIKE boletagbol.DtVencimento
    FIELD VlCobrado         LIKE boletagbol.VlCobrado
    FIELD DtPagamento       LIKE boletagbol.DtPagamento
    FIELD DtBaixa           LIKE boletagbol.DtBaixa.
    

def temp-table ttsaida  no-undo serialize-name "conteudoSaida"  /* JSON SAIDA CASO ERRO */
    field tstatus        as int serialize-name "status"
    field descricaoStatus      as char.

hEntrada = temp-table ttentrada:HANDLE.
lokJSON = hentrada:READ-JSON("longchar",vlcentrada, "EMPTY") no-error.
find first ttentrada no-error.

IF ttentrada.DtEmissaoInicial <> ? AND ttentrada.DtEmissaoFinal <> ? OR (ttentrada.DtEmissaoInicial = ? AND ttentrada.DtEmissaoFinal = ? )   
THEN DO:  


    for each boletagbol where
        boletagbol.DtEmissao >= ttentrada.DtEmissaoInicial AND
        boletagbol.DtEmissao <=  ttentrada.DtEmissaoFinal
        no-lock.

        FIND clien WHERE clien.clicod = boletagbol.clifor NO-LOCK.
        create ttboletagbol.
        ttboletagbol.cpfcnpj = clien.ciccgc.
        /* assin demais camppos */

    end.
END.


find first ttboletagbol no-error.

if not avail ttboletagbol
then do:
    create ttsaida.
    ttsaida.tstatus = 400.
    ttsaida.descricaoStatus = "Boletos nao encontrados".

    hsaida  = temp-table ttsaida:handle.

    lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).
    message string(vlcSaida).
    return.
end.

hsaida  = TEMP-TABLE ttboletagbol:handle.


lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).
put unformatted string(vlcSaida).



