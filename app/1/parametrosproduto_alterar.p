def input param vlcentrada as longchar. /* JSON ENTRADA */
def input param vtmp       as char.     /* CAMINHO PROGRESS_TMP */

def var vlcsaida   as longchar.         /* JSON SAIDA */

def var lokjson as log.                 /* LOGICAL DE APOIO */
def var hentrada as handle.             /* HANDLE ENTRADA */
def var hsaida   as handle.             /* HANDLE SAIDA */

def temp-table ttentrada no-undo serialize-name "dadosEntrada"   /* JSON ENTRADA */
    FIELD tipoOperacao          like prodparam.tipoOperacao
    FIELD codpro                like prodparam.codpro
    FIELD assEletronico         like prodparam.assEletronico
    FIELD boletado              like prodparam.boletado
    FIELD vlrMinAcrescimo       like prodparam.vlrMinAcrescimo.

def temp-table ttsaida  no-undo serialize-name "conteudoSaida"  /* JSON SAIDA CASO ERRO */
    field tstatus        as int serialize-name "status"
    field descricaoStatus      as char.

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

if ttentrada.codpro = ? OR ttentrada.tipoOperacao = ''
then do:
    create ttsaida.
    ttsaida.tstatus = 400.
    ttsaida.descricaoStatus = "Dados de Entrada Invalidos".

    hsaida  = temp-table ttsaida:handle.

    lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).
    message string(vlcSaida).
    return.
end.

find prodparam where prodparam.codpro = ttentrada.codpro AND
                        prodparam.tipoOperacao = ttentrada.tipoOperacao
                        no-lock no-error.
IF NOT avail prodparam
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
    find prodparam where prodparam.codpro = ttentrada.codpro AND
                        prodparam.tipoOperacao = ttentrada.tipoOperacao
                        exclusive.

        if ttentrada.assEletronico <> ?
        then do:
            prodparam.assEletronico = ttentrada.assEletronico.
        end.
        if ttentrada.boletado <> ?
        then do:
            prodparam.boletado = ttentrada.boletado.
        end.
        if ttentrada.vlrMinAcrescimo <> ?
        then do:
            prodparam.vlrMinAcrescimo = ttentrada.vlrMinAcrescimo.
        end.
        
end.
    


create ttsaida.
ttsaida.tstatus = 200.
ttsaida.descricaoStatus = "Alterado com sucesso".

hsaida  = temp-table ttsaida:handle.

lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).
put unformatted string(vlcSaida).

