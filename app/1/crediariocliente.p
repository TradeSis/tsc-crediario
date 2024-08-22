
def input param vlcentrada as longchar.
def input param vtmp       as char.

def var vlcsaida   as longchar.
def var vsaida as char.

def var lokjson as log.
def var hentrada as handle.
def var hsaida   as handle.
/*
{
    "cliente": [
        {
            "codigoCliente": 1513,
            "cpfCNPJ": "",
            "situacao": "LIB" // LIB, PAG, "" (todas)
        }
    ]
}
*/
def temp-table ttentrada no-undo serialize-name "cliente"
    field codigoCliente as int init ?
    field cpfCNPJ       as char init ?
    field situacao      as char.

def temp-table ttcliente  no-undo serialize-name "cliente"
    field codigoCliente                 as int    
    field cpfCNPJ                       as char 
    field nomeCliente                   as char
    field dataCadastro                  as date
    field vvlrLimite                    as char
    field vcomprometido                 as char
    field vcomprometido-principal       as char
    field vsaldoLimite                  as char
    field vvlrLimiteEP                  as char
    field vcomprometidoEP               as char
    field vcomprometido-principalEP     as char
    field vsaldoLimiteEP                as char
    field vvctoLimite                   as date
    field vDTULTCPA                     as date
    field vQTDECONT                     as int
    field vPARCPAG                      as int
    field vPARCABERT                    as int
    field vDTULTNOV                     as date
    field qtd-15                        as int
    field perc-15                       as char
    field vMEDIACONT                    as char
    field qtd-45                        as int
    field perc-45                       as char
    field vMAIORACUM                    as char
    field vDTMAIORACUM                  as char
    field qtd-46                        as int
    field perc-46                       as char
    field vPARCMEDIA                    as char
    field vrepar                        as char
    field vproximo-mes                  as char
    field vATRASOATUAL                  as int
    field vDTMAIORATRASO                as date
    field vVLRPARCVENC                  as char
    field vcheque_devolvido             as char.



def temp-table ttsaida  no-undo serialize-name "conteudoSaida"
    field tstatus        as int serialize-name "status"
    field descricaoStatus      as char.
   

/** VAR DADOS POSICAO CLIENTE **/
def var vvlrlimite as dec.
def var vvctolimite as date.
def var vvlrlimiteEP as dec.
def var vcomprometido as dec.
def var vcomprometido-principal as dec.

def var vcomprometido-hubseg as dec.

def var vsaldoLimite as dec.
def var vcomprometidoEP as dec.
def var vcomprometido-principalEP as dec.

def var vsaldoLimiteEP as dec.

{/admcom/progr/neuro/achahash.i}
{/admcom/progr/neuro/varcomportamento.i}

def var vDTULTCPA as date format "99/99/9999".
def var vDTULTNOV as date format "99/99/9999".

def var vQTDECONT   as int format ">>>>9".
def var vPARCPAG    as int format ">>>>9".
def var vPARCABERT  as int format ">>>>9".
def var vMEDIACONT  as dec.
def var vMAIORACUM  as dec.
def var vDTMAIORACUM    as char.
def var vPARCMEDIA  as dec.
def var vSALDOTOTNOV   as dec.
def var vATRASOATUAL as int.
def var vDTMAIORATRASO as date.
def var vMAIORATRASO    as int.
def var vVLRPARCVENC    as dec.

def var vcheque_devolvido as dec.
def var vcheque as dec.
def var vloop as int.
def var vrepar       as log format "Sim/Nao".
def var vproximo-mes like clien.limcrd.

def var qtd-15       as int format ">>>>9".
def var qtd-45       as int format ">>>>9".
def var qtd-46       as int format ">>>>9".
def var perc-15      as dec format ">>9.99%".
def var perc-45      as dec format ">>9.99%".
def var perc-46      as dec format ">>9.99%".


def var vdtultpagto as date.
def var vspc_lebes as log.
/** VAR DADOS POSICAO CLIENTE **/


hEntrada = temp-table ttentrada:HANDLE.
lokJSON = hentrada:READ-JSON("longchar",vlcentrada, "EMPTY").
find first ttentrada no-error.
if not avail ttentrada
then do:
    create ttsaida.
    ttsaida.tstatus = 500.
    ttsaida.descricaoStatus = "Sem dados de Entrada".

    hsaida  = temp-table ttsaida:handle.

    lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).
    message string(vlcSaida).
    return.
end.

find clien where clien.clicod = ttentrada.codigoCliente no-lock no-error.
if not avail clien or (ttentrada.codigoCliente = 0 or ttentrada.codigoCliente = ?)
then do:
    find clien where clien.ciccgc = trim(ttentrada.cpfCNPJ) no-lock no-error.
end.
if not avail clien
then do:
    create ttsaida.
    ttsaida.tstatus = 400.
    ttsaida.descricaoStatus = "Cliente não encontrado".

    hsaida  = temp-table ttsaida:handle.

    lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).
    message string(vlcSaida).
    return.
end.

/** POSICAO CLIENTE **/
find neuclien where neuclien.clicod = clien.clicod no-lock no-error.

vvlrlimite = 0.
vvctolimite = ?.
vdtultpagto = ?.
vcomprometido = 0.

vsaldoLimite = 0.
vspc_lebes  = no.
vrepar = no.
vvctolimite = if avail neuclien then neuclien.vctolimite else ?.
vvlrlimite = if avail neuclien then neuclien.vlrlimite else 0.

vcomprometido-hubseg = 0.    

def var c1 as char.
def var r1 as char format "x(30)".
def var il as int.
def var vcampo as char format "x(20)". 
var-propriedades = "".

run /admcom/progr/neuro/comportamento.p (clien.clicod,?,output var-propriedades).
    
perc-15 = 0.
perc-45 = 0.
perc-46 = 0.
qtd-15 = 0.
qtd-45 = 0.
qtd-46 = 0.
    
do il = 1 to num-entries(var-propriedades,"#") with down.

    vcampo = entry(1,entry(il,var-propriedades,"#"),"=").
    if vcampo = "FIM"
    then next.
    r1 = pega_prop(vcampo).
    /* #03102022 if vcampo = "LIMITE"    then vvlrlimite = dec(r1). */
    if vcampo = "LIMITEEP"  then vvlrlimiteEP = dec(r1).
    
    if vcampo = "LIMITETOMPR" then vcomprometido-principal = dec(r1).
    if vcampo = "LIMITETOMHUBSEG" then vcomprometido-hubseg = dec(r1).
    
    if vcampo = "LIMITETOMPREP" then vcomprometido-principalEP = dec(r1).
    
    if vcampo = "LIMITETOM"  then vcomprometido = dec(r1). 
    if vcampo = "LIMITETOMEP"        then vcomprometidoEP = dec(r1).
    
    if vcampo = "DTULTPAGTO"
    then  vdtultpagto = date(r1).
    
    if vcampo = "DTULTCPA" then vDTULTCPA = date(r1).
    if vcampo = "DTULTNOV" then vDTULTNOV = date(r1).
    
    if vcampo = "QTDECONT"
    then vQTDECONT = int(r1).
    if vcampo = "PARCPAG"
    then vPARCPAG = int(r1).
     if vcampo = "PARCABERT"
    then vPARCABERT = int(r1).
    if vcampo = "ATRASOPARC"
    then do:

        r1 = replace(r1,"%","").
        if num-entries(r1,"|") = 3 
        then do:
            qtd-15 = int(entry(1,r1,"|")).
            qtd-45 = int(entry(2,r1,"|")).
            qtd-46 = int(entry(3,r1,"|")).
        end.    
    end.
    if vcampo = "ATRASOPARCPERC"
    then do:
        
        r1 = replace(r1,"%",""). 
        if num-entries(r1,"|") = 3
        then do:
            perc-15 = dec(entry(1,r1,"|")).
            perc-45 = dec(entry(2,r1,"|")).
            perc-46 = dec(entry(3,r1,"|")).
        end.    
    end.
    if vcampo = "MEDIACONT"
    then vMEDIACONT = dec(r1).
    if vcampo = "MAIORACUM"
    then vMAIORACUM = dec(r1).
    if vcampo = "DTMAIORACUM"
    then vDTMAIORACUM = r1.
    if vcampo = "PARCMEDIA"
    then vPARCMEDIA = dec(r1).
    if vcampo = "SALDOTOTNOV"
    then do:
        vSALDOTOTNOV  = dec(r1).
        vrepar     = vSALDOTOTNOV > 0.
    end.
    if vcampo = "LSTCOMPROMET"
    then  vproximo-mes = dec(entry(2,r1,"|")).   
    if vcampo = "ATRASOATUAL"
    then vATRASOATUAL = int(r1).
    if vcampo = "DTMAIORATRASO"
    then vDTMAIORATRASO = date(r1).
    if vcampo = "MAIORATRASO"
    then vMAIORATRASO = int(r1).
    if vcampo = "VLRPARCVENC"
    then vVLRPARCVENC = dec(r1).        
    if vcampo = "VALORCHDEVOLV"
    then do:
        do vloop = 1 to num-entries(r1,"|"):
            vcheque = dec(entry(vloop,r1,"|")) no-error.
            if vcheque <> ?
            then vcheque_devolvido = vcheque_devolvido + vcheque. 
        end.
    end.
       
end.
vcomprometido-principal = vcomprometido-principal - vcomprometido-hubseg.
vsaldoLimite = vvlrlimite - (vcomprometido-principal).

vsaldoLimiteEP = vvlrlimiteEP - vcomprometido-principalEP.

/*if (vvctolimite < today or vvctolimite = ? )
    //and setbcod <> 999
then do:
    vvlrlimite   = 0.
    vsaldoLimite = 0.
end.     
if (vvctolimite < today or vvctolimite = ? )
    and setbcod <> 999
then do:
    vsaldoLimiteEP = 0. 
    vvlrlimiteep = 0.
end.  */
/** POSICAO CLIENTE **/



create ttcliente.
ttcliente.codigoCliente = clien.clicod.
ttcliente.cpfCNPJ       = clien.ciccgc.
ttcliente.nomeCliente   = clien.clinom. 
ttcliente.dataCadastro  = clien.dtcad. 
/*CREDITO*/
ttcliente.vvlrLimite   = trim(string(vvlrLimite,"->>>>>>>>>>>>>>>>>>9.99")). 
ttcliente.vcomprometido   = trim(string(vcomprometido,"->>>>>>>>>>>>>>>>>>9.99")). 
ttcliente.vcomprometido-principal   = trim(string(vcomprometido-principal,"->>>>>>>>>>>>>>>>>>9.99")) . 
ttcliente.vsaldoLimite   = trim(string(vsaldoLimite,"->>>>>>>>>>>>>>>>>>9.99")). 
ttcliente.vvlrLimiteEP   = trim(string(vvlrLimiteEP,"->>>>>>>>>>>>>>>>>>9.99")). 
ttcliente.vcomprometidoEP   = trim(string(vcomprometidoEP,"->>>>>>>>>>>>>>>>>>9.99")). 
ttcliente.vcomprometido-principalEP   = trim(string(vcomprometido-principalEP,"->>>>>>>>>>>>>>>>>>9.99")). 
ttcliente.vsaldoLimiteEP   = trim(string(vsaldoLimiteEP,"->>>>>>>>>>>>>>>>>>9.99")). 
ttcliente.vvctoLimite   = vvctoLimite.
/*COMPRAS PRESTACOES*/ 
ttcliente.vDTULTCPA   = vDTULTCPA. 
ttcliente.vQTDECONT   = vQTDECONT. 
ttcliente.vPARCPAG   = vPARCPAG. 
ttcliente.vPARCABERT   = vPARCABERT. 
ttcliente.vDTULTNOV   = vDTULTNOV. 
/*ATRASO PARCELAS*/
ttcliente.qtd-15   = qtd-15. 
ttcliente.perc-15   = trim(string(perc-15,"->>>>>>>>>>>>>>>>>>9.99")). 
ttcliente.vMEDIACONT   = trim(string(vMEDIACONT,"->>>>>>>>>>>>>>>>>>9.99")). 
ttcliente.qtd-45   = qtd-45. 
ttcliente.perc-45   = trim(string(perc-45,"->>>>>>>>>>>>>>>>>>9.99")). 
ttcliente.vMAIORACUM   = trim(string(vMAIORACUM,"->>>>>>>>>>>>>>>>>>9.99")). 
ttcliente.vDTMAIORACUM   = vDTMAIORACUM. 
ttcliente.qtd-46   = qtd-46. 
ttcliente.perc-46   = trim(string(perc-46,"->>>>>>>>>>>>>>>>>>9.99")). 
ttcliente.vPARCMEDIA   = trim(string(vPARCMEDIA,"->>>>>>>>>>>>>>>>>>9.99")). 
ttcliente.vrepar   = trim(string(vrepar,"->>>>>>>>>>>>>>>>>>9.99")). 
ttcliente.vproximo-mes   = trim(string(vproximo-mes,"->>>>>>>>>>>>>>>>>>9.99")). 
ttcliente.vATRASOATUAL   = vATRASOATUAL. 
ttcliente.vDTMAIORATRASO   = vDTMAIORATRASO. 
ttcliente.vVLRPARCVENC   = trim(string(vVLRPARCVENC,"->>>>>>>>>>>>>>>>>>9.99")). 
ttcliente.vcheque_devolvido   = trim(string(vcheque_devolvido,"->>>>>>>>>>>>>>>>>>9.99")). 




hsaida  = temp-table ttcliente:handle.

/*
lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).
put unformatted string(vlcSaida).
*/

def var varquivo as char init "".
def var ppid as char.
if opsys = "UNIX"
then do:
    INPUT THROUGH "echo $PPID".
    DO ON ENDKEY UNDO, LEAVE:
    IMPORT unformatted ppid.
    END.
    INPUT CLOSE.
end.

varquivo  = vtmp + "apits_crediariocliente" + string(today,"999999") + replace(string(time,"HH:MM:SS"),":","") +
          trim(ppid) + ".json".

lokJson = hsaida:WRITE-JSON("FILE", varquivo, TRUE).

if opsys = "UNIX"
then do:
    run crediario/app/1/cat.p (varquivo).
end.    
else do:
    run crediario/app/1/type.p (varquivo).
end.    
