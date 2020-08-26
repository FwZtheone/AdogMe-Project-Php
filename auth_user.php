<?php




if(!isset($_SESSION['loggued']))
{
    header('location: index.php');
    exit();

}

else{

    if($_SESSION['loggued'] == false)
    {


    }
    else {
        header('location: index.php');

    }
}
?>