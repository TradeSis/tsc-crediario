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
    field recatu  AS recid
    field qtd  AS int
    field paginacao  AS char.

def temp-table ttcontrassin  no-undo serialize-name "contrassin"  /* JSON SAIDA */
    like contrassin
    field cpfcnpj   as char
    field nomeCliente   as char
    field vltotal   as char
    field idneurotech   as char
    FIELD recatu  AS recid 
    index contnum is unique primary contnum asc.

def temp-table ttsaida  no-undo serialize-name "conteudoSaida"  /* JSON SAIDA CASO ERRO */
    field tstatus        as int serialize-name "status"
    field descricaoStatus      as char.

def VAR vcontnum like ttentrada.contnum.
def var vclicod like ttentrada.clicod.

def query q-leitura for contrassin scrolling.
def var vrecatu as recid.
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

vrecatu = ttentrada.recatu.
vqtd = ttentrada.qtd.

if ttentrada.acao = "boletagem"
then do:

    IF ttentrada.contnum <> ? THEN DO:
        find contrassin where contrassin.contnum = ttentrada.contnum NO-LOCK no-error.
        
        IF avail contrassin THEN DO:
            create ttcontrassin.
            buffer-copy contrassin to ttcontrassin.
            ttcontrassin.recatu = recid(contrassin).
            
            run contClien.
        END.
    END.
    ELSE DO:

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

        if ttentrada.dtini <> ? THEN DO:
            open query q-leitura for each contrassin where 
                contrassin.boletavel = ttentrada.boletavel AND
                (if ttentrada.etbcod = ? 
                then true else contrassin.etbcod = ttentrada.etbcod) AND
                contrassin.dtinclu >= ttentrada.dtini AND
                contrassin.dtinclu <= ttentrada.dtfim
                no-lock.

            IF vrecatu <> ? THEN DO:
                reposition q-leitura to recid vrecatu no-error.
                get next  q-leitura.  
                if not avail contrassin
                then do:
                    vrecatu = ?.
                    return.
                end.
            END.

           
        end.
        ELSE DO: 
            open query q-leitura for each contrassin where 
                contrassin.boletavel = ttentrada.boletavel AND
                contrassin.dtboletagem = ttentrada.dtbol AND
                (if ttentrada.etbcod = ? 
                then true else contrassin.etbcod = ttentrada.etbcod) 
                no-lock.

            IF vrecatu <> ? THEN DO:
                reposition q-leitura to recid vrecatu no-error.
                get next  q-leitura.  
                if not avail contrassin
                then do:
                    vrecatu = ?.
                    return.
                end.
            END.

            
        end.
    END.

   

end.
else do:

    IF ttentrada.contnum <> ? THEN DO:
        find contrassin where contrassin.contnum = ttentrada.contnum NO-LOCK no-error.
        
        IF avail contrassin THEN DO:
            create ttcontrassin.
            buffer-copy contrassin to ttcontrassin.
            ttcontrassin.recatu = recid(contrassin).
            
            run contClien.
        END.
    END.
    ELSE DO:

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

        if ttentrada.dtini <> ? THEN DO:
            open query q-leitura for each contrassin where 
                (if ttentrada.etbcod = ? 
                then true else contrassin.etbcod = ttentrada.etbcod) AND
                contrassin.dtinclu >= ttentrada.dtini AND
                contrassin.dtinclu <= ttentrada.dtfim
                no-lock.

            IF vrecatu <> ? THEN DO:
                reposition q-leitura to recid vrecatu no-error.
                get next  q-leitura.  
                if not avail contrassin
                then do:
                    vrecatu = ?.
                    return.
                end.
            END.

           
        end.
        ELSE DO: 
            open query q-leitura for each contrassin where 
                contrassin.dtproc = ttentrada.dtproc AND
                (if ttentrada.etbcod = ? 
                then true else contrassin.etbcod = ttentrada.etbcod) 
                no-lock.

            IF vrecatu <> ? THEN DO:
                reposition q-leitura to recid vrecatu no-error.
                get next  q-leitura.  
                if not avail contrassin
                then do:
                    vrecatu = ?.
                    return.
                end.
            END.
            
           
        end.
    END.

    

end.    

REPEAT:
    IF ttentrada.paginacao = "prev" THEN
        get prev  q-leitura. 
    ELSE
        get next  q-leitura. 
    IF NOT avail contrassin THEN LEAVE.

    if vclicod <> ? then if contrassin.clicod <> vclicod then next.
    
    create ttcontrassin.
    buffer-copy contrassin to ttcontrassin.
    ttcontrassin.recatu = recid(contrassin).

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

    

hsaida  = TEMP-TABLE ttcontrassin:handle.

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

