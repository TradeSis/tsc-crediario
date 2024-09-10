def input param vlcentrada as longchar. /* JSON ENTRADA */
def input param vtmp       as char.     /* CAMINHO PROGRESS_TMP */

def var vlcsaida   as longchar.         /* JSON SAIDA */

def var lokjson as log.                 /* LOGICAL DE APOIO */
def var hentrada as handle.             /* HANDLE ENTRADA */
def var hsaida   as handle.             /* HANDLE SAIDA */

def temp-table ttentrada no-undo serialize-name "acoplanos"   /* JSON ENTRADA */
    field id_recid_neg as int64
    field placod like acoplanos.placod
    field planom like acoplanos.planom
    field calc_juro_titulo like acoplanos.calc_juro_titulo
    field com_entrada like acoplanos.com_entrada
    field perc_min_entrada like acoplanos.perc_min_entrada
    field dias_max_primeira like acoplanos.dias_max_primeira
    field qtd_vezes like acoplanos.qtd_vezes
    field perc_desconto like acoplanos.perc_desconto
    field perc_acres like acoplanos.perc_acres
    field permite_alt_vezes like acoplanos.permite_alt_vezes
    field valor_acres like acoplanos.valor_acres
    field valor_desc like acoplanos.valor_desc.

def temp-table ttsaida  no-undo serialize-name "conteudoSaida"  /* JSON SAIDA CASO ERRO */
    field tstatus        as int serialize-name "status"
    field descricaoStatus      as char.

def VAR par-rec as recid.
def buffer bacoplanos for acoplanos.



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

par-rec = ttentrada.id_recid_neg.

do on error undo:
    find aconegoc where recid(aconegoc) = par-rec no-lock.
    find last bacoplanos of aconegoc no-lock no-error.

    create acoplanos.
    acoplanos.negcod = aconegoc.negcod.
    acoplanos.placod = if avail bacoplanos then bacoplanos.placod + 1 else 1.
    acoplanos.planom = ttentrada.planom.
    acoplanos.calc_juro_titulo = ttentrada.calc_juro_titulo.
    acoplanos.com_entrada = ttentrada.com_entrada.
    acoplanos.perc_min_entrada = ttentrada.perc_min_entrada.
    acoplanos.dias_max_primeira = ttentrada.dias_max_primeira.
    acoplanos.qtd_vezes = ttentrada.qtd_vezes.
    acoplanos.perc_desconto = ttentrada.perc_desconto.
    acoplanos.perc_acres = ttentrada.perc_acres.
    acoplanos.permite_alt_vezes = ttentrada.permite_alt_vezes.
    acoplanos.valor_acres = ttentrada.valor_acres.
    acoplanos.valor_desc = ttentrada.valor_desc.

end.


create ttsaida.
ttsaida.tstatus = 200.
ttsaida.descricaoStatus = "Plano criado com sucesso".

hsaida  = temp-table ttsaida:handle.

lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).
put unformatted string(vlcSaida).
