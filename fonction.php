<?php

//fonction pour recuperer l'ip
function get_ip()
{
    $ip = $_SERVER["REMOTE_ADDR"];
    return $ip;
}

//permet de noter l'ip du spam dans un txt
function blacklist($compteur)
{
    //Recuperation de l'ip
    $ip = get_ip();

    //compteur de spam
    cptPlus("cpt.txt", $compteur);

    //Ouverture du fichier blacklist en ecriture (a : pointeur fin de fichier) et en lecture
    $fa = fopen("ips.txt", "a");
    $fr = fopen("ips.txt", "r");
    $size = filesize("ips.txt");
    if ($size == 0) {
        $size = 1;
    }
    $filer = fgets($fr, $size);

    //Ecrit ip si pas dans la liste
    if (!preg_match('.^'.preg_quote($ip).'$.m', $filer)) {
        fputs($fa, "$ip\n");
    }
    fclose($fa);
    fclose($fr);
    header('location: aurevoir.php');
}

//verification de la blacklist dans chaque page
function blacklistFORM()
{
    //Recuperation de l'ip
    $ip = get_ip();

    //Ouverture du fichier blacklist
    $fr = fopen("ips.txt", "r");
    $size = filesize("ips.txt");
    if ($size == 0) {
        $size = 1;
    }
    $filer = fgets($fr, $size);

    //Recherche si ip est dans la blacklist
    //si oui -> out
    if (preg_match('.^'.preg_quote($ip).'$.m', $filer)) {
        fclose($fr);
        header('location: aurevoir.php');
    }
    fclose($fr);
}

//renvoie un boolean qui permet de savoir si on a besoin d'un captcha
function needCaptcha($booleanCaptcha, $limites, $limiteSpam, $limiteVisiteur, $compteur)
{
    if (!$booleanCaptcha) {
        $captcha = false;
    } elseif ($booleanCaptcha && !$limites) {
        $captcha = true;
    } else {
        if ($compteur) {
            //ouverture cpt.txt en lecture
            $fc = fopen("cpt.txt", "r");
            $fv = fopen("cptVisiteur.txt", "r");
            $sizefc = filesize("cpt.txt");
            //taille des fichiers
            if ($sizefc == 0) {
                $sizefc = 1;
            }
            $sizefv = filesize("cptVisiteur.txt");
            if ($sizefv == 0) {
                $sizefv = 1;
            }
            //lecture de la valeur
            $valSpam = fgets($fc, $sizefc);
            $valVisiteur = fgets($fv, $sizefv);
            //comparaison avec la limite
            if ($valSpam >= $limiteSpam || $valVisiteur >= $limiteVisiteur) {
                $captcha = true; //si val est >= on affichera
            } else {
                $captcha = false;
            }

            fclose($fc);
            fclose($fv);
        } else {
            $captcha = true;
        }
    }
    return $captcha;
}

//incrémente le compteur de spam
function cptPlus($filename, $compteur)
{
    if ($compteur) {
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
function verifNbForm($limiteTps, $nbMaxForm)
{
    //limite le nombre de formulaire à 3 par jour
    if ($_SESSION["nbForm"] < $nbMaxForm) {
        $_SESSION["nbForm"] += 1;
        unset($_SESSION["erreur"]);
        header('location: reussi.php');
    } else {
        //temps restant
        $tps = ($limiteTps)-(time()-$_SESSION['start']);
        $tpsMin = (int)($tps/60);
        $tpsH = (int)($tpsMin/60);
                                
        //message d'erreur
        if ($tps < 60) {
            echo "<script type=\"text/javascript\">";
            echo "alert('Vous ne pouvez plus envoyer de formulaire pour le moment, Attendez $tps seconde(s)');";
            echo "document.location.href='formulaire.php';";
            echo "</script>";
        } elseif ($tpsH >= 1) {
            echo "<script type=\"text/javascript\">";
            echo "alert('Vous ne pouvez plus envoyer de formulaire pour le moment, Attendez $tpsH heure(s)');";
            echo "document.location.href='formulaire.php';";
            echo "</script>";
        } else {
            echo "<script type=\"text/javascript\">";
            echo "alert('Vous ne pouvez plus envoyer de formulaire pour le moment, Attendez $tpsMin minute(s)');";
            echo "document.location.href='formulaire.php';";
            echo "</script>";
        }
    }
}

function errorCaptcha($tpsPunition, $limiteErreur)
{
    //debut chrono trop d'erreurs
    if (!isset($_SESSION["punition"])) {
        if ($_SESSION["erreur"] > $limiteErreur) {
            $_SESSION["punition"] = time();
        }
    }
    $tps = ($tpsPunition)-(time()-$_SESSION["punition"]);
    $tpsMin = (int)($tps/60);
    $tpsH = (int)($tpsMin/60);

    //message d'erreur
    if ($tps < 60) {
        echo "<script type=\"text/javascript\">";
        echo "alert('Vous avez fait trop d erreurs de captcha, Attendez $tps seconde(s)');";
        echo "document.location.href='formulaire.php';";
        echo "</script>";
    } elseif ($tpsH >= 1) {
        echo "<script type=\"text/javascript\">";
        echo "alert('Vous avez fait trop d erreurs de captcha, Attendez $tpsH heure(s)');";
        echo "document.location.href='formulaire.php';";
        echo "</script>";
    } else {
        echo "<script type=\"text/javascript\">";
        echo "alert('Vous avez fait trop d erreurs de captcha, Attendez $tpsMin minute(s)');";
        echo "document.location.href='formulaire.php';";
        echo "</script>";
    }
}

function verifNbErreur($tpsPunition, $limiteErreur)
{
    $_SESSION["erreur"] += 1;

    if ($_SESSION["erreur"] <= $limiteErreur) {
        echo "<script type=\"text/javascript\">";
        echo "alert('Le résultat du calcul est faux');";
        echo "document.location.href='formulaire.php';";
        echo "</script>";
    } else {
        errorCaptcha($tpsPunition, $limiteErreur);
    }
}

function verifNbErreur2($tpsPunition, $limiteErreur, $limiteTps, $nbMaxForm)
{
    if ($_SESSION["erreur"] > $limiteErreur) {
        errorCaptcha($tpsPunition, $limiteErreur);
    } else {
        verifNbForm($limiteTps, $nbMaxForm);
    }
}
?>