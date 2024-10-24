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
    field cpfcnpj  like clien.ciccgc.

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
def var vclicod like ttentrada.clicod.

def query q-leitura for contrassin scrolling.


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

if ttentrada.acao = "boletagem"
then do:
    varqcsv = "/admcom/relat/boletagem_" + 
                string(today,"99999999") + "_" + replace(string(time,"HH:MM:SS"),":","") + ".csv".
end.
else do:
    varqcsv = "/admcom/relat/contrassin_" + 
                string(today,"99999999") + "_" + replace(string(time,"HH:MM:SS"),":","") + ".csv".
end.

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


REPEAT:
    get next q-leitura.
    IF NOT avail contrassin THEN LEAVE.

    if vclicod <> ? then if contrassin.clicod <> vclicod then next.
    
    create ttcontrassin.
    buffer-copy contrassin to ttcontrassin.

    run contClien.


END.
    
    
if ttentrada.acao = "boletagem"
then do:
    output to value(varqcsv).
    put unformatted  "filial;Contrato;Cliente;" 
                    "cpfCnpj;idBiometria;dtEmissao;"
                    "boletavel;dtBoletagem;vlTotal;idNeurotech;"
                    skip.

    for each ttcontrassin.

        put unformatted
            ttcontrassin.etbcod ";"
            ttcontrassin.contnum ";"
            ttcontrassin.clicod ";"
            ttcontrassin.cpfCNPJ ";"
            ttcontrassin.idBiometria ";"
            ttcontrassin.dtinclu format "99/99/9999" ";"
            ttcontrassin.boletavel ";"
            ttcontrassin.dtboletagem format "99/99/9999" ";"
            ttcontrassin.vltotal ";"
            ttcontrassin.idneurotech ";"
            skip.
    end.  
end.
else do:
    output to value(varqcsv).
    put unformatted  "filial;Contrato;Cliente;Nome;" 
                    "cpfCnpj;idBiometria;dtEmissao;"
                    "dtProc;vlTotal;idNeurotech;"
                    skip.

    for each ttcontrassin.

        put unformatted
            ttcontrassin.etbcod ";"
            ttcontrassin.contnum ";"
            ttcontrassin.clicod ";"
            ttcontrassin.nomeCliente ";"
            ttcontrassin.cpfCNPJ ";"
            ttcontrassin.idBiometria ";"
            ttcontrassin.dtinclu format "99/99/9999" ";"
            ttcontrassin.dtproc format "99/99/9999" ";"
            ttcontrassin.vltotal ";"
            ttcontrassin.idneurotech ";"
            skip.
    end.  
end.

    

output close.

create ttsaida.
ttsaida.tstatus = 200.
ttsaida.descricaoStatus = "Arquivo csv gerado " + varqcsv.

hsaida  = temp-table ttsaida:handle.

lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).
put unformatted string(vlcSaida). 


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
