<?php


session_start();

try {
    if(isset($_SESSION['validation']))
    {
        echo '<p style="font-size: 60px ; color: #1c7430; font-weight: bold;">'.'Inscription réussi !'.'</p>';
        session_destroy();

    }
}

catch(Exception $e)
{
    echo " ";
}


?>


<!DOCTYPE html>
<html>
<head>
    <title>TestPageFun</title>
    <link rel="stylesheet" type="text/css" href="feuille.css">

</head>
<body>
    <nav>
        <div id="header">
            <h1 id="logo">adog moi</h1>
            <ul id="menu">
                <li><a href="connexion.php"><span>connexion</span></a></li>
                <li><a href="inscription.php"><span>inscription</span></a></li>
                <li><a href="listeDeChiots.php"><span>liste de chien</span></a></li>
                <li><a href="contact.php"><span>contact</span></a></li>
            </ul>
        </div>
    </nav>



</body>
</html>