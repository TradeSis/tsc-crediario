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
        RUN LOG("AQUI 01").
END.
IF ttentrada.CliFor <> ? 
THEN DO:
    vclifor = ttentrada.CliFor.
    RUN LOG("AQUI 02") .
END.

        
IF ttentrada.IDAcordo = ? 
THEN DO:
 RUN LOG("CLIFOR -> " + STRING(vclifor)).
    for each aoacordo where aoacordo.Tipo = ttentrada.Tipo AND
        (if vclifor = ? 
        then true else aoacordo.CliFor = vclifor) AND 
        (if ttentrada.etbcod = ? 
        then true else aoacordo.etbcod = ttentrada.etbcod) AND
        
        (if ttentrada.DtAcordoini = ? 
        then true else aoacordo.DtAcordo >= ttentrada.DtAcordoini) AND
        (if ttentrada.DtAcordofim = ? 
        then true else aoacordo.DtAcordo <= ttentrada.DtAcordofim) 
        no-lock.
       
        RUN criaAoAcordo.
    
    end.
END.  
// OLD        
IF ttentrada.IDAcordo <> ?
then do:
RUN LOG("AQUI 0").
        find aoacordo WHERE aoacordo.Tipo = ttentrada.Tipo AND
                            aoacordo.IDAcordo = ttentrada.IDAcordo no-lock.
                            
        
        RUN criaAoAcordo.
END.
/*
ELSE DO:
    IF ttentrada.DtAcordoini <> ? AND ttentrada.DtAcordofim <> ?
    THEN DO:
    RUN LOG("AQUI 1").
           for each aoacordo where aoacordo.Tipo = ttentrada.Tipo AND
                                   aoacordo.DtAcordo >= ttentrada.DtAcordoini AND
                                   aoacordo.DtAcordo <= ttentrada.DtAcordofim
                                   NO-LOCK.
            RUN criaAoAcordo.
        END.          
    END.
    
    
    IF ttentrada.IDAcordo = ? AND ttentrada.DtAcordoini = ? AND ttentrada.DtAcordofim = ?
    THEN DO:
    RUN LOG("AQUI TODOS").
           for each aoacordo WHERE aoacordo.Tipo = ttentrada.Tipo NO-LOCK.
                RUN criaAoacordo.
            END.
     END.          
 
END.
    */
 
 /*
IF ttentrada.DtAcordoini <> ? AND ttentrada.DtAcordofim <> ? AND ttentrada.IDAcordo = ?
THEN DO:
RUN LOG("AQUI 1")).
       for each aoacordo where aoacordo.Tipo = ttentrada.Tipo AND
                               aoacordo.DtAcordo >= ttentrada.DtAcordoini AND
                               aoacordo.DtAcordo <= ttentrada.DtAcordofim
                               NO-LOCK.
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
    END.          
END.

ELSE DO:
RUN LOG("AQUI 2")).
    for each aoacordo WHERE aoacordo.Tipo = ttentrada.Tipo NO-LOCK.
        //RUN criaAoacordo.
    END.
    
end.
 */



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


procedure LOG.
    DEF INPUT PARAM vmensagem AS CHAR.    
    OUTPUT TO VALUE(vtmp + "/AOACORDO_" + string(today,"99999999") + ".log") APPEND.
        PUT UNFORMATTED 
            STRING (TIME,"HH:MM:SS")
            " progress -> " vmensagem
            SKIP.
    OUTPUT CLOSE.
    
END PROCEDURE.


