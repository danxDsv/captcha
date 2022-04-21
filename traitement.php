<?php
session_start();

include 'fonction.php';

blacklistFORM();
resetCpt();
$Boolcaptcha = BoolCaptcha();

if (!isset($_SESSION["visite"]) || !$_SESSION["visite"]) {
	header('location: index.php');
}

//verification submit
if(isset($_POST["send"])){

    //verification pot de miel CSS vide
    if(isset($_POST["validation"]) && empty($_POST["validation"])){

        //verification pot de miel JS vide
        if (isset($_POST["telephone"]) && empty($_POST["telephone"])) {

            //verification que les champs sont remplis
            if(
                isset($_POST["nom"]) && !empty($_POST["nom"]) &&
                isset($_POST["prenom"]) && !empty($_POST["prenom"])
            ){
                $nom = strip_tags($_POST["nom"]);
                $prenom = strip_tags($_POST["prenom"]);
            }/*else{
                echo "<script type=\"text/javascript\">";
                echo "alert('Complétez tous les champs');";
                echo "window.history.back();";
                echo "</script>";
            }*/ 
            //si le captcha est présent
            if ($Boolcaptcha) {
                //si le captcha a été envoyé et qu'il n'est pas vide
                if (isset($_POST["captcha"]) && !empty($_POST["captcha"])) {
                    //si le résultat en chiffre et en lettre sont faux
                    if ( ($_POST["captcha"] != $_SESSION["captcha"]) && ($_POST["captcha"] != $_SESSION["captchaLettre"]) ) {
                        echo "<script type=\"text/javascript\">";
                        echo "alert('Le résultat du calcul est faux');";
                        echo "window.history.back();";
                        echo "</script>";
                    }
                }
            }
        }else{
            blacklist(); 
        }
    }else {
        blacklist();    
    }
}else{

    header('location: formulaire.php');

}

?>

<!doctype html>
	
<html lang="fr">
<head>
	<meta charset="utf-8" />
	<title></title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php
 
       
    if(isset($nom) && isset($prenom)){
        echo "<p>Bonjour $prenom $nom</p>";
        echo "<p>Formulaire validé</p>";
    } 
     
       
?>
    <script src="js/script.js"></script>
</body>
</html>
