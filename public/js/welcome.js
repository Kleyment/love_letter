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
  var name=document.getElementById("name").value;
  var url="/name/"+name;
  xhr.open("GET", url, true);
  xhr.send();
  return false;
}

function annulerPseudo() {
  var name=document.getElementById("name").value;
  var url="/cancelname/";
  xhr.open("GET", url, true);
  xhr.send();
  return false;
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
  document.getElementById("creerPartie").className="badge";
}

//Appelé si le nom est invalide, affiche une croix rouge sur le nom
function validerPseudoKo(reason) {
  document.getElementById("name").className="invalid";
  //console.log(reason);
  afficherReason(reason);
}

//Réinitialise les boutons bloqués et la croix rouge
function reset() {
  console.log("reset()");
  document.getElementById("name").disabled=false;
  document.getElementById("okButton").disabled=false;
  document.getElementById("name").className="";
  document.getElementById("cancelButton").className="invisible";
  document.getElementById("reason").className="invisible";
  document.getElementById("vueSalon").className="invisible";
  document.getElementById("creerPartie").className="invisible";
  document.getElementById("listeNbJ").className="invisible";
  document.getElementById("nbJButton").className="invisible";

  var okButton=document.getElementById("okButton");
  okButton.disabled=false;
  okButton.className="";
}

//Affiche pourquoi le pseudo est invalide (ou pourquoi l'annulation de pseudo est invalide)
function afficherReason(reason) {
  var reasonh2=document.getElementById("reason");
  reasonh2.innerHTML=reason;
  reasonh2.className="";
  setTimeout(effacerReason,1000);
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

//Si les parties 2, 3 et 5 sont dans le cache alors [ 'id2' => 0, 'id3' => 0, 'id5' => 0 ]
//La partie 6 est ajouté [ 'id2' => 0, 'id3' => 0, 'id5' => 0, 'id6' => 1 ]
//Après un add ou un maj les parties sont toujours visible sauf la 5 qui a été supprimé,
//La partie 5 n'a pas eu d'add ou de maj pour la mettre à "1"
//On a alors [ 'id2' => 1, 'id3' => 1, 'id5' => 0, 'id6' => 1 ]
//La partie 5 est donc supprimée
//On remet à 0 les autres parties
var partiesAffichées=[];
function afficherSalonOk(response) {
  var listeSalon=document.getElementById("listeSalon");

  for (let i=0;i<response['taille'];i++) {
    var idpartie=response[i]['idpartie'];

    if (partiesAffichées["id"+idpartie] == 0) {
      majSalon(listeSalon,response[i]);
    } else {
      addSalon(listeSalon,response[i]);
    }
  }

  for (var key in partiesAffichées) {
    if (partiesAffichées[key] == 0) {
      deleteSalon(key);
    } else {
      partiesAffichées[key]=0;
    }
  }
}

function deleteSalon(idpartie) {
  var nameLi="liIdPartie"+idpartie.split("id")[1];
  //console.log(nameLi);
  var li=document.getElementById(nameLi);
  li.parentNode.removeChild(li);
  delete partiesAffichées[idpartie];
}

function majSalon(listeSalon,partie) {

  var idpartie=partie['idpartie'];
  var nbJoueursW=nbJoueursWaiting(partie);

  var aName="aIdPartie"+idpartie;
  var spanName="spanIdPartie"+idpartie;

  document.getElementById(aName).innerHTML="Partie n°"+idpartie;
  document.getElementById(spanName).innerHTML=nbJoueursW+'/'+partie['nbjoueurs'];

  for (let i=0;i<4;i++) {

    var nameSpanJ="spanJ"+(i+1)+"IdPartie"+idpartie;
    var nameJoueur='nomj'+(i+1);

    var spanJ=document.getElementById(nameSpanJ);
    spanJ.innerHTML=partie[nameJoueur];

    //Si le nb de joueurs en attente est plus petit que le joueur en cours alors il est invisible
    if (nbJoueursW < i+1) {
      spanJ.className="badge left invisible";
    } else {
      spanJ.className="badge left";
    }

  }
  partiesAffichées["id"+idpartie]=1;
}


function addSalon(listeSalon,partie) {
  var idpartie=partie['idpartie'];
  var li = document.createElement("li");
  var a = document.createElement("a");
  var span = document.createElement("span");
  var nbJoueursW=nbJoueursWaiting(partie);

  li.setAttribute("id","liIdPartie"+idpartie);
  li.className="list-group-item";

  a.setAttribute("id","aIdPartie"+idpartie);
  a.setAttribute("href","/rejoindrePartie/"+idpartie);
  a.innerHTML="Partie n°"+idpartie;

  span.setAttribute("id","spanIdPartie"+idpartie);
  span.className="badge right";
  span.innerHTML=nbJoueursW+'/'+partie['nbjoueurs'];

  li.appendChild(a);
  li.appendChild(span);

  createSpanPlayers(li,partie,nbJoueursW);
  partiesAffichées["id"+idpartie]=1;
  listeSalon.appendChild(li);
}

function nbJoueursWaiting(partie) {
  if (partie['nomj1'].length > 0) {
    if (partie['nomj2'].length > 0) {
      if (partie['nomj3'].length > 0) {
        if (partie['nomj4'].length > 0) {
          return 4;
        } else {
          return 3;
        }
      } else {
        return 2;
      }
    } else {
      return 1;
    }
  //Impossible normalement
  } else {
    return 0;
  }
}

//nbj 4
//id 0

function createSpanPlayers(liElement,partie,nbJoueursWaiting) {
  var idpartie=partie['idpartie'];
  for (let i=0;i<4;i++) {
    var name='nomj'+(i+1);
    var span = document.createElement("span");
    span.setAttribute("id","spanJ"+(i+1)+"IdPartie"+idpartie);
    span.className="badge left";
    if (nbJoueursWaiting < i+1) {
      span.className=span.className+" invisible";
    }
    span.innerHTML=partie[name];
    liElement.appendChild(span);
  }
}

function afficherSalonKo() {
  console.log("Erreur lors de l'affichage des salons");
}

function afficherNbJ() {
  document.getElementById("listeNbJ").className="";
  document.getElementById("nbJButton").className="";
}

function validerPartie() {
  var choicename="";
  var button="";
  for (let i=2;i<=4;i++) {
    choicename=i+"j";
    if (document.getElementById(choicename).checked) {
      console.log("YOLO");
      window.location.assign("/creerPartie/"+i);
      return false;
    }
  }
  return false;
}

//Méthode automatiquement appelé au chargement de la page - Mise en place de l'AJAX
function main() {
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

  var pseudo=getCookie("pseudo");
  var token=getCookie("token");

  if (pseudo && token && pseudo.length > 0 && token.length == 64) {
    validerPseudo();
  } else {
    console.log("Main reset()");
    reset();
  }
  setInterval(afficherSalon, 1000);
}
