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

def var vclicod like ttentrada.clifor.

hEntrada = temp-table ttentrada:HANDLE.
lokJSON = hentrada:READ-JSON("longchar",vlcentrada, "EMPTY") no-error.
find first ttentrada no-error.
if NOT AVAIL ttentrada then do:
    create ttsaida.
    ttsaida.tstatus = 400.
    ttsaida.descricaoStatus = "sem dados de entrada".

    hsaida  = temp-table ttsaida:handle.

    lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).
    message string(vlcSaida).
    return.    
end.


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
        
        FIND clien WHERE clien.clicod = boletagbol.clifor NO-LOCK.
            ttboletagbol.cpfcnpj = clien.ciccgc.
            ttboletagbol.nomeCliente = clien.clinom.
    end.
END.
else do:

    if ttentrada.NossoNumero <> ? and
       ttentrada.bancod      <> ?
    then do:
        find boletagbol where boletagbol.bancod = ttentrada.bancod and 
                              boletagbol.NossoNumero = ttentrada.NossoNumero
            NO-LOCK no-error.
        if avail boletagbol
        then do:
            create ttboletagbol.
            BUFFER-COPY boletagbol TO ttboletagbol.
            IF(ttboletagbol.situacao = "A") THEN ttboletagbol.situacaoDescricao = "Aberto".
            IF(ttboletagbol.situacao = "P") THEN ttboletagbol.situacaoDescricao = "Pago".
            IF(ttboletagbol.situacao = "B") THEN ttboletagbol.situacaoDescricao = "Baixado".
            
            FIND clien WHERE clien.clicod = boletagbol.clifor NO-LOCK.
                ttboletagbol.cpfcnpj = clien.ciccgc.
                ttboletagbol.nomeCliente = clien.clinom.
        end.

    end.
    else do:
        vclicod = ?.
        IF ttentrada.cpfcnpj <> ? 
        THEN DO:
            FIND clien WHERE clien.ciccgc = ttentrada.cpfcnpj NO-LOCK NO-ERROR.
            IF avail clien
            then vclicod = clien.clicod.
            
        END.
        IF ttentrada.CliFor <> ? 
        THEN DO:
            vclicod = ttentrada.CliFor.
        END.
              
        if ttentrada.tipodedata = "Emissao"
        then do:
            for each boletagbol where 
                boletagbol.dtemissao >= ttentrada.dtInicial and
                boletagbol.dtemissao <= ttentrada.dtFinal and
                (if ttentrada.bancod <> ? 
                then boletagbol.bancod = ttentrada.bancod else TRUE)
                no-lock.

                if vclicod <> ? then if boletagbol.clifor <> vclicod then next.
                if boletagbol.situacao <> ttentrada.situacao then next.

                FIND clien WHERE clien.clicod = boletagbol.clifor NO-LOCK.
                create ttboletagbol.
                ttboletagbol.cpfcnpj = clien.ciccgc.
                ttboletagbol.nomeCliente = clien.clinom.
                BUFFER-COPY boletagbol TO ttboletagbol.
                IF(ttboletagbol.situacao = "A") THEN ttboletagbol.situacaoDescricao = "Aberto".
                IF(ttboletagbol.situacao = "P") THEN ttboletagbol.situacaoDescricao = "Pago".
                IF(ttboletagbol.situacao = "B") THEN ttboletagbol.situacaoDescricao = "Baixado".
            end.
        end.
        if ttentrada.tipodedata = "Pagamento"
        then do:
            for each boletagbol where 
                boletagbol.situacao = ttentrada.situacao and
                boletagbol.dtpagamento >= ttentrada.dtInicial and
                boletagbol.dtpagamento <= ttentrada.dtFinal
                no-lock.
                if ttentrada.bancod <> ? then if boletagbol.bancod <> ttentrada.bancod then next.                
                if vclicod <> ? then if boletagbol.clifor <> vclicod then next.
                
                FIND clien WHERE clien.clicod = boletagbol.clifor NO-LOCK.
                create ttboletagbol.
                ttboletagbol.cpfcnpj = clien.ciccgc.
                ttboletagbol.nomeCliente = clien.clinom.
                BUFFER-COPY boletagbol TO ttboletagbol.
                IF(ttboletagbol.situacao = "A") THEN ttboletagbol.situacaoDescricao = "Aberto".
                IF(ttboletagbol.situacao = "P") THEN ttboletagbol.situacaoDescricao = "Pago".
                IF(ttboletagbol.situacao = "B") THEN ttboletagbol.situacaoDescricao = "Baixado".
            end.
        end.
        if ttentrada.tipodedata = "Baixa"
        then do:
            for each boletagbol where 
                boletagbol.situacao = ttentrada.situacao and
                boletagbol.dtbaixa >= ttentrada.dtInicial and
                boletagbol.dtbaixa <= ttentrada.dtFinal
                no-lock.
                
                if ttentrada.bancod <> ? THEN IF boletagbol.bancod <> ttentrada.bancod then next.                
                if vclicod <> ? then if boletagbol.clifor <> vclicod then next.

                FIND clien WHERE clien.clicod = boletagbol.clifor NO-LOCK.
                create ttboletagbol.
                ttboletagbol.cpfcnpj = clien.ciccgc.
                ttboletagbol.nomeCliente = clien.clinom.
                BUFFER-COPY boletagbol TO ttboletagbol.
                IF(ttboletagbol.situacao = "A") THEN ttboletagbol.situacaoDescricao = "Aberto".
                IF(ttboletagbol.situacao = "P") THEN ttboletagbol.situacaoDescricao = "Pago".
                IF(ttboletagbol.situacao = "B") THEN ttboletagbol.situacaoDescricao = "Baixado".
            end.
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



