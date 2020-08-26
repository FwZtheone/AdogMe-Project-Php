<?php


function connectionDb()
{
    try{
        $bdd = new PDO('mysql:host=localhost;dbname=mydb;charset=utf8','root','', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

    }
  catch (Exception $e)
  {
      echo "erreur de connection à la base de données";
  }
    return $bdd;
}

function affichageDeLaDb($bdd)
{
        $bdd = connectionDb();
        $requete  = $bdd ->prepare('SELECT * FROM user ');
        $requete->execute();
        $tab_affichage = $requete ->fetch();
        $requete->closeCursor();

        return $tab_affichage;

}

function nombreDeLigneDb($bdd)
{
    $bdd = connectionDb();

    $requete  = $bdd ->prepare('SELECT count(*) FROM user');
    $requete ->execute();
    $nombre_row = $requete->fetchColumn();
    $requete->closeCursor();

    return $nombre_row;

}


function recupToId($bdd,$tableau)
{
    $bdd = connectionDb();

    $requete = $bdd ->prepare('SELECT id FROM user WHERE pseudo=:pseudo');
    $requete->execute(array('pseudo' =>$tableau));
    $data = $requete->fetch();
    $requete->closeCursor();

    return $data;
}

function insertMessage($bdd,$id,$id_admin,$message)
{
    $bdd = connectionDb();

    $requete = $bdd ->prepare('INSERT INTO mess (id_expediteur,id_destinataire,message,date_envoi) VALUES
                            (:id_expediteur,:id_destinataire,:message,NOW()) ');
    $requete->execute(array('id_expediteur' => $id,'id_destinataire' =>$id_admin,'message' =>$message));
    $requete->closeCursor();

}

function showMessage($bdd,$id)
{
    try{
        $bdd = connectionDb();
        $requete = $bdd->prepare('SELECT message FROM mess WHERE id_expediteur=:id_expediteur ');
        $requete->execute(array('id_expediteur' => $id ));


        while($data = $requete->fetch())
        {
            echo $data['message'].'<br>';
            echo '<hr>';
        }
        $requete->closeCursor();
    }
    catch (Exception $e)
    {
        echo " error ";
    }

}




function insertToDb($bdd,$nom,$prenom,$mdp,$email,$pseudo,$role)
{
    $bdd = connectionDb();
    $requete = $bdd ->prepare('INSERT INTO user (nom,prenom,mdp,email,pseudo,role) VALUES(:nom,:prenom,:mdp,:email,:pseudo,:role)');
    $requete->execute(array('nom'=>$nom,'prenom'=>$prenom,'mdp'=>$mdp,'email'=>$email ,'pseudo'=>$pseudo,'role'=>$role));
    $requete->closeCursor();
}


function deleteToDb($bdd,$id)
{
    $bdd = connectionDb();
    $requete = $bdd ->prepare('DELETE FROM user WHERE id=:id');
    $requete ->execute(array('id'=>$id));
    $requete->closeCursor();
}

function updateToDb($bdd,$id,$nouveau_nom,$nouveau_prenom,$nouveau_email,$nouveau_mdp)
{
    $bdd = connectionDb();
    $requete = $bdd ->prepare('UPDATE user SET nom=:nom,prenom=:prenom,email=:email,mdp=:mdp
                                            WHERE id=:id');
    $requete->execute(array(
        'nom' => $nouveau_nom,
        'prenom' => $nouveau_prenom,
        'email' => $nouveau_email,
        'mdp' => $nouveau_mdp,
        'id' => $id
    ));
    $requete->closeCursor();
}

function updateToDbWithPseudo($bdd,$id,$nouveau_nom,$nouveau_prenom,$nouveau_email,$nouveau_mdp,$pseudo)
{
    $bdd = connectionDb();
    $requete = $bdd ->prepare('UPDATE user SET nom=:nom,prenom=:prenom,email=:email,mdp=:mdp,pseudo=:pseudo
                                            WHERE id=:id');
    $requete->execute(array(
        'nom' => $nouveau_nom,
        'prenom' => $nouveau_prenom,
        'email' => $nouveau_email,
        'mdp' => $nouveau_mdp,
        'id' => $id,
        'pseudo' =>$pseudo
    ));
    $requete->closeCursor();
}



function isValidEmail($email)
{
    if(preg_match("/^([\w-\.]+)@((?:[\w]+\.)+)([a-zA-Z]{2,4})/i", $email)) {
        return true;
    } else {
        return false;
    }
}





?>