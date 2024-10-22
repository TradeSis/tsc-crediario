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

    
def TEMP-TABLE ttboletagbol  no-undo serialize-name "csvboletagbol"  /* JSON SAIDA */
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

def query q-leitura for boletagbol scrolling.

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

def var varqcsv as char format "x(65)".

    varqcsv = "/admcom/relat/boletagbol_" + 
                string(today,"99999999") + "_" + replace(string(time,"HH:MM:SS"),":","") + ".csv".



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
        IF(ttboletagbol.situacao = "B") THEN ttboletagbol.situacaoDescricao = "Baixado".
        IF(ttboletagbol.situacao = "P") 
        THEN DO:
            IF ttboletagbol.ctmcod = "P7" 
            THEN DO:
                ttboletagbol.situacaoDescricao = "Pago" + " (" + string(ttboletagbol.etbpag) + ")".
            END.
            ELSE DO:
                ttboletagbol.situacaoDescricao = "Pago" + " (" + ttboletagbol.ctmcod + ")".
            END.
            
        END.
        
        
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
            IF(ttboletagbol.situacao = "B") THEN ttboletagbol.situacaoDescricao = "Baixado".
            IF(ttboletagbol.situacao = "P") 
            THEN DO:
                IF ttboletagbol.ctmcod = "P7" 
                THEN DO:
                    ttboletagbol.situacaoDescricao = "Pago" + " (" + string(ttboletagbol.etbpag) + ")".
                END.
                ELSE DO:
                    ttboletagbol.situacaoDescricao = "Pago" + " (" + ttboletagbol.ctmcod + ")".
                END.
                
            END.
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
            open query q-leitura for each boletagbol where 
                boletagbol.dtemissao >= ttentrada.dtInicial and
                boletagbol.dtemissao <= ttentrada.dtFinal and
                (if ttentrada.bancod <> ? 
                then boletagbol.bancod = ttentrada.bancod else TRUE)
                no-lock.

        end.
        if ttentrada.tipodedata = "Pagamento"
        then do:
            open query q-leitura for each boletagbol where 
                boletagbol.situacao = ttentrada.situacao and
                boletagbol.dtpagamento >= ttentrada.dtInicial and
                boletagbol.dtpagamento <= ttentrada.dtFinal
                no-lock.

        end.
        if ttentrada.tipodedata = "Baixa"
        then do:
            open query q-leitura for each boletagbol where 
                boletagbol.situacao = ttentrada.situacao and
                boletagbol.dtbaixa >= ttentrada.dtInicial and
                boletagbol.dtbaixa <= ttentrada.dtFinal
                no-lock.

        end.

        REPEAT:
            get next  q-leitura. 
            IF NOT avail boletagbol THEN LEAVE.
            
            if ttentrada.bancod <> ? THEN IF boletagbol.bancod <> ttentrada.bancod then next.                
            if vclicod <> ? then if boletagbol.clifor <> vclicod then next.

            create ttboletagbol.
            BUFFER-COPY boletagbol TO ttboletagbol.
            
            run bolClien.
        END.
    end.
END.



output to value(varqcsv).
put unformatted  "numeroBoleto;cpfCnpj;documento;Banco;" 
                 "NossoNumero;dataEmissao;dataVencimento;ValorCobrado;"
                 "dataPagamento;dataBaixa;Situacao;"
                 skip.

for each ttboletagbol.

    put unformatted
        ttboletagbol.bolcod ";"
        ttboletagbol.cpfcnpj ";"
        ttboletagbol.Documento ";"
        ttboletagbol.bancod ";"
        ttboletagbol.NossoNumero ";"
        ttboletagbol.DtEmissao format "99/99/9999" ";"
        ttboletagbol.DtVencimento format "99/99/9999" ";"
        ttboletagbol.VlCobrado ";"
        ttboletagbol.DtPagamento format "99/99/9999" ";"
        ttboletagbol.DtBaixa format "99/99/9999" ";"
        ttboletagbol.situacao ";"
        skip.
end.  


output close.

create ttsaida.
ttsaida.tstatus = 200.
ttsaida.descricaoStatus = "Arquivo csv gerado " + varqcsv.

hsaida  = temp-table ttsaida:handle.

lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).
put unformatted string(vlcSaida). 

procedure bolClien.
    FIND clien WHERE clien.clicod = boletagbol.clifor NO-LOCK.
    ttboletagbol.cpfcnpj = clien.ciccgc.
    ttboletagbol.nomeCliente = clien.clinom.
    IF(ttboletagbol.situacao = "A") THEN ttboletagbol.situacaoDescricao = "Aberto".
    IF(ttboletagbol.situacao = "B") THEN ttboletagbol.situacaoDescricao = "Baixado".
    IF(ttboletagbol.situacao = "P") 
    THEN DO:
        IF ttboletagbol.ctmcod = "P7" 
        THEN DO:
            ttboletagbol.situacaoDescricao = "Pago" + " (" + string(ttboletagbol.etbpag) + ")".
        END.
        ELSE DO:
            ttboletagbol.situacaoDescricao = "Pago" + " (" + ttboletagbol.ctmcod + ")".
        END.
        
    END.

end procedure.


