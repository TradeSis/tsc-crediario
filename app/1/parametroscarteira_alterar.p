def input param vlcentrada as longchar. /* JSON ENTRADA */
def input param vtmp       as char.     /* CAMINHO PROGRESS_TMP */

def var vlcsaida   as longchar.         /* JSON SAIDA */

def var lokjson as log.                 /* LOGICAL DE APOIO */
def var hentrada as handle.             /* HANDLE ENTRADA */
def var hsaida   as handle.             /* HANDLE SAIDA */

def temp-table ttentrada no-undo serialize-name "dadosEntrada"   /* JSON ENTRADA */
    FIELD tipoOperacao                  like cobparam.tipoOperacao
    FIELD cobcod                        like cobparam.cobcod
    FIELD valMinParc                    like cobparam.valMinParc
    FIELD qtdMinParc                    like cobparam.qtdMinParc
    FIELD valorMinimoAcrescimoTotal     like cobparam.valorMinimoAcrescimoTotal.

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

if ttentrada.cobcod = ? OR ttentrada.tipoOperacao = ''
then do:
    create ttsaida.
    ttsaida.tstatus = 400.
    ttsaida.descricaoStatus = "Dados de Entrada Invalidos".

    hsaida  = temp-table ttsaida:handle.

    lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).
    message string(vlcSaida).
    return.
end.

find cobparam where cobparam.cobcod = ttentrada.cobcod AND
                        cobparam.tipoOperacao = ttentrada.tipoOperacao
                        no-lock no-error.
IF NOT avail cobparam
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
    find cobparam where cobparam.cobcod = ttentrada.cobcod AND
                        cobparam.tipoOperacao = ttentrada.tipoOperacao
                        exclusive.

        if ttentrada.valMinParc <> ?
        then do:
            cobparam.valMinParc = ttentrada.valMinParc.
        end.
        if ttentrada.qtdMinParc <> ?
        then do:
            cobparam.qtdMinParc = ttentrada.qtdMinParc.
        end.
        if ttentrada.valorMinimoAcrescimoTotal <> ?
        then do:
            cobparam.valorMinimoAcrescimoTotal = ttentrada.valorMinimoAcrescimoTotal.
        end.
        
end.
    


create ttsaida.
ttsaida.tstatus = 200.
ttsaida.descricaoStatus = "Alterado com sucesso".

hsaida  = temp-table ttsaida:handle.

lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).
put unformatted string(vlcSaida).

