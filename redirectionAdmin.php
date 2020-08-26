<?php
session_start();
require_once("fonction.php");
$bdd = connectionDb();

require_once ("auth.php");


$_SESSION['voircandidature'] ='ok';
$condition = 0;
if(isset($_POST['modification']))
{
    $_SESSION['id_user'] = $_POST['modifier'];
    header('location: modifierAdmin.php');
}
else if(isset($_POST['supp']))
{


    $email_user = $_POST['supprimer'];

    $requete = $bdd ->prepare('SELECT id FROM user WHERE email=:email');
    $requete->execute(array('email'=>$email_user));
    $data = $requete->fetch();
    $requete->closeCursor();

    $requete = $bdd ->prepare('DELETE FROM mess WHERE id_expediteur=:id_expediteur');
    $requete->execute(array('id_expediteur' => $data['id']));
    $requete->closeCursor();
    ?>
    <p class="h3 text-success"> Message bien supprimé  !</p>
    <?php

}
else if(isset($_POST['quitter']))
{
    session_destroy();
    header('location: index.php');
}

if(isset($_POST['repondre']))
{
    $_SESSION['email_expediteur'] = $_POST['rep'];
    $condition  = 3 ;


    ?>
    <div>
        <form action="redirectionAdmin.php" method="post">
            <div class="form-group w-75">
                <label for="comment">Message : </label>
                <textarea class="form-control" rows="5" id="comment" name="texte"></textarea>
                <input type="submit" value="envoyer" name="ENVOYER" class="btn btn-primary mt-1">
            </div>
        </form>
    </div>
    <a href="redirectionAdmin.php" class="btn btn-primary">Retour </a>

    <?php
}
if(isset($_POST['ENVOYER']) AND !empty($_POST['texte']))
{



    if (ctype_space($_POST['texte'])) {
        $rep = "tu ne peux pas envoyer un message blanc ! ";
    } else {
        $texte = htmlspecialchars($_POST['texte']);
        echo '<h1 class="text-success h3">' . 'Message bien envoyé à :  ' . $_SESSION['email_expediteur'] . '</h1>';


        $requete= $bdd->prepare('SELECT id FROM user WHERE email=:email');
        $requete->execute(array('email' => $_SESSION['email_expediteur']));
        $data = $requete->fetch();

        $requete->closeCursor();

        try
        {
            insertMessage($bdd,$_SESSION['id'],$data['id'],$texte);

        }
        catch (Exception $e)
        {
            echo "error";
        }

    }

}












?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >
<head>
    <title>Admin</title>
    <link rel="stylesheet" type="text/css" href="bootstrap.min.css">

</head>
<body>
<?php if($condition!==3) { ;?>
<div>
     <p class="font-weight-light h1"> Session :   <small class="text-danger"> admin</small> </p>
    <p class="h3 font-weight-bold text-center text-primary">Liste des utilisateurs</p>
    <div class="table-responsive">
    <table class="table  table-hover table-bordered table-dark">

        <thead>
            <tr>
                <th>ID</th>
                <th> Nom</th>
                <th>Prenom</th>
                <th>Email</th>
                <th>Mdp</th>
                <th>Pseudo</th>
            </tr>
        </thead>

    <tbody>
            <?php

             $requete = $bdd->prepare('SELECT id,nom,prenom,email,mdp,pseudo FROM user');
             $requete ->execute();



            $i = 0;







             while($data = $requete ->fetch())
             {


                 ?>

                <tr>

                    <td> <?php echo $data['id'] ; ?></td>
                    <td> <?php echo $data['nom'] ; ?> </td>
                    <td> <?php echo $data['prenom'] ; ?> </td>
                    <td> <?php echo $data['email'] ; ?> </td>
                    <td> <?php echo $data['mdp'] ; ?> </td>
                    <td> <?php echo $data['pseudo'] ; ?> </td>
                    <td> <?php echo '<a  class="btn btn-danger" href="supp.php?id='.$data['id']; ?> ">Supprimer </a></td>
                    <td>
                        <form action="redirectionAdmin.php" method="post">
                            <input type="hidden" value="<?php echo $data['id'];?>" name="modifier">
                            <input type="submit" value="modifier" name="modification" class="btn btn-success">
                        </form>
                    </td>

                </tr>
                <?php $i++;
             }

            $requete->closeCursor();


                 ?>
    </tbody>
    </table>
    </div>

</div>

<div class="table-responsive">
    <p class="h3 font-weight-bold text-center text-primary">Vos messages</p>
    <table class="table  table-hover table-bordered table-dark">
        <thead>
        <tr>
            <th> Email </th>
            <th> Message</th>
            <th> Date d'envoi</th>
        </tr>
        </thead>

        <tbody>

        <?php //ici je fais ma requête préparée d'affichage de message


        $requete = $bdd ->prepare('SELECT mess.message,user.email,mess.date_envoi,id_expediteur
FROM mess INNER JOIN user ON mess.id_destinataire = user.id WHERE user.id=:id');

        $requete->execute(array('id' => $_SESSION['id']));




       while($data = $requete->fetch())
       {
           $a = $bdd->prepare('SELECT email FROM user WHERE id=:id');
           $a->execute(array('id'=>$data['id_expediteur']));
           $d = $a->fetch() ; ?>

           <tr>
               <td> <?php echo $d['email']; ?></td>
               <td><?php echo $data['message']; ?> </td>
               <td> <?php echo $data['date_envoi']; ?></td>
               <td>
                   <form action="redirectionAdmin.php" method="post">
                       <input type="hidden" name="supprimer" value="<?php echo $d['email'] ?>">
                       <input type="submit" name="supp" value="supprimer" class="btn btn-danger">
                       <input type="hidden" name="rep" value="<?php echo $d['email'];?>">
                       <input type="submit" name="repondre" value="repondre" class="btn btn-primary">
                   </form>
               </td>
           </tr>


            <?php
       }
        ?>

        <?php $requete->closeCursor();?>



        </tbody>


    </table>

</div>

<div>
    <div style="padding: 10px;">
    <form action="redirectionAdmin.php" method="post">
        <input type="submit" name="quitter" value="déconnexion" class="btn btn-primary">
    </form>
    </div>

    <a href="ajoutChienAdmin.php" class="btn btn-primary">Ajouter un chien</a>
    <a href="listeDeChiots.php" class="btn-primary btn"> Voir Liste des chiens</a>
    <a href="voircandidature.php" class="btn btn-primary">Candidature</a>

</div>

<?php } ; ?>

</body>
</html>
