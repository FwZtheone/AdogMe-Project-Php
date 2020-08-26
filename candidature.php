<?php
session_start();
require_once ('fonction.php');
$bdd = connectionDb();
$rep = null;

?>
<div style="margin-left: 35%;">
<h3 class="text-dark">Présente toi </h3>
<div style="width: 400px;" >
<ul class="list-group list-group-flush">
    <li class="list-group-item">Nom</li>
    <li class="list-group-item">Prenom</li>
    <li class="list-group-item">Age</li>
    <li class="list-group-item">Profession</li>
    <li class="list-group-item">as-tu déjà eu des animaux ?</li>
    <li class="list-group-item">où vis-tu ?</li>
</ul>
</div>
</div>
<?php



if(isset($_SESSION['candidature']) AND $_SESSION['candidature'] =='ok' )
{
    if(isset($_SESSION['loggued']))
    {
        if(isset($_POST['envoyer']))
        {
            if(!empty($_POST['texte']))
            {
            if(ctype_space($_POST['texte']))
            {
                $rep="tu ne peux pas envoyer un texte blanc ";
            }
            else {
                $message = htmlspecialchars($_POST['texte']);
                if(strlen($message) < 255)
                {


                $id_client  = $_SESSION['id'];
                $id_maitre = $_SESSION['candidature_maitre']['id'];


                $id_chien = $_SESSION['id_chien'];


                $requete = $bdd->prepare('INSERT INTO candidature (id_client,id_chien,presentation,id_maitre) VALUES (:id_client,:id_chien,:presentation,:id_maitre)');
                $requete->execute(array('id_client'=>$id_client,
                    'id_chien'=>$id_chien,
                    'presentation'=>$message,
                    'id_maitre'=>$id_maitre));
                $requete->closeCursor();

                 echo '<p class="h3 text-success">'.'Adoption bien réussie ! '.'</p>';





                }
                else $rep= "ton message depasse les 255 caractères ! ";
            }
            }
            else $rep="ton texte est vide ";

        }


    }
}
else {
    header('location: index.php');
}


?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >
<head>
    <title>Modification</title>
    <link rel="stylesheet" type="text/css" href="bootstrap.min.css">
    <style type="text/css">



    </style>
</head>
<body>

<div style="margin-left: 35%;" class="w-25">
    <form action="candidature.php" method="post">
        <textarea  name="texte"
                  rows="5" cols="50"></textarea>
        <small class="text-muted btn-block" style="word-break: normal;">Présente toi, en donnant le maximum d'information sur toi, quelles sont tes intentions avec ce chien, ton status social</small>

        <input type="submit" name="envoyer" value="envoyer" class="btn btn-primary btn-block w-50">

    </form>


</div>
<p class="text-danger h3">  <?php  echo $rep; ?> </p>
<p style="margin-left: 35%;" class="w-25"> <a href="redirection.php" class="btn btn-primary btn-block w-50" >Retour</a></p>
</body>
</html>

