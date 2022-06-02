<?php
include 'init.php';
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

		<div id="form">
			<input type="text" name="nom" id="nom" pattern="^([ \u00c0-\u01ffa-zA-Z'\-])+$" placeholder="Nom" value="<?php 
			if(isset($_SESSION['inscription']['nom'])) { echo $_SESSION['inscription']['nom']; } ?>" required/>
			<span>Veuillez entrer uniquement des lettres</span>
		</div>
		<div id="form">
			<input type="text" name="prenom" id="prenom" pattern="^([ \u00c0-\u01ffa-zA-Z'\-])+$" placeholder="Prenom" value="<?php 
			if(isset($_SESSION['inscription']['prenom'])) { echo $_SESSION['inscription']['prenom']; } ?>"required/>
			<span>Veuillez entrer uniquement des lettres</span>
		</div>

		<?php if ($pmJS) {
        echo '<div>';
		echo '<input type="text" name="'.$nomPmJS.'" id="'.$nomPmJS.'" tabindex="-1" autocomplete="off" placeholder="'.$nomPmJS.'" value=""/>';
		echo '</div>';
		echo '<script type="text/javascript">';
        echo 'document.getElementById("'.$nomPmJS.'").style.display = "none";';
        echo '</script>';
		}?>

		<?php if ($pmCSS){
        echo '<div>';
		echo '<input type="text" name="'.$nomPmCSS.'" id="pm" tabindex="-1" autocomplete="off" placeholder="'.$nomPmCSS.'" value=""/>';
		echo '</div>';
		}?>

		<?php if ($needCaptcha):
        //afficher captcha si nécessaire
		$aff = captcha($operateur2);?>
		<div id="captcha">
			<label for="captcha">Combien font <?php foreach($aff as $a) { afficher($a); } ?>?</label></br>
			<input type="text" name="captcha" id="captcha" placeholder="résultat" required/>
		</div>
		<?php endif; ?>	

		<div id="form">
			<input type="submit" value="Suivant" name="send"/>
		</div>
	</form>
</body>
<script src="js/script.js"></script>
</html>