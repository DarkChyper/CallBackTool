/**
 * Vérifie si le champ phone number est renseigné,
 * execute alors validatePhoneNumber(path)
 * @param path
 */
function checkFieldPhoneNumber(path) {
    if ('' !== document.getElementById("call_request_phoneNumber").value.trim()) {
        checkPhoneNumberWithAPI(path);
    }
}

function checkPhoneNumberWithAPI(path) {
    // desactivation du bouton
    disableBtn();

    // gestion des messages
    hideMsgError();
    hideMsgErrorTech()

    //gestion du spinner
    showSpinner();

    // on recupère les éléments du DOM
    const eltCountry = document.getElementById("call_request_country");
    const eltPhone = document.getElementById("call_request_phoneNumber");



    // verification du cache
    if (checkCache(eltCountry.options[eltCountry.selectedIndex].value + eltPhone.value)) {
        hideSpinner();
        showMsgError();
        return;
    }

    // On pass les données en JSON
    const data = JSON.stringify({
        "country": eltCountry.options[eltCountry.selectedIndex].value,
        "phoneNumber": eltPhone.value
    });

    // Appel AJAX
    apiPost(path, true, data, function(reponse, data) {
        // modification du cache
        const dataParsed = JSON.parse(data);
        modifyCache(dataParsed.country + dataParsed.phoneNumber);

        console.debug("Reponse: " + reponse + " || data: " + data);
        // retrait du spinner
        hideSpinner();

        // gestion de la reponse
        if (JSON.parse(reponse).result) {
            enableBtn();
        } else {
            showMsgError();
        }
    }, function (msgErreur) {
        // en cas de problème technique
        const eltMsgErrTech = document.getElementById('msg-error-technique');
        let message = eltMsgErrTech.innerText;
        eltMsgErrTech.innerText = message + " : " + msgErreur;
        hideSpinner();
        showMsgErrorTech();
    });

}

function hideMsgError() {
    const eltMsgError = document.getElementById("msg-error");
    eltMsgError.classList.add("hidden");
}

function showMsgError() {
    const eltMsgError = document.getElementById("msg-error");
    eltMsgError.classList.remove("hidden");
}

function hideMsgErrorTech() {
    const eltMsgError = document.getElementById("msg-error-technique");
    eltMsgError.classList.add("hidden");
}

function showMsgErrorTech() {
    const eltMsgError = document.getElementById("msg-error-technique");
    eltMsgError.classList.remove("hidden");
}

function hideSpinner() {
    const eltSpinner = document.getElementById("spinner");
    eltSpinner.classList.add("hidden");
}

function showSpinner() {
    const eltSpinner = document.getElementById("spinner");
    eltSpinner.classList.remove("hidden");
}

function enableBtn(){
    const eltBtn = document.getElementById("submit");
    eltBtn.removeAttribute("disabled");
}

function disableBtn(){
    const eltBtn = document.getElementById("submit");
    eltBtn.setAttribute("disabled", "disabled");
}

/**
 * Return true if the key is in cache
 * false otherwise
 *
 * @param keyCache
 * @returns {boolean}
 */
function checkCache(keyCache) {
    let retour = false;
    const eltCache = document.getElementById("cache");
    if (keyCache === eltCache.innerText) {
        retour = true;
    }
    return retour;
}

/**
 * Set the keyCache in cache
 *
 * @param keyCache
 */
function modifyCache(keyCache) {
    const eltCache = document.getElementById("cache");
    eltCache.innerText = keyCache;
}

/**
 * generic function to call an API with POST method
 *
 * @param url
 * @param async true | false
 * @param data JSON DATA
 * @param callback function to execute if response 200
 * @param callbackerror function to execute otherwise
 */
function apiPost(url, async, data, callback, callbackerror) {
    let req = new XMLHttpRequest();
    req.open("POST", url, async);
    req.addEventListener("load", function () {
        if (req.status >= 200 && req.status < 400) {
            callback(req.responseText, data);
        } else {
            console.error(req.status + " " + req.statusText + " " + url);
            callbackerror(req.status + " " + req.statusText + " " + url);
        }
    });
    req.addEventListener("error", function () {
        console.error("Erreur réseau avec l'URL " + url);
        callbackerror("Erreur réseau avec l'URL " + url);
    });
    req.send(data);
}