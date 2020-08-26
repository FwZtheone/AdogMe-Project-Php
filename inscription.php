<?php

session_start();
$bdd = new PDO('mysql:host=localhost;dbname=mydb;charset=utf8','root','', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

$rep  = " ";

if(isset($_POST['valider'])) // connection OK
{
    if(!empty($_POST['nom']) AND (!empty($_POST['prenom']))   AND (!empty($_POST['mdp']))   AND (!empty($_POST['email'])) AND  (!empty($_POST['pseudo'])   ))
    {

        if(preg_match("/^([\w-\.]+)@((?:[\w]+\.)+)([a-zA-Z]{2,4})/i", $_POST['email'])) {


        $pseudo = htmlspecialchars($_POST['pseudo']);
        $nom = htmlspecialchars($_POST['nom']);
        $prenom = htmlspecialchars($_POST['prenom']);
        $mdp = sha1($_POST['mdp']);
        $email = htmlspecialchars($_POST['email']);
        $role = 'user';

        $nomlenght = strlen($nom);
        $prenomlenght = strlen($prenom);
        $pseudolenght = strlen($pseudo);

            if(($nomlenght <= 50) AND   ($prenomlenght <= 50) AND ($pseudolenght <= 50) AND strlen($_POST['mdp']) >= 4)
            {
                $requete = $bdd->prepare('SELECT * FROM user WHERE email= ? ');
                $requete->execute(array($email));

                $emailexits = $requete->rowCount();


                if($emailexits == 0)
                {
                    $requete->closeCursor();
                    $requete = $bdd->prepare('INSERT INTO user (nom,prenom,mdp,email,pseudo,role)
                                                VALUES(:nom,:prenom,:mdp,:email,:pseudo,:role)');
                    $requete->execute(array('nom'=>$nom,'prenom'=>$prenom,'mdp'=>$mdp,'email'=>$email ,'pseudo'=>$pseudo,'role'=>$role));
                    $requete->closeCursor();
                    $_SESSION['validation'] = "Validation !";
                    header('location: index.php');



                }


                else
                {
                    $rep = " l'email est la même ! ";
                }
            }


            else {
                $rep = "Caractère au dessus de 50 !";
            }
        }
        else $rep="format d'email incorrect";


    }
    else

        $rep = "champ manquant ! ";



}






?>



<!DOCTYPE html>
<html>
<head>
    <title>Inscription</title>
    <link rel="stylesheet" type="text/css" href="bootstrap.min.css">

</head>
<body>


<div style="margin-left: 35%; width: 500px;">
<h2>Inscription</h2>
<form action="inscription.php" method="post">

    <p>Complète le formulaire, les champs marqués par <em>*</em> sont <em>obligatoires</em> </p>
    <div class="form-group">
        <label for="pseudo"> Pseudo <em>*</em></label>
        <input type="text" name="pseudo" placeholder="Pseudo" required="" class="form-control">
    </div>
    <div class="form-group">
        <label for="nom"> Nom <em>*</em>  </label>
        <input  type="text"  name="nom"  placeholder="Nom" autofocus="" required="" class="form-control">
    </div>
    <div class="form-group">
        <label for="prenom"> Prenom <em>*</em>  </label>
        <input type="text" name="prenom" placeholder="Prenom" required="" class="form-control">
    </div>
    <div class="form-group">
        <label for="mdp"> Mot de passe <em>*</em>  </label>
        <input type="password" name="mdp" placeholder="mdp" required="" class="form-control">
        <small id="passWordHelpBlock" class="form-text text-muted">Le mot de passe doit être suppèrieur ou égale  à 4 caractères</small>
    </div>
    <div class="form-group">
        <label for="email"> Email <em>*</em>  </label>
        <input   type="email" name="email" placeholder="email" required="" class="form-control">
        <small id="emailHelpBlock" class="form-text text-muted">L'email doit être de type example@hotmail.com, le @ est obligatoire ! </small>
    </div>
    <input type="submit" name="valider" class="btn btn-primary">


</form>
<?php echo '<h1 class="text-danger h3">'.$rep.'</h1>' ?>
</div>
</body>
</html>
