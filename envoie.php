<?php
session_start();
require_once("fonction.php");
require_once ('auth_user.php');

$bdd = connectionDb();
$rep = null;

$id = $_SESSION['id'];


$id_admin = 4;


if(isset($_SESSION['id']))
{
    if(isset($_POST['envoie_message']) AND (!empty($_POST['message'])))
    {




            if(ctype_space($_POST['message']))
            {
                $rep="tu ne peux pas mettre que des espaces blancs ! ";
            }
            else
            {
                $message = htmlspecialchars($_POST['message']);
                insertMessage($bdd,$id,$id_admin,$message);
            }






    }

}


?>



<!DOCTYPE html>
<html>
<head>
    <title>TestPageFun</title>
    <link rel="stylesheet" type="text/css" href="bootstrap.min.css">
</head>
<body>

<div class="form-group shadow-textarea" style="width:600px; margin-left: 10px;">
    <form action="envoie.php" method="post">
        <label for="exampleFormControlTextarea5" class="text-primary font-weight-bold">Envoyer un message  à admin  </label>

        <textarea   class="form-control" id="exampleFormControlTextarea5" rows="3" placeholder="votre message" name="message" style="margin-bottom: 5px;" required=""></textarea>

        <input type="submit" name="envoie_message" value="envoyer" class="btn btn-primary ">
        <a href="redirection.php" class="btn btn-primary">Retour espace membre</a>
    </form>
</div>
<?php  echo '<p class="text-danger font-weight-bold">'.$rep.'<p>' ?>


</body>
</html>
