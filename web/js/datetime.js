function returnChrono(param) {

    var dateMatch = new Date();
    dateMatch.setTime(param);
    dateMatchSecondes = parseInt(dateMatch.getTime()/1000);

    //dateMatchSecondes = dateMatchSecondes - 3600;
	
    var dateNow = new Date();
    dateNowSecondes = parseInt(dateNow.getTime()/1000);
	
    diffSecondes = dateMatchSecondes - dateNowSecondes;

    if ( dateMatchSecondes <= dateNowSecondes ) {
        return('En cours');
    }
	
    if ( diffSecondes > 86400 )
        return(parseInt(diffSecondes/86400) + ' jour(s)');
	
    heure = parseInt(diffSecondes / (60*60));
    resteSecondes = diffSecondes % (60*60);
    minute = parseInt(resteSecondes / 60);
    resteSecondes = resteSecondes % 60;
	
    return(heure+'h'+minute+'m'+resteSecondes);
}

function returnChronoPART1(param, status) {

    var tab = new Array;

    tab[0]='';
    tab[1]='';
    tab[2]='';
    tab[3]='';

    var dateMatch = new Date();
    dateMatch.setTime(param);
    dateMatchSecondes = parseInt(dateMatch.getTime()/1000);
    
    var dateNow = new Date();
    dateNowSecondes = parseInt(dateNow.getTime()/1000);

    diffSecondes = dateMatchSecondes-dateNowSecondes;
    
    if ( diffSecondes > 0 && status != -1) {

        if ( diffSecondes > 86400 ) {
            nbJour = parseInt(diffSecondes/86400);
            if ( nbJour < 10 )
                tab[0] = '0' + nbJour;
            else tab[0] = nbJour;
        }
        else {
            tab[0] = '00';
        }

        nbJour = parseInt(diffSecondes/86400);
        diffSecondes = diffSecondes-(nbJour*86400);
        heure = parseInt(diffSecondes/(60*60));
        resteSecondes = diffSecondes % (60*60);
        minute = parseInt(resteSecondes / 60);
        resteSecondes = resteSecondes % 60;

        if ( heure > 0 && heure < 10 )
            heure = '0' + heure;

        if ( minute > 0 && minute < 10 )
            minute = '0' + minute;

        if ( resteSecondes > 0 && resteSecondes < 10 ) {
            resteSecondes = '0' + resteSecondes;
        }
        //display chrono
        tab[1] = heure;
        tab[2] = minute;
        tab[3] = resteSecondes;
        tab["opened"] = '0';
        tab["closed"] = '0';
        tab["settled"] = '0';
        tab["started"] = '0';
        tab["ongoing"] = '0';
        tab["cancelled"] = '0';
        tab["chrono"] = '1';
    }
    else {
        if(status == 1) {
            // display kup opened
            tab[0]='Op';
            tab[1]='en';
            tab[2]='ed';
            tab[3]='';
            tab["started"] = '0';
            tab["closed"] = '0';
            tab["ongoing"] = '0';
            tab["chrono"] = '0';
            tab["opened"] = '1';
            tab["settled"] = '0';
            tab["cancelled"] = '0';

        } else if(status == 2) {
            // display kup started
        	tab[0]='On';
            tab[1]='go';
            tab[2]='in';
            tab[3]='g';
            tab["opened"] = '0';
            tab["closed"] = '0';
            tab["ongoing"] = '1';
            tab["chrono"] = '0';
            tab["started"] = '0';
            tab["settled"] = '0';
            tab["cancelled"] = '0';

        } else if(status == 3) {
            //display kup in progress
        	tab[0]='Cl';
            tab[1]='os';
            tab[2]='ed';
            tab[3]='';
            tab["opened"] = '0';
            tab["closed"] = '1';
            tab["settled"] = '0';
            tab["started"] = '0';
            tab["chrono"] = '0';
            tab["ongoing"] = '0';
            tab["cancelled"] = '0';
            
        } else if(status == 4 || status == 5) {
            //display kup settled and paided out
            tab[0]='Se';
            tab[1]='tt';
            tab[2]='le';
            tab[3]='d';
            tab["started"] = '0';
            tab["opened"] = '0';
            tab["ongoing"] = '0';
            tab["chrono"] = '0';
            tab["closed"] = '0';
            tab["settled"] = '1';
            tab["cancelled"] = '0';
        } else if(status == -1) {
            //display kup cancelled 
            tab[0]='Cl';
            tab[1]='os';
            tab[2]='ed';
            tab[3]='';
            tab["settled"] = '0';
            tab["started"] = '0';
            tab["opened"] = '0';
            tab["ongoing"] = '0';
            tab["chrono"] = '0';
            tab["closed"] = '0';
            tab["settled"] = '0';
            tab["cancelled"] = '1';
        }
    }
    
    return(tab);

}
