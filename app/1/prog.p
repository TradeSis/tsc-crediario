    
    pause 0.
    disp "CR"
         vvlrLimite  label "Credito" format "->>>>9.99"
       /*  vvctoLimite label "Venc" */        
         vcomprometido   label "Abert"   format "->>>>>9.99"
         vcomprometido-principal   label "Princ" format "->>>>>9.99"

         vsaldoLimite label "Dispo" format "->>>>>9.99"

         with frame f1.
    
    disp skip "EP"
         vvlrLimiteEP  label "Credito" format "->>>>9.99"

         vcomprometidoEP   label "Abert" format "->>>>>9.99"

         vcomprometido-principalEP   label "Princ" format "->>>>>9.99"

         
         vsaldoLimiteEP label "Dispo" format "->>>>>9.99"

         
            with frame f1 side-label width 80
title "C R E D I T O   --   VCTO LIMITE = " + if vvctoLimite = ? then "" else string(vvctoLimite,"99/99/9999") row 5 overlay.                     

    pause 0.
    disp vDTULTCPA       label "Ult. Compra "
         
         vQTDECONT       label "Contratos"
         
         vPARCPAG    label "    Pagas "
         vPARCABERT  label "Abertas"
         skip
        vDTULTNOV       label "Ult. Novacao"
         
         
            with frame f2 side-label width 80
                title "  C O M P R A S              P R E S T A C O E S " 
                row 8 overlay.

def var v-mes as int format "99".
def var v-ano as int format "9999".


    disp 
         qtd-15       label "(ate 15 dias)"  COLON 20
         perc-15       format ">>9.99%" no-label
         vMEDIACONT label "Media por Contrato" format ">,>>9.99"
         qtd-45       label "(16 ate 45 dias)"  COLON 20
         perc-45      format ">>9.99%" no-label
         vMAIORACUM          label "Maior Acum. "
         vDTMAIORACUM       label "Mes/Ano" format "x(7)" 
         qtd-46       label "(acima de 45 dias)" COLON 20
         perc-46 format ">>9.99%" no-label
         vPARCMEDIA    label "Prest. Media"
         vrepar       label "Reparcelamento " colon 20
         vproximo-mes  label "Proximo Mes " colon 48
         
            with frame f4 side-label width 80 row 12
         title "A T R A S O               P A R C E L A S                    ".
         

    disp
        
        "Atraso-> Atual: " space(0)  
         vATRASOATUAL    no-label format ">>>>9"
         space(0)
         " (" space(0)  vDTMAIORATRASO    no-label space(0) ")"
         /*space(0) " Maior: " space (0)
         vMAIORATRASO    no-label format ">>>9 dias" */
        
         vVLRPARCVENC     label "Vencidas" 
         vcheque_devolvido label "Chq Devol"
         
            with frame f5 color white/red side-label no-box width 80.

    
    