<?php


session_start();
$rep = null;
require_once ("fonction.php");
$_SESSION['guest'] = false;

if(isset($_POST['connexion']))
{
        $bdd = connectionDb();


    if(!empty($_POST['email']))
    {

        if(!empty($_POST['mdp']))
        {
//            $_SESSION['pseudo'] = $_POST['pseudo'];
            $_SESSION['email'] = $_POST['email'];
            $_SESSION['mdp'] = $_POST['mdp'];
            $_SESSION['loggued'] = false;

//            $pseudo = htmlspecialchars($_POST['pseudo']);
            $email = htmlspecialchars($_POST['email']);
            $mdp = htmlspecialchars($_POST['mdp']);

//            $pseudolenght = strlen($email);

            $requete = $bdd ->prepare('SELECT * FROM user WHERE email=:email AND mdp=:mdp');
            $requete->execute(array('email'=>$email ,'mdp' =>sha1($mdp)));
            $resultat = $requete->fetchAll();
            $requete->closeCursor(); //fermeture de la requête




            $nb_resultat = count($resultat);

            if($nb_resultat == 1)
            {
                $requete = $bdd ->prepare('SELECT role,pseudo FROM user WHERE email=:email');

                $requete->execute(array('email' =>$email));

                $data = $requete->fetch();

                $requete->closeCursor();

                $pseudo = $data['pseudo'];


                $role = $data['role'];

                if($role == 'user')
                    {

                        $_SESSION['loggued'] = false;
                        $data = recupToId($bdd,$pseudo); //recup son id
                        $_SESSION['id'] = $data['id'];
                        $_SESSION['email'] = $email;
                        $_SESSION['pseudo'] = $pseudo;
                        $_SESSION['mdp'] = $mdp;
                        $requete->closeCursor(); //fermeture de la requête
                     header('location: redirection.php');



                    }

                else
                    {
                        $_SESSION['id'] = 4;
                        $_SESSION['loggued']= true;
                        $requete->closeCursor();
                       header('location: redirectionAdmin.php');


                      //fermeture de la requête


                    }


            }
            else $rep = 'l\'user n\' existe pas ';


        }
        else $rep = "le champ mdp est vide !";
    }
    else $rep = "le champ pseudo est vide ! ";
}




?>




<!DOCTYPE html>
<html>
<head>
    <title>Connexion</title>
    <link rel="stylesheet" type="text/css" href="bootstrap.min.css">
</head>
<body>
<div class="mx-auto" style="width:500px; margin-left: 35%;">
<h2>Connexion</h2>
<form method="post" action="connexion.php">

    <div class="form-group">
       <label for="pseudo"> Email </label>
       <input type="text" placeholder="Email" required="" name="email" class="form-control">
    </div>
    <div class="form-group">
        <label for ="mdp"> Mot de passe </label>
       <input type="password"  class="form-control" placeholder="Mot de passe" required="" name="mdp">
    </div>
       <input type="submit" name="connexion" class="btn btn-primary">


</form>

<?php    echo '<h1>'.$rep.'</h1>' ?>
</div>
</body>
</html>
