<?php
session_start();
require_once ('fonction.php');
require_once ('auth_user.php');
$bdd = connectionDb();




$rep = null;
if(isset($_POST['envoyer']))
{
    if(!empty($_POST['texte']))
    {
        if(ctype_space($_POST['texte']))
        {
            $rep='tu ne peux pas envoyer un message blanc';
        }
        else
        {
            //insertion du message ici
            $message = htmlspecialchars($_POST['texte']);
            insertMessage($bdd,$_SESSION['id'],$_SESSION['tableau_maitre']['id'],$message);

            ?> <?php $_SESSION['envoie']='<p class="text-success h3">'.'Message bien envoyé !'.'</p>' ?>

<?php header('location: listeDeChiots.php');
        }
    }
    else $rep ='texte vide';

}



?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >
<head>
    <title>Modification</title>
    <link rel="stylesheet" type="text/css" href="bootstrap.min.css">

</head>
<body>

<div class="form-group w-75">
    <form action="presentation.php" method="post">
        <label for="exampleFormControlTextarea3">Présente toi </label>
        <textarea class="form-control" id="exampleFormControlTextarea3" rows="7" name="texte"></textarea>
        <small class="text-muted">De préfèrence décris toi en donnant ton nom,prenom, ce que tu fais dans la vie etc..</small>
        <input type="submit" name="envoyer" value="envoyer">
    </form>
</div>
<p class="text-danger h3"> <?php echo $rep ?> </p>
</body>
</html>
