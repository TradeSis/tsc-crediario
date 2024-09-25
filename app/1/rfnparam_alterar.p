def input param vlcentrada as longchar. /* JSON ENTRADA */
def input param vtmp       as char.     /* CAMINHO PROGRESS_TMP */

def var vlcsaida   as longchar.         /* JSON SAIDA */

def var lokjson as log.                 /* LOGICAL DE APOIO */
def var hentrada as handle.             /* HANDLE ENTRADA */
def var hsaida   as handle.             /* HANDLE SAIDA */

def temp-table ttentrada no-undo serialize-name "dadosEntrada"   /* JSON ENTRADA */
    FIELD dtIniVig                like rfnparam.dtIniVig
    FIELD listaModalidades        like rfnparam.listaModalidades
    FIELD diasAtrasoMax           like rfnparam.diasAtrasoMax
    FIELD carteirasPermitidas     like rfnparam.carteirasPermitidas
    FIELD testaNovacao            like rfnparam.testaNovacao
    FIELD contratoPago            like rfnparam.contratoPago.

def temp-table ttsaida  no-undo serialize-name "conteudoSaida"  /* JSON SAIDA CASO ERRO */
    field tstatus        as int serialize-name "status"
    field descricaoStatus      as char.

DEF BUFFER brfnparam FOR rfnparam.

hEntrada = temp-table ttentrada:HANDLE.
lokJSON = hentrada:READ-JSON("longchar",vlcentrada, "EMPTY") no-error.
find first ttentrada no-error.


if not avail ttentrada
then do:
    create ttsaida.
    ttsaida.tstatus = 400.
    ttsaida.descricaoStatus = "Dados de Entrada nao encontrados".

    hsaida  = temp-table ttsaida:handle.

    lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).
    message string(vlcSaida).
    return.
end.

if ttentrada.dtIniVig = ?
then do:
    create ttsaida.
    ttsaida.tstatus = 400.
    ttsaida.descricaoStatus = "Dados de Entrada Invalidos".

    hsaida  = temp-table ttsaida:handle.

    lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).
    message string(vlcSaida).
    return.
end.

find rfnparam where rfnparam.dtIniVig = ttentrada.dtIniVig 
                        no-lock no-error.
IF NOT avail rfnparam
then do:
    create ttsaida.
    ttsaida.tstatus = 400.
    ttsaida.descricaoStatus = "nenhum dado encontrado!".

    hsaida  = temp-table ttsaida:handle.

    lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).
    message string(vlcSaida).
    return.
end.

 do on error undo:   
 RUN LOG("--- ENTROU NO BLOCO ---").
    find current rfnparam exclusive.
    IF rfnparam.dtIniVig < today
    then do:
        RUN LOG("dtIniVig -> " + STRING(rfnparam.dtIniVig)).
        create brfnparam.
        buffer-copy rfnparam 
            except dtinivig to brfnparam.
        brfnparam.dtinivig = today.
        RUN LOG("nova dtIniVig -> " + STRING(brfnparam.dtinivig)).
        find rfnparam where recid(rfnparam) = recid(brfnparam) exclusive.
        RUN LOG("--- ALTEROU DTINIVIG ---").
    end.

    RUN LOG("--- ALTEROU REGISTOS ---").
        if ttentrada.listaModalidades <> ?
        then do:
            rfnparam.listaModalidades = ttentrada.listaModalidades.
        end.
        if ttentrada.diasAtrasoMax <> ?
        then do:
            rfnparam.diasAtrasoMax = ttentrada.diasAtrasoMax.
        end.
        if ttentrada.carteirasPermitidas <> ?
        then do:
            rfnparam.carteirasPermitidas = ttentrada.carteirasPermitidas.
        end.
        if ttentrada.testaNovacao <> ?
        then do:
            rfnparam.testaNovacao = ttentrada.testaNovacao.
        end.
        if ttentrada.contratoPago <> ?
        then do:
            rfnparam.contratoPago = ttentrada.contratoPago.
        end.
       
end.
    


create ttsaida.
ttsaida.tstatus = 200.
ttsaida.descricaoStatus = "Alterado com sucesso".

hsaida  = temp-table ttsaida:handle.

lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).
put unformatted string(vlcSaida).

procedure LOG.
    DEF INPUT PARAM vmensagem AS CHAR.    
    OUTPUT TO VALUE(vtmp + "/RFNPARAM_" + string(today,"99999999") + ".log") APPEND.
        PUT UNFORMATTED 
            STRING (TIME,"HH:MM:SS")
            " progress -> " vmensagem
            SKIP.
    OUTPUT CLOSE.
    
END PROCEDURE.
