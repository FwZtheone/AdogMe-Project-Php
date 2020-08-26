<?php
session_start();
require_once ('fonction.php');
require_once ('auth_user.php');
$bdd = connectionDb();


if(isset($_POST['supprimer']))
{


    $id_message = $_POST['supp'];

    $requete = $bdd->prepare('DELETE FROM mess WHERE id=:id');
    $requete->execute(array('id' =>$id_message));
    $requete->closeCursor();

}

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >
<head>
    <title>Redirection HTML</title>
    <link rel="stylesheet" type="text/css" href="bootstrap.min.css">

</head>
<body>

<div class="table-responsive">
    <table class="table  table-hover table-bordered table-dark">
        <thead>
        <th>Message</th>
        <th>Envoyé à </th>
        <th>Date d'envoie</th>
        </thead>
        <tbody>
        <?php
        $requete  = $bdd->prepare('SELECT mess.message,user.email,mess.date_envoi,mess.id_destinataire,mess.id FROM user INNER JOIN mess ON  
                                            mess.id_expediteur = user.id WHERE user.id=:id');
        $requete->execute(array('id'=>$_SESSION['id']));
        while($data = $requete->fetch()) {

           $a = $bdd->prepare('SELECT email FROM user WHERE id=:id');
            $a->execute(array('id'=>$data['id_destinataire']));
            $d = $a->fetch() ; ?>
        <tr>
            <td><?php echo $data['message']; ?></td>
            <td><?php echo $d['email'] ;?></td>
            <td><?php echo $data['date_envoi']; ?></td>
            <td>
                <form action="boite_envoie.php" method="post">

                    <input type="hidden" name="supp" value="<?php echo $data['id'];?>"
                    <label>  <input type="submit" name="supprimer" value="supprimer" class="btn btn-danger"></label>
                </form>
            </td>



        </tr>
        <?php }  $requete->closeCursor(); ?>
        </tbody>
    </table>
    <a href="redirection.php"> Retour espace membre</a>
</div>
</body>
</html>


