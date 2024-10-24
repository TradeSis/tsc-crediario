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
    field tipodedata    as char
    field linha  AS int
    field qtd  AS int
    field botao  AS char.

def TEMP-TABLE ttboletagbol  no-undo serialize-name "boletagbol"  /* JSON SAIDA */
    field bolcod    like boletagbol.bolcod
    field CliFor    like boletagbol.CliFor
    field Documento    like boletagbol.Documento
    field bancod    like boletagbol.bancod
    field DtEmissao    like boletagbol.DtEmissao
    field DtVencimento    like boletagbol.DtVencimento
    field VlCobrado    like boletagbol.VlCobrado
    field DtPagamento    like boletagbol.DtPagamento
    field DtBaixa    like boletagbol.DtBaixa
    field situacao    like boletagbol.situacao
    field ctmcod    like boletagbol.ctmcod
    field etbpag    like boletagbol.etbpag
    field cpfcnpj           AS CHAR
    field nomeCliente       AS CHAR
    field situacaoDescricao      AS CHAR
    field linha  AS int. 

def temp-table ttboletagparcela  no-undo serialize-name "boletagparcela"
    like boletagparcela.

def temp-table tttotal  no-undo serialize-name "total"  /* JSON SAIDA */
    field vltotal   as char
    field qtdRegistros   as char.

def dataset conteudoSaida for ttboletagbol, ttboletagparcela, tttotal
    DATA-RELATION for1 FOR ttboletagbol, ttboletagparcela         
        RELATION-FIELDS(ttboletagbol.bolcod,ttboletagparcela.bolcod) NESTED.
    

def temp-table ttsaida  no-undo serialize-name "conteudoSaida"  /* JSON SAIDA CASO ERRO */
    field tstatus        as int serialize-name "status"
    field descricaoStatus      as char.

def var vclicod like ttentrada.clifor.

def query q-leitura for boletagbol scrolling.
def var vlinha as int.
def var vqtd as int.

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

vlinha = ttentrada.linha.
vqtd = ttentrada.qtd.


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




IF ttentrada.bolcod <> ? 
THEN DO:
    open query q-leitura for each boletagbol 
    where boletagbol.bolcod = ttentrada.bolcod 
    NO-LOCK.
END.
else do:

    if ttentrada.NossoNumero <> ? and
       ttentrada.bancod      <> ?
    then do:
        open query q-leitura for each boletagbol 
        where boletagbol.bancod = ttentrada.bancod  
        and   boletagbol.NossoNumero = ttentrada.NossoNumero 
        NO-LOCK.
    end.
    else do:
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
    end.
END.


if vlinha = ? or vlinha = 0 then vlinha = 1.

if ttentrada.botao = "prev"
then do:
    vlinha = vlinha - vqtd .
    if vlinha > 0
    then do:
        reposition q-leitura to row vlinha no-error.
    end.
    else do:
        vlinha = 1.
    end.
end.
else do:
    if vlinha > 1
    then do:
        reposition q-leitura to row vlinha no-error.
        get next q-leitura.
        vlinha = vlinha + 1.
    end.
end.

REPEAT:
    get next q-leitura.
    if not avail boletagbol then do:
        vlinha = ?.
        leave.
    end.

    if ttentrada.bancod <> ? THEN IF boletagbol.bancod <> ttentrada.bancod then next.                
    if vclicod <> ? then if boletagbol.clifor <> vclicod then next.
    
    create ttboletagbol.
    buffer-copy boletagbol to ttboletagbol.
    ttboletagbol.linha = vlinha.

    vlinha = vlinha + 1.

    run bolClien.
    vqtd = vqtd - 1.
    IF vqtd <= 0 THEN LEAVE.


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

/* procura total*/
if ttentrada.linha = ? and ttentrada.bolcod = ? 
then do:
    def var qtdtotal as int.
    def var qtdvltotal as decimal.

    reposition q-leitura to row 1 no-error.

    REPEAT:
        get next  q-leitura. 
        if not avail boletagbol then do:
            leave.
        end.
        qtdtotal = qtdtotal + 1.
        qtdvltotal = qtdvltotal + boletagbol.VlCobrado.
    END.

    create tttotal.
    tttotal.qtdRegistros = string(qtdtotal).
    tttotal.vltotal = trim(string(qtdvltotal,"->>>>>>>>>>>>>>>>>>9.99")). 
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


