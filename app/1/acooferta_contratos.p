def input param vlcentrada as longchar. /* JSON ENTRADA */
def input param vtmp       as char.     /* CAMINHO PROGRESS_TMP */

def var vlcsaida   as longchar.         /* JSON SAIDA */

def var lokjson as log.                 /* LOGICAL DE APOIO */
def var hentrada as handle.             /* HANDLE ENTRADA */
def var hsaida   as handle.             /* HANDLE SAIDA */

def temp-table ttentrada no-undo serialize-name "dadosEntrada"   /* JSON ENTRADA */
    field ptpnegociacao as CHAR
    field clicod like clien.clicod
    field negcod like aconegoc.negcod.


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

def var vmessage as log.

vmessage = no.
{acha.i}
{aco/acordo.i new} 

    FIND clien WHERE clien.clicod = ttentrada.clicod NO-LOCK.

    FIND aconegoc WHERE aconegoc.negcod = ttentrada.negcod NO-LOCK.
    run calcelegiveis (input aconegoc.tpNegociacao, input ttentrada.clicod, ttentrada.negcod).
    for each ttcontrato.
        find contrato of ttcontrato no-lock. 
        ttcontrato.etbcod = contrato.etbcod.
        ttcontrato.modcod = contrato.modcod.

    end.

/*   
 create ttcontrato.
 ttcontrato.marca = FALSE.
 ttcontrato.negcod = 1.
 ttcontrato.contnum = 1.
 ttcontrato.tpcontrato = "XPTO".
 ttcontrato.vlr_aberto = 120.
 ttcontrato.vlr_divida = 1200.
 ttcontrato.vlr_parcela = 25.
 ttcontrato.dt_venc = today.
 ttcontrato.dias_atraso = 5.
 ttcontrato.qtd_pagas = 2.
 ttcontrato.qtd_parcelas = 12.
 ttcontrato.perc_pagas = 10.
 ttcontrato.vlr_vencido = 220.
 ttcontrato.vlr_vencer = 225.
 ttcontrato.trectitprotesto = 12345.
 
 create ttcontrato.
 ttcontrato.marca = TRUE.
 ttcontrato.negcod = 2.
 ttcontrato.contnum = 2.
 ttcontrato.tpcontrato = "XPTO2".
 ttcontrato.vlr_aberto = 220.
 ttcontrato.vlr_divida = 2200.
 ttcontrato.vlr_parcela = 55.
 ttcontrato.dt_venc = today.
 ttcontrato.dias_atraso = 10.
 ttcontrato.qtd_pagas = 20.
 ttcontrato.qtd_parcelas = 22.
 ttcontrato.perc_pagas = 20.
 ttcontrato.vlr_vencido = 420.
 ttcontrato.vlr_vencer = 525.
 ttcontrato.trectitprotesto = 64789.
   */
       


        

find first ttcontrato no-error.
if not avail ttcontrato
then do:
    create ttsaida.
    ttsaida.tstatus = 400.
    ttsaida.descricaoStatus = "Nao encontrado".

    hsaida  = temp-table ttsaida:handle.

    lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).
    message string(vlcSaida).
    return.
end. 

hsaida  = TEMP-TABLE ttcontrato:handle.


lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).
put unformatted string(vlcSaida).
return string(vlcSaida).


