<?php
session_start();

include 'fonction.php';

blacklistFORM();
resetCpt();

$captcha = BoolCaptcha();

if (!isset($_SESSION["visite"]) || !$_SESSION["visite"]) {
	header('location: index.php');
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
  
    <form id="formulaire" action="traitement.php" method="post" onsubmit='confirmer()'>
		<!-- vrais input du formulaire mettre des patterns si possible pour bloquer spam d'url-->
		<p>
			<input type="text" name="nom" id="nom" pattern="^[a-zA-Z][a-zA-Z .,'-]*$" placeholder="Nom"/>
		</p>
		<p>
			<input type="text" name="prenom" id="prenom" pattern="^[a-zA-Z][a-zA-Z .,'-]*$" placeholder="Prenom"/>
		</p>
		<!--Pot de miel JS-->
        <p>
			<input type="tel" name="telephone" id="telephone" tabindex="-1" autocomplete="off" placeholder="telephone" value=""/>
		</p>
		<!--Pot de miel CSS-->
        <p>
			<!--<input type="text" name="validation" tabindex="-1" autocomplete="off" id="validation" placeholder="validation"/>-->
            <input type="text" name="validation" tabindex="-1" autocomplete="off" id="validation" placeholder="validation" value=""/>
		</p>
		<?php if ($captcha):
		//afficher captcha si nécessaire -> $captcha = captcha() -> if $captcha == true -> affichage?>
		<p>
			<input type="text" name="captcha" id="captcha" placeholder="Captcha"/>
		</p>
		<?php endif; ?>	
		<p>
			<input type="submit" value="Suivant" name="send" />
		</p>
	</form>
    <script src="js/script.js"></script>
</body>
</html>