<?php
session_start();

include 'fonction.php';

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
            }else{
                echo "Veuillez remplir tous les champs";
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
</head>
<body>

<?php
 
       
    if(isset($nom) && isset($prenom)){
        echo "<p>Bonjour $prenom $nom</p>";
        echo "<p>Formulaire validé</p>";
    } 
     
       
?>
	
</body>
</html>