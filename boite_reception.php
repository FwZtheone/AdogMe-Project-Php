<?php
session_start();
require_once ('fonction.php');
require_once ('auth_user.php');
$bdd = connectionDb();
$rep =null;
$condition = 0 ;


if(isset($_POST['repondre']))
{
    $_SESSION['email_expediteur'] = $_POST['rep'];
    $condition  = 3 ;


    ?>
    <div>
        <form action="boite_reception.php" method="post">
            <div class="form-group w-75">
                <label for="comment">Message : </label>
                <textarea class="form-control" rows="5" id="comment" name="texte"></textarea>
                <input type="submit" value="envoyer" name="ENVOYER" class="btn btn-primary mt-1">
            </div>
        </form>
    </div>
    <a href="boite_reception.php" class="btn btn-primary">Retour </a>

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
    <title>Redirection HTML</title>
    <link rel="stylesheet" type="text/css" href="bootstrap.min.css">

</head>
<body>

<?php if($condition !== 3) {;?>
<div class="table-responsive">
    <table class="table  table-hover table-bordered table-dark">
        <thead>
            <th>Message</th>
            <th>Recu de </th>
            <th>Date d'envoie</th>
        </thead>
        <tbody>
            <?php   //requête préparée

            $requete = $bdd->prepare('SELECT mess.message,user.email,mess.date_envoi,mess.id_expediteur FROM mess INNER JOIN user ON 
                                                    mess.id_destinataire=user.id WHERE user.id=:id_user');
            $requete->execute(array('id_user' =>$_SESSION['id']));







            while($data = $requete->fetch())
            {

                $a = $bdd->prepare('SELECT email FROM user WHERE id=:id');
                $a->execute(array('id'=>$data['id_expediteur']));
                $d = $a->fetch() ; ?>
                    <tr>
                        <td><?php echo  $data['message'];?></td>
                        <td><?php echo  $d['email'];?></td>
                        <td><?php echo  $data['date_envoi'];?></td>
                        <td>
                            <form action="boite_reception.php" method="post">

                                <input type="hidden" name="rep" value="<?php echo $d['email'];?>">
                                <input type="submit" name="repondre" value="repondre" class="btn btn-primary">

                            </form>
                        </td>

                    </tr>
             <?php $a->closeCursor(); } $requete->closeCursor(); ?>



        </tbody>
    </table>
    <a href="redirection.php">retour espace membre</a>
    <p class="text-danger h3"> <?php  echo $rep;?></p>
</div>
<?php } ;?>
</body>
</html>

