def input param vlcentrada as longchar. /* JSON ENTRADA */
def input param vtmp       as char.     /* CAMINHO PROGRESS_TMP */

def var vlcsaida   as longchar.         /* JSON SAIDA */

def var lokjson as log.                 /* LOGICAL DE APOIO */
def var hentrada as handle.             /* HANDLE ENTRADA */
def var hsaida   as handle.             /* HANDLE SAIDA */

def temp-table ttentrada no-undo serialize-name "aconegoc"   /* JSON ENTRADA */
    field negcod like aconegoc.negcod
    field negnom like aconegoc.negnom
    field dtini like aconegoc.dtini
    field dtfim like aconegoc.dtfim
    field vlr_total like aconegoc.vlr_total
    field perc_pagas like aconegoc.perc_pagas
    field qtd_pagas like aconegoc.qtd_pagas
    field dtemissao_de like aconegoc.dtemissao_de
    field dtemissao_ate like aconegoc.dtemissao_ate
    field vlr_parcela like aconegoc.vlr_parcela
    field dias_atraso like aconegoc.dias_atraso
    field vlr_aberto like aconegoc.vlr_aberto
    field modcod like aconegoc.modcod
    field tpcontrato like aconegoc.tpcontrato
    field ParcVencidaSo like aconegoc.ParcVencidaSo
    field ParcVencidaQtd like aconegoc.ParcVencidaQtd
    field ParcVencerQtd like aconegoc.ParcVencerQtd
    field Arrasta like aconegoc.Arrasta
    field PermiteTitProtesto like aconegoc.PermiteTitProtesto
    field calculaSeguroPrestamista like aconegoc.calculaSeguroPrestamista.

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

if ttentrada.negcod = ?
then do:
    create ttsaida.
    ttsaida.tstatus = 400.
    ttsaida.descricaoStatus = "Dados de Entrada Invalidos".

    hsaida  = temp-table ttsaida:handle.

    lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).
    message string(vlcSaida).
    return.
end.

find aconegoc where aconegoc.negcod = ttentrada.negcod no-lock no-error.
if not avail aconegoc
then do:
    create ttsaida.
    ttsaida.tstatus = 400.
    ttsaida.descricaoStatus = "Acordo nao cadastrad0".

    hsaida  = temp-table ttsaida:handle.

    lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).
    message string(vlcSaida).
    return.
end.

find aconegoc where aconegoc.negcod = ttentrada.negcod no-lock no-error.
if NOT avail aconegoc
then do:
    create ttsaida.
    ttsaida.tstatus = 400.
    ttsaida.descricaoStatus = "Acordo nao cadastrado".

    hsaida  = temp-table ttsaida:handle.

    lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).
    message string(vlcSaida).
    return.
end.

do on error undo:
    find aconegoc where aconegoc.negcod = ttentrada.negcod exclusive no-error.

    aconegoc.negnom = ttentrada.negnom.
    aconegoc.dtini = ttentrada.dtini.
    aconegoc.dtfim = ttentrada.dtfim.
    aconegoc.vlr_total = ttentrada.vlr_total.
    aconegoc.perc_pagas = ttentrada.perc_pagas.
    aconegoc.qtd_pagas = ttentrada.qtd_pagas.
    aconegoc.dtemissao_de = ttentrada.dtemissao_de.
    aconegoc.dtemissao_ate = ttentrada.dtemissao_ate.
    aconegoc.vlr_parcela = ttentrada.vlr_parcela.
    aconegoc.dias_atraso = ttentrada.dias_atraso.
    aconegoc.vlr_aberto = ttentrada.vlr_aberto.
    aconegoc.modcod = ttentrada.modcod.
    aconegoc.tpcontrato = ttentrada.tpcontrato.
    aconegoc.ParcVencidaSo = ttentrada.ParcVencidaSo.
    aconegoc.ParcVencidaQtd = ttentrada.ParcVencidaQtd.
    aconegoc.ParcVencerQtd = ttentrada.ParcVencerQtd.
    aconegoc.Arrasta = ttentrada.Arrasta.
    aconegoc.PermiteTitProtesto = ttentrada.PermiteTitProtesto.
    aconegoc.calculaSeguroPrestamista = ttentrada.calculaSeguroPrestamista.

end.


create ttsaida.
ttsaida.tstatus = 200.
ttsaida.descricaoStatus = "Acordo alterado com sucesso".

hsaida  = temp-table ttsaida:handle.

lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).
put unformatted string(vlcSaida).
