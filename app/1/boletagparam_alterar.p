def input param vlcentrada as longchar. /* JSON ENTRADA */
def input param vtmp       as char.     /* CAMINHO PROGRESS_TMP */

def var vlcsaida   as longchar.         /* JSON SAIDA */

def var lokjson as log.                 /* LOGICAL DE APOIO */
def var hentrada as handle.             /* HANDLE ENTRADA */
def var hsaida   as handle.             /* HANDLE SAIDA */

def temp-table ttentrada no-undo serialize-name "boletagparam"   /* JSON ENTRADA */
    FIELD dtIniVig                like boletagparam.dtIniVig
    FIELD listaModalidades        like boletagparam.listaModalidades
    FIELD QtdParcMin              like boletagparam.QtdParcMin
    FIELD QtdParcMax              like boletagparam.QtdParcMax
    FIELD listaCarterias          like boletagparam.listaCarterias
    FIELD AssinaturaDigital       like boletagparam.AssinaturaDigital
    FIELD IdadeMin                like boletagparam.IdadeMin
    FIELD IdadeMax                like boletagparam.IdadeMax
    FIELD DiasPrimeiroVencMin     like boletagparam.DiasPrimeiroVencMin
    FIELD DiasPrimeiroVencMax     like boletagparam.DiasPrimeiroVencMax
    FIELD valorParcelMin          like boletagparam.valorParcelMin
    FIELD valorParcelaMax         like boletagparam.valorParcelaMax
    FIELD listaPlanos             like boletagparam.listaPlanos.

def temp-table ttsaida  no-undo serialize-name "conteudoSaida"  /* JSON SAIDA CASO ERRO */
    field tstatus        as int serialize-name "status"
    field descricaoStatus      as char.

DEF BUFFER bboletagparam FOR boletagparam.

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

if ttentrada.dtIniVig = ? OR ttentrada.listamodalidades = ''
then do:
    create ttsaida.
    ttsaida.tstatus = 400.
    ttsaida.descricaoStatus = "Dados de Entrada Invalidos".

    hsaida  = temp-table ttsaida:handle.

    lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).
    message string(vlcSaida).
    return.
end.

find boletagparam where boletagparam.dtIniVig = ttentrada.dtIniVig AND
                        boletagparam.listamodalidades = ttentrada.listamodalidades
                        no-lock no-error.
IF NOT avail boletagparam
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
    find current boletagparam exclusive.
    if  boletagparam.dtIniVig < today and
        boletagparam.dtFimVig = ?
    then do:
        boletagparam.dtfimvig = today - 1.
        create bboletagparam.
        buffer-copy boletagparam 
            except dtinivig dtfimvig to bboletagparam.
        bboletagparam.dtinivig = today.
        find boletagparam where recid(boletagparam) = recid(bboletagparam) exclusive.
    end.

        if ttentrada.listaModalidades <> ?
        then do:
            boletagparam.listaModalidades = ttentrada.listaModalidades.
        end.
        if ttentrada.QtdParcMin <> ?
        then do:
            boletagparam.QtdParcMin = ttentrada.QtdParcMin.
        end.
        if ttentrada.QtdParcMax <> ?
        then do:
            boletagparam.QtdParcMax = ttentrada.QtdParcMax.
        end.
        if ttentrada.listaCarterias <> ?
        then do:
            boletagparam.listaCarterias = ttentrada.listaCarterias.
        end.
        if ttentrada.AssinaturaDigital <> ?
        then do:
            boletagparam.AssinaturaDigital = ttentrada.AssinaturaDigital.
        end.
        if ttentrada.IdadeMin <> ?
        then do:
            boletagparam.IdadeMin = ttentrada.IdadeMin.
        end.
        if ttentrada.IdadeMax <> ?
        then do:
            boletagparam.IdadeMax = ttentrada.IdadeMax.
        end.
        if ttentrada.DiasPrimeiroVencMin <> ?
        then do:
            boletagparam.DiasPrimeiroVencMin = ttentrada.DiasPrimeiroVencMin.
        end.
        if ttentrada.DiasPrimeiroVencMax <> ?
        then do:
            boletagparam.DiasPrimeiroVencMax = ttentrada.DiasPrimeiroVencMax.
        end.
        if ttentrada.valorParcelMin <> ?
        then do:
            boletagparam.valorParcelMin = ttentrada.valorParcelMin.
        end.
        if ttentrada.valorParcelaMax <> ?
        then do:
            boletagparam.valorParcelaMax = ttentrada.valorParcelaMax.
        end.
        if ttentrada.listaPlanos <> ?
        then do:
            boletagparam.listaPlanos = ttentrada.listaPlanos.
        end.
end.
    


create ttsaida.
ttsaida.tstatus = 200.
ttsaida.descricaoStatus = "Alterado com sucesso".

hsaida  = temp-table ttsaida:handle.

lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).
put unformatted string(vlcSaida).

