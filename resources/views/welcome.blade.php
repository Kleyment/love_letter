<html>
  <head>
    <title>Inscription</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="/css/welcome.css">
    <script src="/js/welcome.js"></script>
  </head>
  <body onload="main()">
    <h1>Love Letter Inscription</h1>
    <h2>Choisissez un pseudo</h2>
    <form class="forms" onsubmit="return validerPseudo();">
      <span class="forms">
        <input id="name" type="text" placeholder="pseudo">
        <input id="okButton" type="submit" value="OK">
      </span>
    </form>
    <form class="forms" onsubmit="return annulerPseudo();">
      <input id="cancelButton" class="invisible" type="submit" value="Annuler">
    </form>
    <h2 id="reason" class="invisible"></h2>
    <br>
    <div id="vueSalon" class="invisible">
      <div class="page-header">
        <h2>Liste des parties</h2>
      </div>
      <ul id="listeSalon" class="list-group">
        <!--<li class="list-group-item">
          <a href="salons/1"> n° 1 </a>
          <span class="badge float-xs-right">1 / 2 </span>
        </li>-->
      </ul>
    </div>
    <div id="creerPartie" onclick="afficherNbJ();" class="invisible">+</div>
    <ul id="listeNbJ" class="invisible" tabindex='0'>
      <li>
        <input id='2j' type='radio' name='item' checked='true' />
        <label for='2j'>2 joueurs</label>
      </li>
      <li>
        <input id='3j' type='radio' name='item' />
        <label for='3j'>3 joueurs</label>
      </li>
      <li>
        <input id='4j' type='radio' name='item' />
        <label for='4j'>4 joueurs</label>
      </li>
    </ul>
    <form onsubmit="return validerPartie();">
      <input id="nbJButton" class="invisible" type="submit" value="Confirmer">
    </form>
  </body>
</html>
