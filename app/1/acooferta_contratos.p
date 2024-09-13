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

def temp-table ttacoofertacont  no-undo serialize-name "acoofertacont"  /* JSON SAIDA */
    field negcod like aconegoc.negcod
    field negnom like aconegoc.negnom
    field qtd as int
    field vlr_aberto as dec
    field vlr_divida as dec
    field qtd_selecionado as int
    field vlr_selaberto as dec
    field vlr_selecionado as dec.


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

def var ptpnegociacao as char.
def var par-clicod like clien.clicod.
def var vmessage as log.

ptpnegociacao = ttentrada.ptpnegociacao.
par-clicod = ttentrada.clicod.
vmessage = no.

/*{/admcom/progr/aco/acordo.i new} */


/*def buffer bttnegociacao for ttnegociacao. */

/* 
 create ttacoofertacont.
 ttacoofertacont.negcod            =  1  . /* conegoc.negcod. */
 ttacoofertacont.negnom            =   "teste x" . /* aconegoc.negnom. */
 ttacoofertacont.qtd               =   20 . /* ttnegociacao.qtd.   */
 ttacoofertacont.vlr_aberto        =   14192.55 . /* ttnegociacao.vlr_aberto.    */
 ttacoofertacont.vlr_divida        =    137894.70. /* ttnegociacao.vlr_divida.    */
 ttacoofertacont.qtd_selecionado   =    20. /* ttnegociacao.qtd_selecionado. */
 ttacoofertacont.vlr_selaberto     =    14192.55 . /* ttnegociacao.vlr_selaberto.   */
 ttacoofertacont.vlr_selecionado   =    137894.70. /*  ttnegociacao.vlr_selecionado.*/
       
END. */

        

find first ttacoofertacont no-error.
if not avail ttacoofertacont
then do:
    create ttsaida.
    ttsaida.tstatus = 400.
    ttsaida.descricaoStatus = "Nao encontrado".

    hsaida  = temp-table ttsaida:handle.

    lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).
    message string(vlcSaida).
    return.
end. 

hsaida  = TEMP-TABLE ttacoofertacont:handle.


lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).
put unformatted string(vlcSaida).
return string(vlcSaida).


