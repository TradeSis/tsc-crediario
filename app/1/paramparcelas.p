
def input param operacao as CHAR.
def input param par-rec AS recid. 
DEF INPUT PARAM perc_parcel AS DEC.

DEF INPUT PARAM negcod AS int.
DEF INPUT PARAM placod AS int.
DEF INPUT PARAM titpar AS int.


def buffer bacoplanparcel for acoplanparcel.
find acoplanos where recid(acoplanos) = par-rec no-lock.

if operacao = "incluir"
then do:
    def var vqtdparcel as int.
    def var vi as int.
    find first acoplanparcel of acoplanos no-lock no-error.
    if avail acoplanparcel
    then do:
        vqtdparcel = 0. 
        for each acoplanparcel of acoplanos no-lock.
            vqtdparcel = vqtdparcel + 1.
        end.
        if acoplanos.com_entrada
        then do:
            if acoplanos.qtd_vezes + 1 = vqtdparcel
            then.
            else do:
                for each acoplanparcel of acoplanos.
                    delete acoplanparcel.
                end.    
            end.
        end.
        else do:
            if acoplanos.qtd_vezes = vqtdparcel
            then.
            else do:
                for each acoplanparcel of acoplanos.
                    delete acoplanparcel.
                end.    
            end.

        end.
    end.
    
    def var vtotal as dec format "->>>>9.99".

    find first acoplanparcel of acoplanos no-lock no-error.
    if not avail acoplanparcel
    then do:
        vtotal = 100.
        do vi = 1 to acoplanos.qtd_vezes.
            create acoplanparcel.
            acoplanparcel.negcod = acoplanos.negcod.
            acoplanparcel.placod = acoplanos.placod.
            acoplanparcel.titpar = vi.
            acoplanparcel.perc_parcel = vtotal / acoplanos.qtd_vezes.
        end.
        
        
    end.
        vtotal = 0.
        for each acoplanparcel of acoplanos no-lock.
            vtotal = vtotal + acoplanparcel.perc_parcel.
        end. 

end.

if operacao = "alterar"
then do:
    do on error undo:

        
        find acoplanparcel WHERE acoplanparcel.negcod = negcod AND
                                 acoplanparcel.placod = placod AND
                                 acoplanparcel.titpar = titpar   
                                 no-lock.
        
        for each bacoplanparcel of acoplanos where 
            bacoplanparcel.titpar <= acoplanparcel.titpar and
            bacoplanparcel.titpar > 0. 
            vtotal = vtotal - bacoplanparcel.perc_parcel.
        end. 
        vqtdparcel = 0. 
        for each bacoplanparcel of acoplanos where
                bacoplanparcel.titpar > acoplanparcel.titpar.
            vqtdparcel = vqtdparcel + 1.                
        end.

        if vtotal <= 0 or vqtdparcel = 0
        then do:
            acoplanparcel.perc_parcel = acoplanparcel.perc_parcel + vtotal.
            vtotal = 100.
            for each bacoplanparcel of acoplanos where
                    bacoplanparcel.titpar <= acoplanparcel.titpar and
                    bacoplanparcel.titpar > 0.
                vtotal = vtotal - bacoplanparcel.perc_parcel.
            end. 
            
        end.

        for each bacoplanparcel of acoplanos where
                bacoplanparcel.titpar > acoplanparcel.titpar.
            bacoplanparcel.perc_parcel = vtotal / vqtdparcel.
        end.
    end.    
    
    vtotal = 0.
    for each acoplanparcel of acoplanos where
            acoplanparcel.titpar > 0 no-lock.
        vtotal = vtotal + acoplanparcel.perc_parcel.
    end.        
END.
