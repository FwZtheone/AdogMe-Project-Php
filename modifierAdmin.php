<?php
session_start();
require_once ("fonction.php");
$rep = null;




require_once ("auth.php");


if(isset($_POST['valider'])) {

    $pseudo = htmlspecialchars($_POST['pseudo']);
    $nom = htmlspecialchars($_POST['nom']);
    $prenom = htmlspecialchars($_POST['prenom']);
    $email = htmlspecialchars($_POST['email']);
    $mdp_no_crypt = $_POST['mdp'];
    $mdp = sha1($_POST['mdp']);

    $id_user = $_SESSION['id_user'];





    $bdd = connectionDb();
    $requete = $bdd->prepare('SELECT * FROM user WHERE id=:id');
    $requete->execute(array('id' => $id_user));
    $data = $requete->fetch();
    $requete->closeCursor();

    $ancien_pseudo = $data['pseudo'];
    $ancien_nom = $data['nom'];
    $ancien_email = $data['email'];
    $ancien_mdp = $data['mdp'];
    $ancien_prenom = $data['prenom'];







foreach ($_POST as $key => $element)
    {

        if($element == '')
        {
            if($key == 'prenom')
                {
//                    $_POST['prenom'] = $ancien_prenom;
                      $prenom = $ancien_prenom;


            }
            else if ($key =='nom')
                {
//                    $_POST['nom'] = $ancien_nom;
                $nom = $ancien_nom;
                }
            else if($key =='email')
                {
//                    $_POST['email'] = $ancien_email;
                $email =$ancien_email;
                }
            else if($key=='mdp')
                {
//                    $_POST['mdp'] = $ancien_mdp;
                    $mdp = $ancien_mdp;
                }
            else if($key == 'pseudo')
                {
//                    $_POST['pseudo'] = $ancien_pseudo;
                      $pseudo = $ancien_pseudo;
                }

        }

        else if( $element != '')
        {
            if($key == 'nom')
            {
                 $nom=$_POST['nom'];
            }
            else if($key =='prenom')
            {
                $prenom = $_POST['prenom'];
            }
            else if($key =='email')
            {
                 $email = $_POST['email'];
            }
            else if($key =='mdp')
            {
               $mdp = sha1($_POST['mdp']);

            }
            else if($key =='pseudo')
            {
               $pseudo  = $_POST['pseudo'] ;
            }


        }

    }

if(strlen($_POST['nom']) <= 50 AND  strlen($_POST['pseudo']) <= 50
    AND  strlen($_POST['email']) <= 50 AND  strlen($_POST['prenom']) <= 50  )
{


        if(strlen($_POST['mdp']) >= 4  || ($mdp == $ancien_mdp))
        {
            $bdd = connectionDb();
            updateToDbWithPseudo($bdd,$id_user,$nom,$prenom,$email,$mdp,$pseudo);
            var_dump($_POST);

        }
        else $rep='la longueur du mdp doit être supp à 4 !'.'<br>'.$_POST['mdp'].'<br>'.$ancien_mdp;

}
else $rep ="respecte la longueur !! ";











}




?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >
<head>
    <title>Modification</title>
    <link rel="stylesheet" type="text/css" href="bootstrap.min.css">

</head>
<body>
<div style="width:600px; margin-left:35%;  margin-top: 10%;" >



    <form action="modifierAdmin.php" method="post" >
        <div class="form-group">
             Pseudo  : <input type="text" name="pseudo" class="form-control">
        </div>
        <div class="form-group">
            Nom  : <input type="text"  name="nom"  class="form-control">

        </div>
        <div class="form-group">
            Prenom : <input type="text" name="prenom" class="form-control">

        </div>
        <div class="form-group">
            Email : <input type="email" name="email" class="form-control" >

        </div>
        <div class="form-group">
            Mdp : <input type="password" name="mdp" class="form-control">

        </div>
        <input type="submit" value="valider" name="valider" class="btn btn-primary">

    </form>

    <p class="h3 text-danger"> <?php  echo $rep ; ?></p>
    <div> <a href="redirectionAdmin.php" class="btn btn-primary"> Retour </a></div>

</div>



</body>
</html>
