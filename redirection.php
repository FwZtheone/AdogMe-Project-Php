<?php
session_start();
require_once ("fonction.php");

$bdd = connectionDb();


$rep = null;

require_once ('auth_user.php');

if(isset($_SESSION) AND !empty($_SESSION)  AND $_SESSION['id'] != null)
{



$tab_affichage = $_SESSION['pseudo'];
$pseudo = $_SESSION['pseudo'];

$requete = $bdd->prepare('SELECT nom,prenom,mdp,email FROM user WHERE pseudo=:pseudo');
$requete->execute(array('pseudo'=>$tab_affichage));
$tab_affichage = $requete->fetch();
$requete->closeCursor();


$id = recupToId($bdd,$pseudo);

//création de la variable de session ID
$_SESSION['id'] = $id['id'];


    if($_SESSION['loggued'] == false )
    {

        if(isset($_POST['valider'])) {

            $nom = htmlspecialchars($_POST['nom']);
            $prenom = htmlspecialchars($_POST['prenom']);
            $email = htmlspecialchars($_POST['email']);
            $mdp_no_crypt = $_POST['mdp'];
            $mdp = sha1($_POST['mdp']);

            $id_user = $_SESSION['id'];





            $bdd = connectionDb();
            $requete = $bdd->prepare('SELECT * FROM user WHERE id=:id');
            $requete->execute(array('id' => $id_user));
            $data = $requete->fetch();
            $requete->closeCursor();


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



                }

            }

            if(strlen($_POST['nom']) <= 50
                AND  strlen($_POST['email']) <= 50 AND  strlen($_POST['prenom']) <= 50  )
            {


                if(strlen($_POST['mdp']) >= 4  || ($mdp == $ancien_mdp))
                {
                    $bdd = connectionDb();
//                    updateToDbWithPseudo($bdd,$id_user,$nom,$prenom,$email,$mdp);
                    $requete = $bdd->prepare('UPDATE user SET nom=:nom,prenom=:prenom,email=:email,mdp=:mdp WHERE id=:id');
                    $requete->execute(array('nom'=>$nom,
                        'prenom'=>$prenom,'email'=>$email,'mdp'=>$mdp,'id'=>$id_user));
                    echo '<p class="h3 text-success">'.'modification réussie(s)'.'</p>';

                }
                else $rep='la longueur du mdp doit être supp à 4 !'.'<br>'.$_POST['mdp'].'<br>'.$ancien_mdp;

            }
            else $rep ="respecte la longueur !! ";



        }


        else if (isset($_POST['quitter'])) {
            session_destroy();
            header('location: index.php');

        }

        else if (isset($_POST['supprimer']))
        {
            $id = $id['id'];
            deleteToDb($bdd,$id);
            header('location: index.php');
        }

        else if (isset($_POST['envoyer']))
        {
            header('location: envoie.php');
        }
        else if(isset($_POST['liste']))
        {
            header('location: listeDeChiots.php');
        }
        else if(isset($_POST['boite_reception']))
        {
            header('location: boite_reception.php');
        }
        else if(isset($_POST['boite_envoie']))
        {
            header('location: boite_envoie');
        }
        else if(isset($_POST['candidature']))
        {
                $_SESSION['voircandidature'] = 'ok';
                header('location: voircandidature.php');
        }



    }


    else{
       header('location: index.php');
    }

}



else
    {
       header('location: index.php');

    }



?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >
<head>
    <title>Redirection HTML</title>
    <link rel="stylesheet" type="text/css" href="bootstrap.min.css">

</head>
<body>
<div style="width:700px; margin-left:30%;" >

    <p class="h3"> Ton compte </p>
    <p class="text-muted"> Tu dois compléter tous les champs pour
    modifier ton compte, les champs doivent être différents des anciens</p>

    <p class="h1 font-weight-light"> Pseudo : <?php echo '<small class="text-primary">'.$_SESSION['pseudo'].'</small>' ?> </p>

        <form action="redirection.php" method="post">
            <div class="form-group">
                <label>Ton nom :  <?php echo '<span class="text-success font-weight-bold">'.$tab_affichage['nom'].'</span>';   ?> </label> <input type="text" name="nom"  class="form-control">

            </div>
            <div class="form-group">
                <label>Ton prenom :  <?php echo '<span class="text-success font-weight-bold">'.$tab_affichage['prenom'].'</span>';   ?> </label><input type="text" name="prenom"  class="form-control">

            </div>
            <div class="form-group">
                <label>Ton email :   <?php echo '<span class="text-success font-weight-bold">'.$tab_affichage['email'].'</span>';   ?>  </label><input type="email" name="email"   class="form-control">

            </div>
            <div class="form-group">
                <label> Ton mot de pass :  <?php echo '<span class="text-success font-weight-bold">'.$_SESSION['mdp'].'</span>';   ?> </label> <input type="password" name="mdp" class="form-control">
                <span id="passwordHelpBlock" class="form-text  text-muted"> Ton mot de passe doit être
                suppèrieur à 4 caractères</span>
            </div>

            <input type="submit" name="valider" value="VALIDER" class="btn btn-primary">

            <input type="submit" name="quitter" value="déconnexion" class="btn btn-primary">
            <input type="submit" name="supprimer" value="SUPPRIMER CE COMPTE" class="btn btn-danger">
            <input type="submit" name="envoyer" value="Envoyer un message à admin " class="btn btn-primary">
            <input type="submit" name="liste" value="Liste de chien" class="btn btn-primary" style="margin-top: 10px;">
            <input type="submit" name="boite_reception" value="message reçu" class="btn-primary btn" style="margin-top: 10px;">
            <input type="submit" name="boite_envoie" value="message envoyé " class="btn-primary btn" style="margin-top: 10px;">
            <input type="submit" name="candidature" value="Candidature" class="btn-primary btn" style="margin-top: 10px;">

        </form>



         <?php $id= $_SESSION['id'] ; ?>






</div>


    <?php echo '<p class=" h4 font-weight-bold text-danger">'.$rep.'</p>'; ?>

</div>
</body>
</html>
