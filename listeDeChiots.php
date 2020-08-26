<?php
session_start();
require_once ('fonction.php');
$bdd = connectionDb();

if(isset($_SESSION['envoie']) AND !empty($_SESSION['envoie']))
{
    echo $_SESSION['envoie'];
    $_SESSION['envoie'] = array ();
}
if(isset($_SESSION['loggued']))
{
    if(isset($_POST['supprimer']))
    {
        $_SESSION['id_image'] = $_POST['edit'];
        echo 'Supp : '.$_SESSION['id_image'];
        $requete = $bdd->prepare('DELETE FROM chien WHERE id=:id');
        $requete->execute(array('id'=>$_SESSION['id_image']));
        $requete->closeCursor();

    }
    else if (isset($_POST['modifier']))
    {
        $_SESSION['id_image'] = $_POST['edit'];
        echo ' Modifier : '.$_SESSION['id_image'];
        header('location: listeDeChiotsModifier.php');

    }
    else if(isset($_POST['adopte']))
    {
        $id_chien = $_POST['adoption'];

        $requete  = $bdd->prepare('SELECT user.pseudo,user.prenom,user.id,user.email 
                        FROM user INNER JOIN chien ON user.id=chien.id_user WHERE chien.id = ?');
        $requete->execute(array($id_chien));
        $data = $requete->fetch();
        $requete->closeCursor();

        $_SESSION['tableau_maitre'] = $data;
        header('location: presentation.php');
    }
    else if(isset($_POST['candidature']))
    {
        $id_chien = $_POST['candidat'];
        $_SESSION['candidature'] = 'ok';

        $requete  = $bdd->prepare('SELECT user.pseudo,user.prenom,user.id,user.email 
                        FROM user INNER JOIN chien ON user.id=chien.id_user WHERE chien.id = ?');
        $requete->execute(array($id_chien));
        $data = $requete->fetch();
        $requete->closeCursor();

        $_SESSION['candidature_maitre'] = $data;
        $_SESSION['id_chien'] = $id_chien;
        header('location: candidature.php');
    }


}



?>






<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >
<head>
    <title>Modification</title>
    <link rel="stylesheet" type="text/css" href="bootstrap.min.css">
    <style type="text/css">
        img {
            width: 200px;
            height: 200px;


        }


    </style>
</head>
<body>


<table class="table  table-hover table-bordered table-dark">
    <thead>
    <tr>
        <th>  Chien </th>
        <th> Presentation </th>
        <th> Date de Naissance</th>
        <th> Nom </th>
        <th> Sexe</th>
        <th> race</th>
    </tr>
    </thead>

    <tbody>
    <?php  $requete = $bdd->prepare('SELECT * FROM chien WHERE adoptable NOT IN("non")');
            $requete->execute();



         while($data = $requete->fetch())
            {

                ?>
            <tr>
                <td> <img  class="img-thumbnail" src="<?php echo 'uploads/'.$data['url'] ; ?>" alt=""></td>
                <td><?php echo $data['presentation'];?></td>
                <td> <?php echo $data['naissance'];?></td>
                <td><?php echo $data['nom'];?> </td>
                <td><?php echo $data['sexe'];?> </td>
                <td><?php echo $data['race'];?> </td>
                <?php if( isset($_SESSION['loggued']) AND $_SESSION['loggued'] == true) {;?>
                    <td>
                        <form action="listeDeChiots.php" method="post">
                            <input type="hidden" name="edit" value="<?php echo $data['id']?>">
                            <input type="submit" name="supprimer" value="supprimer" class="btn btn-danger">
                            <input type="submit" name="modifier" value="modifier" class="btn btn-success">
                        </form>
                    </td>
               <?php };?>
                <?php if(isset($_SESSION['loggued']) AND $_SESSION['loggued'] == false AND $_SESSION['id'] != $data['id_user'] )
                    { ;?>
                        <td>
                            <form action="listeDeChiots.php" method="post">
                                <label> <input type="hidden" name="adoption" value="<?php echo $data['id'];?>"></label>
                                <label> <input type="submit" name="adopte" value="Envoyer un message" class="btn btn-primary"> </label>
                            </form>
                            <form action="listeDeChiots.php" method="post">
                                <label> <input type="hidden" name="candidat" value="<?php echo $data['id'];?>"></label>
                                <label> <input type="submit" name="candidature" value="AdopteMoi" class="btn btn-primary"> </label>
                            </form>
                        </td>
                    <?php } ; ?>
            </tr>
            <?php
            }

            $requete->closeCursor();
            ?>
    </tbody>
</table>


<?php if(isset($_SESSION['loggued']) AND $_SESSION['loggued'] ==false )
 { ;?>
     <div> <p class="text-muted h3">Tu veux proposer ton chien ? </p></div>
<a href="proposetonchien.php" class="btn btn-primary">Propose ton chien </a>
<a href="redirection.php" class="btn btn-primary">Retour</a>
<?php } ;?>

<?php
if(isset($_SESSION['loggued'])  AND $_SESSION['loggued'] == true)
        { ;?>
            <a href="redirectionAdmin.php" class="btn btn-primary">Retour</a>

    <?php } ;

?>




</body>
</html>
