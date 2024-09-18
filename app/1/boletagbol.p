def input param vlcentrada as longchar. /* JSON ENTRADA */
def input param vtmp       as char.     /* CAMINHO PROGRESS_TMP */

def var vlcsaida   as longchar.         /* JSON SAIDA */

def var lokjson as log.                 /* LOGICAL DE APOIO */
def var hentrada as handle.             /* HANDLE ENTRADA */
def var hsaida   as handle.             /* HANDLE SAIDA */

def temp-table ttentrada no-undo serialize-name "dadosEntrada"   /* JSON ENTRADA */
    field CliFor  like boletagbol.CliFor
    field cpfcnpj  like clien.ciccgc
    field bolcod  like boletagbol.bolcod
    field bancod  like boletagbol.bancod
    field NossoNumero  like boletagbol.NossoNumero
    field dtInicial  like boletagbol.DtEmissao
    field dtFinal    like boletagbol.DtEmissao
    field situacao    like boletagbol.situacao
    field tipodedata    as char.

def TEMP-TABLE ttboletagbol  no-undo serialize-name "boletagbol"  /* JSON SAIDA */
    like boletagbol
    FIELD cpfcnpj           AS CHAR
    FIELD nomeCliente       AS CHAR
    FIELD situacaoDescricao      AS CHAR.

def temp-table ttboletagparcela  no-undo serialize-name "boletagparcela"
    like boletagparcela.

def dataset conteudoSaida for ttboletagbol, ttboletagparcela
    DATA-RELATION for1 FOR ttboletagbol, ttboletagparcela         
        RELATION-FIELDS(ttboletagbol.bolcod,ttboletagparcela.bolcod) NESTED.
    

def temp-table ttsaida  no-undo serialize-name "conteudoSaida"  /* JSON SAIDA CASO ERRO */
    field tstatus        as int serialize-name "status"
    field descricaoStatus      as char.

def var vclifor like ttentrada.clifor.

hEntrada = temp-table ttentrada:HANDLE.
lokJSON = hentrada:READ-JSON("longchar",vlcentrada, "EMPTY") no-error.
find first ttentrada no-error.


IF ttentrada.cpfcnpj <> ? 
THEN DO:
    FIND clien WHERE clien.ciccgc = ttentrada.cpfcnpj NO-LOCK NO-ERROR.
    IF avail clien
    then vclifor = clien.clicod.
    
END.
IF ttentrada.CliFor <> ? 
THEN DO:
    vclifor = ttentrada.CliFor.
END.




IF ttentrada.bolcod = ? 
THEN DO:
    for each boletagbol where 
        (if vclifor = ? 
        then true else boletagbol.CliFor = vclifor) AND
        (if ttentrada.bancod = ? 
        then true else boletagbol.bancod = ttentrada.bancod) AND
        (if ttentrada.NossoNumero = ? 
        then true else boletagbol.NossoNumero = ttentrada.NossoNumero) AND
        (if ttentrada.dtInicial = ? 
        then true else boletagbol.DtEmissao >= ttentrada.dtInicial) AND
        (if ttentrada.dtFinal = ? 
        then true else boletagbol.DtEmissao <= ttentrada.dtFinal) 
        no-lock.

        FIND clien WHERE clien.clicod = boletagbol.clifor NO-LOCK.
        create ttboletagbol.
        ttboletagbol.cpfcnpj = clien.ciccgc.
        ttboletagbol.nomeCliente = clien.clinom.
        BUFFER-COPY boletagbol TO ttboletagbol.
        IF(ttboletagbol.situacao = "A") THEN ttboletagbol.situacaoDescricao = "Aberto".
        IF(ttboletagbol.situacao = "P") THEN ttboletagbol.situacaoDescricao = "Pago".
        IF(ttboletagbol.situacao = "B") THEN ttboletagbol.situacaoDescricao = "Baixado".
    end.
END.

IF ttentrada.bolcod <> ?
THEN DO:
    find boletagbol where 
        boletagbol.bolcod = ttentrada.bolcod 
        NO-LOCK no-error.
        
        if avail boletagbol
        then do:
            create ttboletagbol.
            BUFFER-COPY boletagbol TO ttboletagbol.
            IF(ttboletagbol.situacao = "A") THEN ttboletagbol.situacaoDescricao = "Aberto".
            IF(ttboletagbol.situacao = "P") THEN ttboletagbol.situacaoDescricao = "Pago".
            IF(ttboletagbol.situacao = "B") THEN ttboletagbol.situacaoDescricao = "Baixado".
            
            FIND clien WHERE clien.clicod = boletagbol.clifor NO-LOCK no-error.
            if avail clien
            then do:
                ttboletagbol.cpfcnpj = clien.ciccgc.
                ttboletagbol.nomeCliente = clien.clinom.
            end.

            FIND boletagparcela WHERE boletagparcela.bolcod = boletagbol.bolcod NO-LOCK no-error.
            if avail boletagparcela
            then do:
                create ttboletagparcela.
                BUFFER-COPY boletagparcela TO ttboletagparcela.
            end.
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

hsaida  = dataset conteudoSaida:handle.


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



