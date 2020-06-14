function validatePhoneNumber() {
    const routes = require('../../public/js/fos_js_routes.json');
    const Routing = require('../../../vendor/friendsofsymfony/jsrouting-bundle/Resources/public/js/router.min.js');

    Routing.setRoutingData(routes);
    Routing.generate('rep_log_list');

    // on recupère les éléments du DOM
    const eltCountry = document.getElementById("call_request_country");
    const eltPhone = document.getElementById("call_request_phoneNumber");
    const eltBtn = document.getElementById("submit");
    const eltCache = document.getElementById("cache");

    // gestion du message
    hideMsgError();

    //gestion du spinner
    showSpinner();

    // verification du cache
    const keyCache = eltCountry.options[eltCountry.selectedIndex].value + eltPhone.value;
    if(keyCache === eltCache.innerText){
        hideSpinner();
        showMsgError();
    }

    // faire l'appel au routeur pour verifier le numero
        // si OK
            // on débloque le bouton
            // on cache le spinner
            // on cache le message
        // si KO
            // on affiche le message
            // on cache le spinner
            // on met à jour le cache

    eltCache.innerText = keyCache;

}

function hideMsgError(){
    const eltMsgError = document.getElementById("msg-error");
    eltMsgError.classList.add("hidden");
}

function showMsgError(){
    const eltMsgError = document.getElementById("msg-error");
    eltMsgError.classList.remove("hidden");
}


function hideSpinner(){
    const eltSpinner = document.getElementById("spinner");
    eltSpinner.classList.add("hidden");
}

function showSpinner(){
    const eltSpinner = document.getElementById("spinner");
    eltSpinner.classList.remove("hidden");

}