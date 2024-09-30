def input param vlcentrada as longchar. /* JSON ENTRADA */
def input param vtmp       as char.     /* CAMINHO PROGRESS_TMP */

def var vlcsaida   as longchar.         /* JSON SAIDA */

def var lokjson as log.                 /* LOGICAL DE APOIO */
def var hentrada as handle.             /* HANDLE ENTRADA */
def var hsaida   as handle.             /* HANDLE SAIDA */

def temp-table ttentrada no-undo serialize-name "dadosEntrada"   /* JSON ENTRADA */
    field IDAcordo like aoacordo.IDAcordo
    FIELD DtAcordoini AS DATE
    FIELD DtAcordofim AS DATE
    field CliFor  like aoacordo.CliFor
    field cpfcnpj  like clien.ciccgc
    field etbcod  like aoacordo.etbcod
    field Tipo like aoacordo.Tipo.

def temp-table ttaoacordo  no-undo serialize-name "aoacordo"  /* JSON SAIDA  */
    like aoacordo
    FIELD clicod LIKE clien.clicod
    FIELD ciccgc LIKE clien.ciccgc
    FIELD clinom LIKE clien.clinom 
    FIELD id_recid      AS INT64.    

def temp-table ttsaida  no-undo serialize-name "conteudoSaida"  /* JSON SAIDA CASO ERRO */
    field tstatus        as int serialize-name "status"
    field descricaoStatus      as char.

def var vclifor like ttentrada.clifor.

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
 
vclifor = ?.
IF ttentrada.cpfcnpj <> ? 
THEN DO:
    FIND clien WHERE clien.ciccgc = ttentrada.cpfcnpj NO-LOCK NO-ERROR.
    IF avail clien
    then vclifor = clien.clicod.
END.
IF ttentrada.CliFor <> ? 
THEN DO:
    vclifor = ttentrada.CliFor.
END.

        
IF ttentrada.IDAcordo = ? 
THEN DO:
    for each aoacordo where aoacordo.Tipo = ttentrada.Tipo AND
                    aoacordo.DtAcordo >= ttentrada.DtAcordoini AND
                    aoacordo.DtAcordo <= ttentrada.DtAcordofim and
            (if ttentrada.etbcod = ? 
             then true else aoacordo.etbcod = ttentrada.etbcod) 
             no-lock.

        if vclifor <> ? 
        then if aoacordo.CliFor <> vclifor
             then next.
       
        RUN criaAoAcordo.
    
    end.
END.  
      
IF ttentrada.IDAcordo <> ?
then do:
    find aoacordo WHERE aoacordo.IDAcordo = ttentrada.IDAcordo no-lock.
                            
    RUN criaAoAcordo.
END.


find first ttaoacordo no-error.
if not avail ttaoacordo
then do:
    create ttsaida.
    ttsaida.tstatus = 400.
    ttsaida.descricaoStatus = "Nao encontrado".

    hsaida  = temp-table ttsaida:handle.

    lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).
    message string(vlcSaida).
    return.
end.

hsaida  = TEMP-TABLE ttaoacordo:handle.


lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).
put unformatted string(vlcSaida).
return string(vlcSaida).

PROCEDURE criaAoAcordo.

    FIND clien WHERE clien.clicod = aoacordo.CliFor NO-LOCK.
            
            create ttaoacordo.
            BUFFER-COPY aoacordo TO ttaoacordo.
            IF AVAIL clien
            THEN DO:
                ttaoacordo.clicod = clien.clicod.  
                ttaoacordo.ciccgc = clien.ciccgc. 
                ttaoacordo.clinom = clien.clinom.    
            END.
            
            ttaoacordo.id_recid = RECID(aoacordo).

END PROCEDURE.
