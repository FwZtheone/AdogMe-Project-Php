<?php
require_once ("fonction.php");
require_once ('auth.php');
$bdd = connectionDb();

$id = $_GET['id'];

if($id != 4)
{
    deleteToDb($bdd,$id);

    echo $id;

    echo '<p class="h3 text-success">'.'bien supprimer !'.'</p>';

}
else
{
    echo '<p class="h3 text-danger">'.'tu ne peux pas te supprimer toi même admin !!! '.'</p>';
}


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >
<head>
    <title>Redirection HTML</title>
    <link rel="stylesheet" type="text/css" href="bootstrap.min.css">

</head>
<body>

    <div><a href="index.php" class="btn-primary btn"> Retour à l'accueil </a></div>
    <div style="margin-top:10px;"><a href="redirectionAdmin.php" class="btn btn-primary">Retour Session admin</a></div>

</body>
</html>
