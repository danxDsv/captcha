<?php

//fonction pour recuperer l'ip
function get_ip()
{
    $ip = $_SERVER["REMOTE_ADDR"];
    return $ip;
}

//permet de noter l'ip du spam dans un txt
function blacklist()
{
    //Recuperation de l'ip
    $ip = get_ip();

    //compteur de spam
    cptPlus("cpt.txt");

    //Ouverture du fichier blacklist en ecriture (a : pointeur fin de fichier) et en lecture
    $fa = fopen("ips.txt", "a");
    $fr = fopen("ips.txt", "r");
    $filer = fgets($fr, 4096);

    //Recherche si ip est dans la blacklist
    //si oui -> out
    if (preg_match('.^'.preg_quote($ip).'$.m', $filer)) {
        fclose($fa);
        fclose($fr);
        header('location: aurevoir.php');
    } else {
        //si pas trouvée -> écriture puis out
        fputs($fa, "$ip\n");
        fclose($fa);
        fclose($fr);
        header('location: aurevoir.php');
    }
}

//verification de la blacklist dans chaque page
function blacklistFORM()
{
    //Recuperation de l'ip
    $ip = get_ip();

    //Ouverture du fichier blacklist
    $fr = fopen("ips.txt", "r");
    $filer = fgets($fr, 4096);

    //Recherche si ip est dans la blacklist
    //si oui -> out
    if (preg_match('.^'.preg_quote($ip).'$.m', $filer)) {
        fclose($fr);
        header('location: aurevoir.php');
    }
}

//renvoie un boolean qui permet de savoir si on a besoin d'un captcha
function needCaptcha()
{
    //variables initiales
    $limiteSpam = 0;        //limite de spam
    $limiteVisiteur = 0;   //limite de visiteur
    $captcha = false;       //booleen qui permet de gérer l'affichage

    //ouverture cpt.txt en lecture
    $fc = fopen("cpt.txt", "r");
    $fv = fopen("cptVisiteur.txt", "r");
    //lecture de la valeur
    $valSpam = fgets($fc, 4096);
    $valVisiteur = fgets($fv, 4096);
    //comparaison avec la limite
    if ($valSpam >= $limiteSpam || $valVisiteur >= $limiteVisiteur) {
        $captcha = true; //si val est >= on affichera
    }

    fclose($fc);
    fclose($fv);
    return $captcha;
}

//incrémente le compteur de spam
function cptPlus($filename)
{

    //récuperation de la valeur du fichier
    $cpt = file_get_contents($filename);
    $cpt = trim($cpt);
    //incrémentation
    $cpt = $cpt + 1;

    //ouverture + écriture + fermeture
    $fcpt = fopen($filename, "w+");
    fputs($fcpt, "$cpt");
    fclose($fcpt);
}

//réinitialise le compteur si besoin
function resetCpt()
{
    //date actuelle jour-mois-année
    $dateavt = date("d-m-Y", time());
    $date = new DateTime($dateavt);

    //récupération de la date des compteurs
    $dateCptA = file_get_contents("date.txt");
    $dateCptA = trim($dateCptA);
    $dateCpt = new DateTime($dateCptA);

    //si date > 1 semaine -> cpt = 0
    $interval = $dateCpt->diff($date);

    if ($interval->days >= 7) {
        //ouverture + écriture + fermeture
        $fcpt = fopen("cpt.txt", "w+");
        fputs($fcpt, "0");
        fclose($fcpt);
        //ouverture + écriture + fermeture
        $fcptV = fopen("cptVisiteur.txt", "w+");
        fputs($fcptV, "0");
        fclose($fcptV);
        //ouverture + écriture + fermeture
        $fdate = fopen("date.txt", "w+");
        fputs($fdate, $dateavt);
        fclose($fdate);
    }
}

//Verifie le nombre de formulaires envoyés
function verifNbForm($limiteTps)
{
    $_SESSION["nbForm"] += 1;
    //limite le nombre de formulaire à 3 par jour
    if ($_SESSION["nbForm"] > 3) {
        //temps restant
        $tps = ($limiteTps)-(time()-$_SESSION['start']);
        $tpsMin = (int)($tps/60);
        $tpsH = (int)($tpsMin/60);
                                
        //message d'erreur
        if ($tps < 60) {
            echo "<script type=\"text/javascript\">";
            echo "alert('Vous ne pouvez plus envoyer de formulaire pour le moment, Attendez '+'$tps'+' seconde(s)');";
            echo "document.location.href='formulaire.php';";
            echo "</script>";
        } elseif ($tpsH >= 1) {
            echo "<script type=\"text/javascript\">";
            echo "alert('Vous ne pouvez plus envoyer de formulaire pour le moment, Attendez '+'$tpsH'+' heure(s)');";
            echo "document.location.href='formulaire.php';";
            echo "</script>";
        } else {
            echo "<script type=\"text/javascript\">";
            echo "alert('Vous ne pouvez plus envoyer de formulaire pour le moment, Attendez '+'$tpsMin'+' minute(s)');";
            echo "document.location.href='formulaire.php';";
            echo "</script>";
        }
    }
    header('location: réussi.php');
}

?>