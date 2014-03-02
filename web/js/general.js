/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

function switchMonCompteOnglet(actif, num) {

    var B = document.getElementById('barreOnglets');
    if (num == 0) {
        B.style.backgroundImage = "url('/images/moncompte/barreOng" + actif + ".png')";
    }else{
        B.style.backgroundImage = "url('/images/moncompte/barreOng" + actif + "gris" + num + ".png')";
    }
}

function isValidEmailAddress(emailAddress) {
    var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
    return pattern.test(emailAddress);
}

