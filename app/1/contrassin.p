def input param vlcentrada as longchar. /* JSON ENTRADA */
def input param vtmp       as char.     /* CAMINHO PROGRESS_TMP */

def var vlcsaida   as longchar.         /* JSON SAIDA */

def var lokjson as log.                 /* LOGICAL DE APOIO */
def var hentrada as handle.             /* HANDLE ENTRADA */
def var hsaida   as handle.             /* HANDLE SAIDA */

def temp-table ttentrada no-undo serialize-name "dadosEntrada"   /* JSON ENTRADA */
    field acao  as char
    field contnum  like contrassin.contnum
    field dtproc like contrassin.dtproc
    field etbcod like contrassin.etbcod
    field dtini like contrassin.dtinclu
    field dtfim like contrassin.dtinclu.

def temp-table ttcontrassin  no-undo serialize-name "contrassin"  /* JSON SAIDA */
    like contrassin
    field cpfCNPJ   as char
    field nomeCliente   as char
    field vltotal   as char
    field idneurotech   as char.

def temp-table ttsaida  no-undo serialize-name "conteudoSaida"  /* JSON SAIDA CASO ERRO */
    field tstatus        as int serialize-name "status"
    field descricaoStatus      as char.

def VAR vcontnum like ttentrada.contnum.


hEntrada = temp-table ttentrada:HANDLE.
lokJSON = hentrada:READ-JSON("longchar",vlcentrada, "EMPTY") no-error.
find first ttentrada no-error.

if ttentrada.acao = "boletagem"
then do:
    IF ttentrada.contnum = ? 
    THEN DO:
        for each contrassin where 
            contrassin.boletavel = yes AND
            (if ttentrada.etbcod = ? 
            then true else contrassin.etbcod = ttentrada.etbcod) AND
            (if ttentrada.dtini = ? 
            then true else contrassin.dtboletagem >= ttentrada.dtini) AND
            (if ttentrada.dtfim = ? 
            then true else contrassin.dtboletagem <= ttentrada.dtfim) 
            no-lock.

            create ttcontrassin.
            BUFFER-COPY contrassin TO ttcontrassin.

        end.
    END.

    IF ttentrada.contnum <> ?
    THEN DO:
        find contrassin where 
            contrassin.boletavel = yes AND
            contrassin.contnum = ttentrada.contnum 
            NO-LOCK no-error.
            
            if avail contrassin
            then do:
                create ttcontrassin.
                BUFFER-COPY contrassin TO ttcontrassin.
            end.
    END.
    

end.
else do:

    IF ttentrada.contnum = ? 
    THEN DO:
        for each contrassin where 
            contrassin.dtproc = ttentrada.dtproc AND
            (if ttentrada.etbcod = ? 
            then true else contrassin.etbcod = ttentrada.etbcod) AND
            (if ttentrada.dtini = ? 
            then true else contrassin.dtinclu >= ttentrada.dtini) AND
            (if ttentrada.dtfim = ? 
            then true else contrassin.dtinclu <= ttentrada.dtfim) 
            no-lock.

            create ttcontrassin.
            BUFFER-COPY contrassin TO ttcontrassin.

        end.
    END.

    IF ttentrada.contnum <> ?
    THEN DO:
        find contrassin where 
            contrassin.contnum = ttentrada.contnum 
            NO-LOCK no-error.
            
            if avail contrassin
            then do:
                create ttcontrassin.
                BUFFER-COPY contrassin TO ttcontrassin.
            end.
    END.

end.    
    

  

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

for each ttcontrassin.
    find clien where clien.clicod = ttcontrassin.clicod no-lock no-error.
    if avail clien
    then do:
        ttcontrassin.cpfCNPJ = clien.ciccgc.
        ttcontrassin.nomeCliente = clien.clinom.
    end.
    find contrato where contrato.contnum = ttcontrassin.contnum no-lock no-error.
    if avail contrato
    then do:
        ttcontrassin.vltotal = trim(string(contrato.vltotal,"->>>>>>>>>>>>>>>>>>9.99")).
    end.
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