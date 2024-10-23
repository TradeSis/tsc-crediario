def input param vlcentrada as longchar. /* JSON ENTRADA */
def input param vtmp       as char.     /* CAMINHO PROGRESS_TMP */

def var vlcsaida   as longchar.         /* JSON SAIDA */

def var lokjson as log.                 /* LOGICAL DE APOIO */
def var hentrada as handle.             /* HANDLE ENTRADA */
def var hsaida   as handle.             /* HANDLE SAIDA */

def temp-table ttentrada no-undo serialize-name "dadosEntrada"   /* JSON ENTRADA */
    field cobcod  like cobparam.cobcod
    field tipoOperacao  like cobparam.tipoOperacao.

def temp-table ttcobparam  no-undo serialize-name "cobparam"  /* JSON SAIDA */
    like cobparam
    field cobnom like cobra.cobnom
    field clanome like clase.clanome.

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
    ttsaida.descricaoStatus = "Dados de entrada nao encontrado".

    hsaida  = temp-table ttsaida:handle.

    lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).
    message string(vlcSaida).
    return.
end.

for each cobparam where
    (if ttentrada.cobcod = ? AND ttentrada.tipoOperacao = ?
    then true /* TODOS */
    ELSE cobparam.cobcod = ttentrada.cobcod AND cobparam.tipoOperacao = ttentrada.tipoOperacao)
    no-lock.

    create ttcobparam.
    BUFFER-COPY cobparam TO ttcobparam.
    
    find cobra of cobparam no-lock no-error.
    if avail cobra
    then ttcobparam.cobnom = cobra.cobnom.
    
    find clase WHERE clase.clacod = cobparam.clacod no-lock no-error.
    if avail cobra
    then ttcobparam.clanome = clase.clanome.

end. 


find first ttcobparam no-error.
if not avail ttcobparam
then do:
    create ttsaida.
    ttsaida.tstatus = 400.
    ttsaida.descricaoStatus = "parametros nao encontrado".

    hsaida  = temp-table ttsaida:handle.

    lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).
    message string(vlcSaida).
    return.
end.

hsaida  = TEMP-TABLE ttcobparam:handle.


lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).
put unformatted string(vlcSaida).



