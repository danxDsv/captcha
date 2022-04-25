<?php
session_start();

include 'fonction.php';
include 'captcha.php';

blacklistFORM();
resetCpt();

$Boolcaptcha = BoolCaptcha();

//variable session de visite
if (!isset($_SESSION["visite"])) {
    $_SESSION["visite"] = false;
}
//compteur de visite
if (!$_SESSION["visite"]) {
    $_SESSION["visite"] = true;
    cptPlus("cptVisiteur.txt");
}
?>

<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Formulaire</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  
    <form id="formulaire" action="traitement.php" method="post">
		<!-- vrais input du formulaire mettre des patterns si possible pour bloquer spam d'url-->
		<div id="form">
			<input type="text" name="nom" id="nom" pattern="^([ \u00c0-\u01ffa-zA-Z'\-])+$" placeholder="Nom" required/>
			<span>Veuillez entrer uniquement des lettres</span>
		</div>
		<div id="form">
			<input type="text" name="prenom" id="prenom" pattern="^([ \u00c0-\u01ffa-zA-Z'\-])+$" placeholder="Prenom" required/>
			<span>Veuillez entrer uniquement des lettres</span>
		</div>
		<!--Pot de miel JS-->
        <div>
			<input type="tel" name="telephone" id="telephone" tabindex="-1" autocomplete="off" placeholder="telephone" value=""/>
		</div>
		<!--Pot de miel CSS-->
        <div>
			<!--<input type="text" name="validation" tabindex="-1" autocomplete="off" id="validation" placeholder="validation"/>-->
            <input type="text" name="validation" tabindex="-1" autocomplete="off" id="validation" placeholder="validation" value=""/>
		</div>
		<?php if ($Boolcaptcha):
		//afficher captcha si nécessaire -> $captcha = Boolcaptcha() -> if $captcha == true -> include captcha.php?>
		<div id="form">
			<label for="captcha">Combien font <?php echo captcha(); ?> ?</label></br>
			<input type="text" name="captcha" id="captcha" placeholder="résultat" required/>
		</div>
		<?php endif; ?>	
		<p>
			<input type="submit" value="Suivant" name="send"/>
		</p>
	</form>
    <script src="js/script.js"></script>
</body>
</html>