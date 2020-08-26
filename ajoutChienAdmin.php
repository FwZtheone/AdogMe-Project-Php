<?php

session_start();
require_once ("fonction.php");
require_once ('auth.php');
$bdd = connectionDb();

echo '<h1 class="h3 text-success">'.'Session : ADMIN'.'</h1>';

$_SESSION['guest'] = false;

$id_user = $_SESSION['id'];
$rep =null;

if(isset($_POST['valider']))
{

    if(!empty($_POST['nom']) AND !empty($_POST['race']) AND !empty($_POST['date'])
        AND !empty($_POST['presentation']))
    {
        if(strlen($_POST['nom']) < 50)
        {




            $controle_extensions_photos = ['jpg','png'];
            $fichier = $_FILES['photo']['name'];


            $extensions = pathinfo($fichier,PATHINFO_EXTENSION);
            $taille = $_FILES['photo']['size'];

            $extensions  = strtolower($extensions);
            $condition = 0;

            $nom = htmlspecialchars($_POST['nom']);
            $race = htmlspecialchars($_POST['race']);
            $naissance = htmlspecialchars($_POST['date']);
            $presentation = htmlspecialchars($_POST['presentation']);
            $sexe = $_POST['optradio'];

            $photobase = 'photo';
            $a=uniqid();
            $nomDeLaPhoto =$photobase.$a;

            define('MB', 1048576);

            foreach ($controle_extensions_photos as $key =>$element)
            {
                if($extensions == $element AND $taille < 5*MB AND $element!= '.exe' || 'exe')
                {

                    $condition = 1;
                    break;
                }



            }

            if($condition == 1)
            {




                if($naissance  >= "2004-01-01" and  $naissance <= "2034-12-31")
                {

                    move_uploaded_file($_FILES['photo']['tmp_name'],'uploads/'.$nomDeLaPhoto.'.'.$extensions);




                    $nomDeLaPhotoEntiere = $nomDeLaPhoto.'.'.$extensions;

                    $requete = $bdd->prepare('INSERT INTO chien (nom,naissance,race,id_user,url,sexe,presentation) 
                        VALUES(:nom,:naissance,:race,:id_user,:url,:sexe,:presentation)');
                    $requete->execute(array('nom' => $nom , 'naissance' => $naissance ,'race' =>$race ,'id_user'=>$id_user,'url' => $nomDeLaPhotoEntiere,'sexe'=>$sexe,'presentation'=>$presentation));
                    $requete->closeCursor();


                    ?>
                    <p class="h3 text-success">Téléchargement de la photo réussi!</p>

                    <?php




                }
                else $rep =" error ! tu as entré une dâte qui est  < 2004-01-01 et >  2034-12-31";

            }
            else $rep ="mauvaise extensions ! ";

        }
        else $rep = "champ au dessus de 50 ! ";


    }
    else $rep="erreur";
}

else if (isset($_POST['retour']))
{
   header('location: redirectionAdmin.php');

}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >
<head>
    <title>Modification</title>
    <link rel="stylesheet" type="text/css" href="bootstrap.min.css">
    <style>
        .contenaire
        {
            width: 400px;
            height: 400px;
            margin-left: 10px;
            margin-top: 10px;
        }
    </style>
</head>
<body>

<div class="contenaire">
    <form action="ajoutChienAdmin.php" method="post"  enctype="multipart/form-data">
        <div class="form-group">
            Nom : <input type="text" name="nom" class="form-control">
        </div>
        <div class="form-group">
            Race :<input type="text" name="race" class="form-control">
        </div>
        <div class="form-group">
            Date de naissance : <input type="date" name="date" class="form-control"  min="2004-01-01" max="2034-12-31" value="2018-04-19">
        </div>
        <div class="form-group">
            Présentation : <textarea  rows="5" name="presentation" class="form-control"></textarea>
        </div>
        <div class="form-group">
            <label><input type="file" name="photo" class="form-control-file"></label>
        </div>
        <div class="radio">
            <label class="radio-inline"><input type="radio" name="optradio" value="M" checked>Male</label>
            <label class="radio-inline"><input type="radio" name="optradio" value="F">Femelle</label>
        </div>

        <input type="submit" name="valider" value="valider" class="btn-primary btn">
        <input type="submit" name="retour" value="retour" class="btn btn-primary">
    </form>
    <?php  echo '<h1 class="h3 text-danger">'.$rep.'</h1>' ; ?>
</div>




</body>
</html>

