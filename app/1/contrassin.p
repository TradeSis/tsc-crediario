def input param vlcentrada as longchar. /* JSON ENTRADA */
def input param vtmp       as char.     /* CAMINHO PROGRESS_TMP */

def var vlcsaida   as longchar.         /* JSON SAIDA */

def var lokjson as log.                 /* LOGICAL DE APOIO */
def var hentrada as handle.             /* HANDLE ENTRADA */
def var hsaida   as handle.             /* HANDLE SAIDA */

def temp-table ttentrada no-undo serialize-name "dadosEntrada"   /* JSON ENTRADA */
    field acao  as char
    field boletavel like contrassin.boletavel
    field dtbol like contrassin.dtboletagem
    field contnum  like contrassin.contnum
    field dtproc like contrassin.dtproc
    field etbcod like contrassin.etbcod
    field dtini like contrassin.dtinclu
    field dtfim like contrassin.dtinclu
    field clicod  like contrassin.clicod
    field cpfcnpj  like clien.ciccgc
    field linha  AS int
    field qtd  AS int
    field botao  AS char.

def temp-table ttcontrassin  no-undo serialize-name "contrassin"  /* JSON SAIDA */
    like contrassin
    field cpfcnpj   as char
    field nomeCliente   as char
    field vltotal   as char
    field idneurotech   as char
    field linha  AS int.

def temp-table tttotal  no-undo serialize-name "total"  /* JSON SAIDA */
    field vltotal   as char
    field qtdRegistros   as char.

def dataset conteudoSaida for ttcontrassin, tttotal.


def temp-table ttsaida  no-undo serialize-name "conteudoSaida"  /* JSON SAIDA CASO ERRO */
    field tstatus        as int serialize-name "status"
    field descricaoStatus      as char.

def VAR vcontnum like ttentrada.contnum.
def var vclicod like ttentrada.clicod.

def query q-leitura for contrassin scrolling.
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
IF ttentrada.clicod <> ? 
THEN DO:
    vclicod = ttentrada.clicod.
END.

if ttentrada.acao = "boletagem"
then do:

    IF ttentrada.contnum <> ? THEN DO:
        open query q-leitura for each contrassin where contrassin.contnum = ttentrada.contnum NO-LOCK.
    END.
    ELSE DO:
        if ttentrada.dtini <> ? THEN DO:
            open query q-leitura for each contrassin where 
                contrassin.boletavel = ttentrada.boletavel AND
                (if ttentrada.etbcod = ? 
                then true else contrassin.etbcod = ttentrada.etbcod) AND
                contrassin.dtinclu >= ttentrada.dtini AND
                contrassin.dtinclu <= ttentrada.dtfim
                no-lock.
        end.
        ELSE DO: 
            open query q-leitura for each contrassin where 
                contrassin.boletavel = ttentrada.boletavel AND
                contrassin.dtboletagem = ttentrada.dtbol AND
                (if ttentrada.etbcod = ? 
                then true else contrassin.etbcod = ttentrada.etbcod) 
                no-lock.
        end.
    END.

   

end.
else do:

    IF ttentrada.contnum <> ? THEN DO:
        open query q-leitura for each contrassin where contrassin.contnum = ttentrada.contnum NO-LOCK.
    END.
    ELSE DO:

        if ttentrada.dtini <> ? THEN DO:
            open query q-leitura for each contrassin where 
                (if ttentrada.etbcod = ? 
                then true else contrassin.etbcod = ttentrada.etbcod) AND
                contrassin.dtinclu >= ttentrada.dtini AND
                contrassin.dtinclu <= ttentrada.dtfim
                no-lock.
        end.
        ELSE DO: 
            open query q-leitura for each contrassin where 
                contrassin.dtproc = ttentrada.dtproc AND
                (if ttentrada.etbcod = ? 
                then true else contrassin.etbcod = ttentrada.etbcod) 
                no-lock.
        end.
    END.

    

end.

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
    if not avail contrassin then do:
        vlinha = ?.
        leave.
    end.

    if vclicod <> ? then if contrassin.clicod <> vclicod then next.
    
    create ttcontrassin.
    buffer-copy contrassin to ttcontrassin.
    ttcontrassin.linha = vlinha.

    vlinha = vlinha + 1.

    run contClien.
    vqtd = vqtd - 1.
    IF vqtd <= 0 THEN LEAVE.


END.


find first ttcontrassin no-error.

if not avail ttcontrassin
then do:
    create ttsaida.
    ttsaida.tstatus = 400.
    ttsaida.descricaoStatus = "Assinatura nao encontrada".

    hsaida  = temp-table ttsaida:handle.

    lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).
    message string(vlcSaida).
    return.
end.

/* procura total*/
if ttentrada.linha = ? and ttentrada.contnum = ? 
then do:
    def var qtdtotal as int.
    def var qtdvltotal as decimal.

    reposition q-leitura to row 1 no-error.

    REPEAT:
        get next  q-leitura. 
        if not avail contrassin then do:
            leave.
        end.
        qtdtotal = qtdtotal + 1.

        find contrato of contrassin no-lock no-error.
        qtdvltotal = qtdvltotal + contrato.vltotal.
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
/**
if opsys = "UNIX"
then do:
    def var varquivo as char.
    def var ppid as char.
    INPUT THROUGH "echo $PPID".
    DO ON ENDKEY UNDO, LEAVE:
    IMPORT unformatted ppid.
    END.
    INPUT CLOSE.
    
    varquivo  = "/ws/works/contrassin" + string(today,"999999") + replace(string(time,"HH:MM:SS"),":","") + trim(ppid) + ".json".
              
    lokJson = hsaida:WRITE-JSON("FILE", varquivo, TRUE).
              
    os-command value("cat " + varquivo).
    os-command value("rm -f " + varquivo)
end.
else do:
    lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE). 
    put unformatted string(vlcSaida).
end.
**/


procedure contClien.
        find contrato of contrassin no-lock no-error.
        if avail contrato
        THEN DO:
            ttcontrassin.vltotal = trim(string(contrato.vltotal,"->>>>>>>>>>>>>>>>>>9.99")).
            ttcontrassin.idneurotech = contrato.idOperacaoMotor.
        END.
        ELSE NEXT.
        FIND clien WHERE clien.clicod = contrassin.clicod NO-LOCK.
        if avail clien
        THEN DO:
            ttcontrassin.cpfcnpj = clien.ciccgc.
            ttcontrassin.nomeCliente = clien.clinom.
        END.
        ELSE NEXT.

end procedure.

