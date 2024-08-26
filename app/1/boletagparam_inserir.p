def input param vlcentrada as longchar. /* JSON ENTRADA */
def input param vtmp       as char.     /* CAMINHO PROGRESS_TMP */

def var vlcsaida   as longchar.         /* JSON SAIDA */

def var lokjson as log.                 /* LOGICAL DE APOIO */
def var hentrada as handle.             /* HANDLE ENTRADA */
def var hsaida   as handle.             /* HANDLE SAIDA */

def temp-table ttentrada no-undo serialize-name "dadosEntrada"   /* JSON ENTRADA */
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
if avail boletagparam
then do:
    create ttsaida.
    ttsaida.tstatus = 400.
    ttsaida.descricaoStatus = "ja cadastrado".

    hsaida  = temp-table ttsaida:handle.

    lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).
    message string(vlcSaida).
    return.
end.

find first boletagparam where boletagparam.listamodalidades = ttentrada.listamodalidades AND
                              boletagparam.dtfimvig = ?
                              no-error.
if avail boletagparam
then do:
    boletagparam.dtfimvig = ttentrada.dtinivig - 1.
end.


do on error undo:
    create boletagparam.
    BUFFER-COPY ttentrada TO boletagparam.
end.

create ttsaida.
ttsaida.tstatus = 200.
ttsaida.descricaoStatus = "Criado com sucesso".

hsaida  = temp-table ttsaida:handle.

lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).
put unformatted string(vlcSaida).
