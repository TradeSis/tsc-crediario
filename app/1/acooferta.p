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

def var ptpnegociacao as char.
def var par-clicod like clien.clicod.
def var vmessage as log.

ptpnegociacao = ttentrada.ptpnegociacao.
par-clicod = ttentrada.clicod.
vmessage = no.

{acha.i}
{aco/acordo.i new} 

def temp-table ttcliente  no-undo serialize-name "cliente"
    field clicod  like clien.clicod    
    field cpfCNPJ  like clien.ciccgc 
    field clinom   like clien.clinom
    field etbcad   like clien.etbcad.
    

def dataset acooferta for ttcliente, ttnegociacao.


/*def buffer bttnegociacao for ttnegociacao. */


IF ttentrada.clicod <> ?
then do:
    find clien where clien.clicod = par-clicod no-lock no-error.
    if not avail clien
    then do:
        create ttsaida.
        ttsaida.tstatus = 400.
        ttsaida.descricaoStatus = "Nao encontrado".

        hsaida  = temp-table ttsaida:handle.

        lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).
        message string(vlcSaida).
        return.
    end.
    else do:
        create ttcliente.
        ttcliente.clicod   =  clien.clicod.
        ttcliente.cpfCNPJ  =  clien.ciccgc.
        ttcliente.clinom   =  clien.clinom.
        ttcliente.etbcad   =  clien.etbcad.


        FIND clien WHERE clien.clicod = ttentrada.clicod NO-LOCK.
         
        run calcelegiveis (input ttentrada.ptpnegociacao, input ttentrada.clicod, ?).
        for each ttnegociacao.
            find aconegoc of ttnegociacao no-lock.
            ttnegociacao.negnom = aconegoc.negnom.
        end.
/*

        create ttnegociacao.
        ttnegociacao.negcod            =  1  . /* conegoc.negcod. */
        ttnegociacao.negnom            =   "teste x" . /* aconegoc.negnom. */
        ttnegociacao.qtd               =   20 . /* ttnegociacao.qtd.   */
        ttnegociacao.vlr_aberto        =   14192.55 . /* ttnegociacao.vlr_aberto.    */
        ttnegociacao.vlr_divida        =    137894.70. /* ttnegociacao.vlr_divida.    */
        ttnegociacao.qtd_selecionado   =    20. /* ttnegociacao.qtd_selecionado. */
        ttnegociacao.vlr_selaberto     =    14192.55 . /* ttnegociacao.vlr_selaberto.   */
        ttnegociacao.vlr_selecionado   =    137894.70. /*  ttnegociacao.vlr_selecionado.*/

        create ttnegociacao.
        ttnegociacao.negcod            =  2  . /* conegoc.negcod. */
        ttnegociacao.negnom            =   "teste 2" . /* aconegoc.negnom. */
        ttnegociacao.qtd               =   20 . /* ttnegociacao.qtd.   */
        ttnegociacao.vlr_aberto        =   14192.55 . /* ttnegociacao.vlr_aberto.    */
        ttnegociacao.vlr_divida        =    137894.70. /* ttnegociacao.vlr_divida.    */
        ttnegociacao.qtd_selecionado   =    20. /* ttnegociacao.qtd_selecionado. */
        ttnegociacao.vlr_selaberto     =    14192.55 . /* ttnegociacao.vlr_selaberto.   */
        ttnegociacao.vlr_selecionado   =    137894.70. /*  ttnegociacao.vlr_selecionado.*/
*/
    end.
       
END.

        

find first ttnegociacao no-error.
if not avail ttnegociacao
then do:
    create ttsaida.
    ttsaida.tstatus = 400.
    ttsaida.descricaoStatus = "Nao encontrado".

    hsaida  = temp-table ttsaida:handle.

    lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).
    message string(vlcSaida).
    return.
end. 

hsaida  = dataset acooferta:handle.


lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).
put unformatted string(vlcSaida).
return string(vlcSaida).


