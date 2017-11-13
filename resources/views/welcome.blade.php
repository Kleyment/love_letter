<html>
  <head>
    <title>Inscription</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/welcome.css">
    <script src="js/welcome.js"></script>
  </head>
  <?php if ($validerPseudo) {
    echo '<body onload="main(); validerPseudoOk()">';
  } else {
    echo '<body onload="main()">';
  }
  ?>
    <h1>Love Letter Inscription</h1>
    <h2>Choisissez un pseudo</h2>
    <form class="forms" action="#" onsubmit="return validerPseudo(this);">
      <span class="forms" >
        <input id="name" type="text" placeholder="pseudo">
        <input id="okButton" type="submit" value="OK">
      </span>
    </form>
    <form class="forms" action="#" onsubmit="return annulerPseudo(this);">
      <input id="cancelButton" type="submit" value="Annuler">
    </form>
    <h2 id="reason"><h2>
  </body>
</html>
