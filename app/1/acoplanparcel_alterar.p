def input param vlcentrada as longchar. /* JSON ENTRADA */
def input param vtmp       as char.     /* CAMINHO PROGRESS_TMP */

def var vlcsaida   as longchar.         /* JSON SAIDA */
def var lokjson as log.                 /* LOGICAL DE APOIO */
def var hentrada as handle.             /* HANDLE ENTRADA */
def var hsaida   as handle.             /* HANDLE SAIDA */

def temp-table ttentrada no-undo serialize-name "acoplanparcel"   /* JSON ENTRADA */
    field id_recid_plan as int64
    field perc_parcel AS DEC

    field negcod like aconegoc.negcod
    field placod like acoplanos.placod
    FIELD titpar LIKE acoplanparcel.titpar.

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


find acoplanos where recid(acoplanos) = ttentrada.id_recid_plan no-lock.

run crediario/app/1/paramparcelas.p (input "alterar",
                                     recid(acoplanos),
                                     input ttentrada.perc_parcel,
                                     input ttentrada.negcod,
                                     input ttentrada.placod,
                                     input ttentrada.titpar).




create ttsaida.
ttsaida.tstatus = 200.
ttsaida.descricaoStatus = "Plano Parcela alterado com sucesso".

hsaida  = temp-table ttsaida:handle.

lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).
put unformatted string(vlcSaida).

