<?php
?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >
<head>
    <title>Contact</title>
    <link rel="stylesheet" type="text/css" href="bootstrap.min.css">

</head>
<body>


<section class="Material-contact-section section-padding section-dark">
    <div class="container">
        <div class="row">
            <div class="col-md-12 wow animated fadeInLeft" data-wow-delay=".2s">
                <h1 class="section-title">Contactez-nous </h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mt-3 contact-widget-section2 wow animated fadeInLeft" data-wow-delay=".2s">
          <p> Si vous avez n'importe quelle question n'hésitez pas à nous contacter</p>

                <div class="find-widget">
                    Site internet:  <a href="index.php">AdogMoi</a>
                </div>
                <div class="find-widget">
                    Addresse: <a href="#">7000 Mons rue Albert</a>
                </div>
                <div class="find-widget">
                    Téléphone:  <a href="#">065/25/35/54</a>
                </div>

                <div class="find-widget">
                    Support : <a href="#">Le support est ouvert de 9h00 à 17h00</a>
                </div>
            </div>
            <div class="col-md-6 wow animated fadeInRight" data-wow-delay=".2s">
                <form class="shake" role="form" method="post" id="contactForm" name="contact-form" data-toggle="validator">
                    <div class="form-group label-floating">
                        <label class="control-label" for="name">Nom</label>
                        <input class="form-control" id="name" type="text" name="name" required data-error="Please enter your name">
                        <div class="help-block with-errors"></div>
                    </div>
                    <div class="form-group label-floating">
                        <label class="control-label" for="email">Prenom</label>
                        <input class="form-control" id="email" type="email" name="email" required data-error="Please enter your Email">
                        <div class="help-block with-errors"></div>
                    </div>
                    <div class="form-group label-floating">
                        <label class="control-label">Sujet</label>
                        <input class="form-control" id="msg_subject" type="text" name="subject" required data-error="Please enter your message subject">
                        <div class="help-block with-errors"></div>
                    </div>
                    <div class="form-group label-floating">
                        <label for="message" class="control-label">Message</label>
                        <textarea class="form-control" rows="3" id="message" name="message" required data-error="Write your message"></textarea>
                        <div class="help-block with-errors"></div>
                    </div>
                    <div class="form-submit mt-5">
                        <button class="btn btn-primary" type="submit" id="form-submit"><i class="material-icons mdi mdi-message-outline"></i> Send Message</button>
                        <div id="msgSubmit" class="h3 text-center hidden"></div>
                        <div class="clearfix"></div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</section>




</body>
</html>

