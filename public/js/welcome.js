var xhr;

//Envoie un requête xhr pour vérifier si le nom est valide
function validerPseudo() {
  reset();
  var name=document.getElementById("name").value;
  var url="/name/"+name;
  xhr.open("GET", url, true);
  xhr.send();
}

function validerPseudoOk() {
  document.getElementById("name").disabled=true;
  document.getElementById("okButton").disabled=true;
}

function validerPseudoKo(reason) {
  document.getElementById("name").className="invalid";
  console.log(reason);
}

function reset() {
  document.getElementById("name").disabled=false;
  document.getElementById("okButton").disabled=false;
  document.getElementById("name").className="";
}

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
                    validerPseudoKo();
                  }
                  break;
                //Cas 2 mise a jour automatique
                case 2:

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
