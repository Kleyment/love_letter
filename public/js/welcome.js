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
  //console.log(reason);
  afficherReason(reason);
}


//Appelé si le nom est valide, suprime le bouton
function validerPseudoOk() {
  document.getElementById("name").value=getCookie('pseudo');
  document.getElementById("name").disabled=true;
  document.getElementById("okButton").className="invisible";
  document.getElementById("cancelButton").className="";
  document.getElementById("vueSalon").className="";
}

//Appelé si le nom est invalide, affiche une croix rouge sur le nom
function validerPseudoKo(reason) {
  document.getElementById("name").className="invalid";
  //console.log(reason);
  afficherReason(reason);
}

//Réinitialise les boutons bloqués et la croix rouge
function reset() {
  document.getElementById("name").disabled=false;
  document.getElementById("okButton").disabled=false;
  document.getElementById("name").className="";
  document.getElementById("cancelButton").className="invisible";
  document.getElementById("reason").className="invisible";
  document.getElementById("vueSalon").className="invisible";

  var okButton=document.getElementById("okButton");
  okButton.disabled=false;
  okButton.className="";
}

//Affiche pourquoi le pseudo est invalide (ou pourquoi l'annulation de pseudo est invalide)
function afficherReason(reason) {
  var reasonh2=document.getElementById("reason");
  reasonh2.innerHTML=reason;
  reasonh2.className="";
  window.setTimeout(effacerReason, 3000);
}

function effacerReason() {
  var reasonh2=document.getElementById("reason");
  reasonh2.innerHTML="";
  reasonh2.className="invisible";
}

function afficherSalon() {
  xhr.open("GET", "/parties/", true);
  xhr.send();
}

function afficherSalonOk(response) {
  var listeSalon=document.getElementById("listeSalon");
  for (let i=0;i<response['taille'];i++) {
    var a = document.createElement("a");
    var span = document.createElement("span");
    //TODO
    a.setAttribute("href","");
    span.className="badge float-xs-right";
    span.innerHTML=response[i]['nbjoueurs'];

    listeSalon.appendChild(a);
    listeSalon.appendChild(span);
  }
}

function afficherSalonKo() {
  console.log("Erreur lors de l'affichage des salons")
}

//Méthode automatiquement appelé au chargement de la page - Mise en place de l'AJAX
function main() {
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
                  break;
                //Cas 3 requête chaque seconde des salons
                case 3:
                  afficherSalonOk(response);
              }
              //previousresponse=xhr.responseText;
          }
      }
  };
  setInterval(afficherSalon, 1000);
}
