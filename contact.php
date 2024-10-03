<!DOCTYPE html>
<html lang="en">

<head>
  <title>Contact Nous</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="stylesheet" href="style.css">

</head>
<body class="bg-danger">
<nav class="navbar navbar-expand-sm bg-danger navbar-dark ">
    <div class="container-fluid">
      <a class="navbar-brand me-3" href="#">
        <img src="Images/brand/logo_transparent.png" alt="Logo" style="width:120px; object-fit: cover;"
          class="rounded-pill">
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavbar">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="collapsibleNavbar">
        <ul class="navbar-nav mx-auto">
          <li class="nav-item">
            <a class="nav-link" href="accueil.php"   >Accueil</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="categories.php">Catégorie</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="plats.php">Plats</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="contact.php">Contact</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
<hr>
<div class="container my-5">
<h2>Contactez-nous</h2>
    <hr>
    

    <form action="" method="POST">
        <div class="mb-3">
            <label for="nom"> <strong>Nom:</strong></label><br>
            <input type="text" class="form-control" id="nom" name="nom" placeholder="Votre nom....." require>
        </div>
        <div class="mb-3">
            <label for="prenom"><strong>Prénom:</strong></label>
            <input type="text" name="prenom" id="prenom" class="form-control" placeholder="Votre prénom....." require>
        </div>
        <div class="mb-3">
            <label for="email"><strong>Email:</strong></label>
            <input type="text" id="email" name="email" class="form-control" placeholder="Votre email addresse....." require>
        </div>
        <div class="mb-3">
            <label for="telephone"><strong>Téléphone:</strong></label>
            <input type="text" id="telephone" name="telephone" class="form-control" placeholder="Votre numéro téléphone...." require>
        </div>
        <div class="mb-3">
            <label for="message"><strong>Message:</strong></label>
            <textarea name="message" id="message" class="form-control" rows="5" placeholder="Votre message......." ></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Envoyer </button>
        <a href="accueil.php" class="btn btn-warning float-end">Retour</a>
        </form>
</div>

<!--PHP MAILAIR POUR CONTACT FORM -->

<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


require 'vendor/autoload.php';


if($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    // Retrieve from data

    $nom = htmlspecialchars($_POST['nom']);
    $prenom = htmlspecialchars($_POST['prenom']);
    $email = htmlspecialchars($_POST['email']);
    $telephone =  htmlspecialchars($_POST['telephone']);
    $message = htmlspecialchars($_POST['message']);

    $mail = new PHPMailer(true);

    try {

        $mail->isSMTP();
        $mail->Host = 'localhost';
        $mail->Port = 1025;
        $mail->SMTPAuth = false;


          // Recipient settings
        $mail->setFrom('no-reply@votresite.com', 'Contact Form'); // Sender address
        $mail->addAddress('you@yourwebsite.com'); // Replace with your email address
  

        // Email sittings

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = "

        <h3>Nouvelle demande de contact </h3>
        <p><strong>Nom:</strong> $nom</p>
        <p><strong>Prénom:</strong> $prenom </p>
        <p><strong>Email:</strong> $email </p>
        <p><strong>Téléohone:</strong> $telephone </p>
        <p><strong>Message:</strong></p>
        <p>$message</p>
        
        ";

        $mail->send();
        echo '<p class="alert alert-success">Votre Message a été envoyé avec successs  !</p>';
    } catch (Exception $e) {
        echo '<p class="alert alert-danger">Erreur d\'envoi de l\'email: ' . $mail->ErrorInfo . '</p>'; 
    }
}


?>








</body>
</html>