<?php
session_start();
require_once ('fonction.php');

require_once ('auth.php');
$bdd = connectionDb();

$rep = null;
$id_image = $_SESSION['id_image'];


if(isset($_POST['valider'])) {
    $requete = $bdd->prepare('SELECT nom,race,presentation,naissance,sexe,url FROM chien WHERE id=:id');
    $requete->execute(array('id' => $id_image));
    $data = $requete->fetch();
    $requete->closeCursor();

    $ancien_nom = $data['nom'];
    $ancien_race = $data['race'];
    $ancien_presentation = $data['presentation'];
    $ancien_naissance = $data['naissance'];
    $ancien_sexe = $data['sexe'];

    $ancien_url = $data['url'];

    $nom = htmlspecialchars($_POST['nom']);
    $race = htmlspecialchars($_POST['race']);
    $presentation = htmlspecialchars($_POST['presentation']);
    $naissance = htmlspecialchars($_POST['date']);
    $sexe = htmlspecialchars($_POST['sexe']);

    //ici je vais stocker la variable $_FILE
    $fichier = $_FILES['image']['name'];
    $extensions = pathinfo($fichier, PATHINFO_EXTENSION);

    $chemin_tmp = $_FILES['image']['tmp_name'];
    $taille = $_FILES['image']['size'];

    define('MB', 1048576);

    $extensAutorise = ['jpg','png'];

    $extensions = strtolower($extensions);
    $ancien_extension = pathinfo($ancien_url,PATHINFO_EXTENSION);
    $ancien_extension = strtolower($ancien_extension);

    if($_FILES['image']['name'] == '')
    {

        $fichier =$ancien_url;
        $extensions = $ancien_extension;
    }



    $condition = 0;


    foreach ($_POST as $key => $element) {
        if ($element == '')
        {
            if ($key == 'nom')
            {
                $nom = $ancien_nom;
            }
            else if ($key == 'race')
            {
                $race = $ancien_race;
            }
            else if ($key == 'presentation')
            {
                $presentation = $ancien_presentation;
            }
            else if ($key == 'date')
            {
                $naissance = $ancien_naissance;
            }
            else if ($key == 'sexe')
            {
                $sexe = $ancien_sexe;
            }



        }
        else if ($element !== '') {
            if ($key == 'nom')
            {
                $nom = $_POST['nom'];
            }
            else if ($key == 'race')
            {
                $race = $_POST['race'];
            }
            else if ($key == 'presentation')
            {
                $presentation = $_POST['presentation'];
            }
            else if ($key == 'date')
            {
                $naissance = $_POST['date'];
            }
            else if ($key == 'sexe')
            {
                $sexe = $_POST['sexe'];
            }

        }
    }



    foreach ($extensAutorise as $key => $element) {
        if ($extensions == $element AND $taille < (5 * MB) AND $element != '.exe' || 'exe') {

            $condition = 1;
            break;
        }

    }



    if (strlen($nom) < 50 AND strlen($race) < 50 AND strlen($presentation) < 255)
    {

        if ($condition == 1)
            {


                if ($naissance >= "2004-01-01" and $naissance <= "2034-12-31") {

                    move_uploaded_file($_FILES['image']['tmp_name'], 'uploads/' . $fichier);


                    $requete = $bdd->prepare('UPDATE chien SET nom=:nom,race=:race,presentation=:presentation,
                 naissance=:naissance,sexe=:sexe,url=:url WHERE id=:id');
                    $requete->execute(array(
                        'nom' => $nom,
                        'presentation' => $presentation,
                        'race' => $race,
                        'naissance' => $naissance,
                        'sexe' => $sexe,
                        'id' => $id_image,
                        'url' => $fichier
                    ));
                    $requete->closeCursor();
                    echo '<p class="h3 text-success">'.'bien modifié ! '.'</p>';



                } else $rep ="mauvaise date choisie ";



            }



        }
        else $rep="mauvaise extensions ! ";



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

<div style="width: 500px; margin-left: 10px;">
    <form action="listeDeChiotsModifier.php" method="post" enctype="multipart/form-data">
        <div class="form-group">
            Nom:  <input type="text" name="nom" class="form-control"/>
        </div>
    <div class="form-group">
        Race:  <input type="text" name="race" class="form-control"/>
    </div>

    <div class="form-group">
        Date de Naissance:  <input type="date" name="date" value="2018-04-19" min="2004-01-01" max="2034-12-31" class="form-control">
    </div>
    <div class="form-group">
        Image:  <input type="file" name="image"  class="form-control-file"/>
    </div>
        <div class="form-group">
            Presentation   <textarea name="presentation" class="form-control" rows="5"></textarea>
        </div>

    <div class="custom-radio">
        <label class="radio-inline"><input type="radio" name="sexe" value="M" checked/>Male</label>
        <label class="radio-inline"><input type="radio" name="sexe" value="F" />Femelle </label>
    </div>

        <input type="submit" value="valider" name="valider">
    </form>
    <div><a href="listeDeChiots.php"> Retour</a></div>
        <?php  echo '<h1 class="h3 text-danger">'.$rep.'</h1>' ?>
</div
</body>
</html>
