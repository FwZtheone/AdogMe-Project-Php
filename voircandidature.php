<?php
session_start();
require_once ('fonction.php');

$rep = null;
$bdd = connectionDb();

if(isset($_SESSION['voircandidature']) AND $_SESSION['voircandidature'] =='ok')
{

    if(isset($_SESSION['loggued']))
    {


        $requete= $bdd->prepare('SELECT candidature.id,user.id,user.email, chien.url, candidature.presentation,chien.id_user,chien.id,chien.nom
                    FROM user INNER JOIN candidature 
                    ON user.id=candidature.id_client
                        INNER JOIN chien 
                            ON candidature.id_chien = chien.id 
                            WHERE chien.id_user=:id_user AND candidature.status NOT IN("accepter")');
        $requete->execute(array('id_user'=>$_SESSION['id']));


        if(isset($_POST['accepter']))
        {
            $id_user = $_POST['id_client'];
            $accepter = 'accepter';
            $adoptable='non';
            $id_candidature = $_POST['id_candidature'];


                $requete=$bdd->prepare('UPDATE candidature INNER JOIN chien
            ON candidature.id_maitre=chien.id_user
            SET candidature.status=:status,
                chien.id_user=:id_user,
                chien.adoptable=:adoptable
            WHERE candidature.id=:id');
                $requete->execute(array('status'=>$accepter,'id_user'=>$id_user,'id'=>$id_candidature,'adoptable'=>$adoptable));
                $requete->closeCursor();



                if($_SESSION['loggued'] == false)
                {
                    header('location: redirection.php');
                }
                else if ($_SESSION['loggued'] == true)
                {
                    header('location: redirectionAdmin.php');
                }
                else{
                    header('location: index.php');
                }








        }
        else if(isset($_POST['refuser']))
        {
            $id_user = $_POST['id_client'];
            $id_candidature = $_POST['id_candidature'];
            $requete= $bdd->prepare('DELETE FROM candidature WHERE id=:id ');
            $requete->execute(array('id'=>$id_candidature));
            $requete->closeCursor();
            if($_SESSION['loggued'] == false)
            {
                header('location: redirection.php');
            }
            else if ($_SESSION['loggued'] == true)
            {
                header('location: redirectionAdmin.php');
            }
            else{
                header('location: index.php');
            }




        }

        ?>






        <table class="table  table-hover table-bordered table-dark">
            <thead>
                <th>Chien</th>
                <th>Demandeur</th>
                <th>Presentation</th>
            </thead>
            <tbody>
        <?php  while($data=$requete->fetch()) {  ;?>
                <tr>
                    <td><img src="uploads/<?php echo $data['url'] ;?>" alt="un chien cool" ></td>
                    <td><?php echo $data['email'] ; ?></td>
                    <td><?php  echo $data['presentation'];?></td>
                    <td>
                        <form action="voircandidature.php" method="post">
                            <input type="hidden" name="id_client" value="<?php echo $data[1];?>">
                            <input type="hidden" name="id_candidature" value="<?php echo $data[0];?>">


                            <input type="submit" name="accepter" value="accepter" class="btn btn-success">
                            <input type="submit" name="refuser" value="refuser" class="btn btn-danger">

                        </form>
                    </td>
                </tr>
        <?php } $requete->closeCursor();?>
            </tbody>
        </table>

   <?php }
}
else {
        header('location: index.php');

}


?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >
<head>
    <title>Redirection HTML</title>
    <link rel="stylesheet" type="text/css" href="bootstrap.min.css">
    <style>
        img{
            width : 200px;
            height: 200px;
        }
    </style>
</head>
<body>

</body>
</html>

