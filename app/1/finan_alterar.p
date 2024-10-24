def input param vlcentrada as longchar. /* JSON ENTRADA */
def input param vtmp       as char.     /* CAMINHO PROGRESS_TMP */

def var vlcsaida   as longchar.         /* JSON SAIDA */

def var lokjson as log.                 /* LOGICAL DE APOIO */
def var hentrada as handle.             /* HANDLE ENTRADA */
def var hsaida   as handle.             /* HANDLE SAIDA */

def temp-table ttentrada no-undo serialize-name "finan"   /* JSON ENTRADA */
    FIELD fincod            like finan.fincod
    FIELD finnom            like finan.finnom
    FIELD finent            like finan.finent
    FIELD finnpc            like finan.finnpc
    FIELD finfat            like finan.finfat
    FIELD datexp            like finan.datexp
    FIELD txjurosmes        like finan.txjurosmes
    FIELD txjurosano        like finan.txjurosano
    FIELD DPriPag           like finan.DPriPag
    FIELD recorrencia       like finan.recorrencia.

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

if ttentrada.fincod = ?
then do:
    create ttsaida.
    ttsaida.tstatus = 400.
    ttsaida.descricaoStatus = "Dados de Entrada Invalidos".

    hsaida  = temp-table ttsaida:handle.

    lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).
    message string(vlcSaida).
    return.
end.

find finan where finan.fincod = ttentrada.fincod no-lock no-error.
IF NOT avail finan
then do:
    create ttsaida.
    ttsaida.tstatus = 400.
    ttsaida.descricaoStatus = "Nenhum plano encontrado!".

    hsaida  = temp-table ttsaida:handle.

    lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).
    message string(vlcSaida).
    return.
end.

 do on error undo:   
    find finan where finan.fincod = ttentrada.fincod exclusive.

        if ttentrada.finnom <> ?
        then do:
            finan.finnom = ttentrada.finnom.
        end.

        if ttentrada.finent <> ?
        then do:
            finan.finent = ttentrada.finent.
        end.

        if ttentrada.finnpc <> ?
        then do:
            finan.finnpc = ttentrada.finnpc.
        end.

        if ttentrada.finfat <> ?
        then do:
            finan.finfat = ttentrada.finfat.
        end.

        if ttentrada.datexp <> ?
        then do:
            finan.datexp = ttentrada.datexp.
        end.

        if ttentrada.txjurosmes <> ?
        then do:
            finan.txjurosmes = ttentrada.txjurosmes.
        end.

        if ttentrada.txjurosano <> ?
        then do:
            finan.txjurosano = ttentrada.txjurosano.
        end.

        if ttentrada.DPriPag <> ?
        then do:
            finan.DPriPag = ttentrada.DPriPag.
        end.

        if ttentrada.recorrencia <> ?
        then do:
            finan.recorrencia = ttentrada.recorrencia.
        end.
        
end.
    


create ttsaida.
ttsaida.tstatus = 200.
ttsaida.descricaoStatus = "Alterado com sucesso".

hsaida  = temp-table ttsaida:handle.

lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).
put unformatted string(vlcSaida).

