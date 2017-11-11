//Variable nécessaire pour l'AJAX
var xhr;

//Fonction trouvé sur w3school permettant de retrouver un cookie
function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

//Envoie un requête xhr pour vérifier si le nom est valide
function validerPseudo() {
  reset();
  var name=document.getElementById("name").value;
  var url="/name/"+name;
  xhr.open("GET", url, true);
  xhr.send();
}

function annulerPseudo() {
  var name=document.getElementById("name").value;
  var url="/cancelname/";
  xhr.open("GET", url, true);
  xhr.send();
}

function annulerPseudoOk() {
  reset();
}

function annulerPseudoKo(reason) {
  console.log(reason);
}

//Appelé si le nom est valide, suprime le bouton
function validerPseudoOk() {
  document.getElementById("name").value=getCookie('pseudo');
  document.getElementById("name").disabled=true;
  document.getElementById("okButton").className="invisible";
  document.getElementById("cancelButton").className="";
}

//Appelé si le nom est invalide, affiche une croix rouge sur le nom
function validerPseudoKo(reason) {
  document.getElementById("name").className="invalid";
  console.log(reason);
}

//Réinitialise les boutons bloqués et la croix rouge
function reset() {
  document.getElementById("name").disabled=false;
  document.getElementById("okButton").disabled=false;
  document.getElementById("name").className="";
  document.getElementById("cancelButton").className="invisible";

  var okButton=document.getElementById("okButton");
  okButton.disabled=false;
  okButton.className="";
}

//Méthode automatiquement appelé au chargement de la page - Mise en place de l'AJAX
function main(pseudo) {
  if (pseudo) {
    alert(pseudo);
  }
  reset();
  xhr = new window.XMLHttpRequest();
  xhr.onreadystatechange = function () {
      if (xhr.readyState === 4) {
          if (xhr.status === 200) {
              var response=JSON.parse(xhr.responseText);
              switch (response["type"]) {
                //Cas 1 verification du pseudo
                case 1:
                  if (response["pseudoOk"]) {
                    validerPseudoOk();
                  } else {
                    validerPseudoKo(response["reason"]);
                  }
                  break;
                //Cas 2 annulation du pseudo
                case 2:
                  if (response["annulerPseudoOk"]) {
                    annulerPseudoOk();
                  } else {
                    annulerPseudoKo(response["reason"]);
                  }
              }
              //previousresponse=xhr.responseText;
          }
      }
  };
}

function update() {
    xhr.open("GET", "/updateplayer/", true);
    xhr.send();
    setTimeout(update, 1000);
}
