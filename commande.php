<!DOCTYPE html>
<html lang="en">
<head>
  <title>Passer une commande</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="stylesheet" href="style.css">
</head>
<body class="bg-danger">

<nav class="navbar navbar-expand-sm bg-danger navbar-dark" >
<div class="container-fluid">
    <a class="navbar-brand me-3" href="#">
      <img src="Images/brand/logo_transparent.png" alt="Logo" style="width:120px; object-fit: cover;" class="rounded-pill">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="mynavbar">
      <ul class="navbar-nav mx-auto">
        <li class="nav-item">
          <a class="nav-link" href="accueil.php">Accueil</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="categories.php">Catégories</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="plats.php">Plats</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="contact.php">Contact</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
<hr>
<main class="container my-5">
  <h2>Passer une commande</h2>
  <hr>

  <?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include PHPMailer classes
require 'vendor/autoload.php'; // Adjust path as needed
include 'db_connect.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_plat = intval($_POST['id_plat']);
    $quantity = intval($_POST['quantity']);
    $total_query = "SELECT prix FROM plat WHERE id = $id_plat";
    $total_result = $conn->query($total_query);
    $total_row = $total_result->fetch_assoc();
    $total = $total_row['prix'] * $quantity;
    $date_commande = date('Y-m-d H:i:s');
    $etat = 'En préparation';
    $nom_client = $conn->real_escape_string($_POST['first-name'] . ' ' . $_POST['last-name']);
    $telephone_client = $conn->real_escape_string($_POST['phone']);
    $email_client = $conn->real_escape_string($_POST['email']);
    $adresse_client = $conn->real_escape_string($_POST['address']);

    // Insert the new order into the database
    $sql = $conn->prepare("INSERT INTO commande (id_plat, quantite, total, date_commande, etat, nom_client, telephone_client, email_client, adresse_client)
          VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $sql->bind_param("iidssssss", $id_plat, $quantity, $total, $date_commande, $etat, $nom_client, $telephone_client, $email_client, $adresse_client);

    if ($sql->execute()) {
        $message = "<p class='alert alert-success'>Commande ajoutée avec succès !</p>";
        sendOrderEmail($nom_client, $telephone_client, $email_client, $adresse_client, $id_plat, $quantity, $total); // Call the function to send the email
    } else {
        $message = "<p class='alert alert-danger'>Erreur : " . $conn->error . "</p>";
    }

    $sql->close();
}

// Function to send order confirmation email using PHPMailer
function sendOrderEmail($name, $phone, $email, $address, $dishId, $quantity, $total) {
    $mail = new PHPMailer(true);
    try {
        // Server settings for MailHog or another SMTP server
        $mail->isSMTP();
        $mail->Host = 'localhost'; // MailHog host
        $mail->Port = 1025; // MailHog default port
        $mail->SMTPAuth = false; // No authentication for MailHog

        // Set the sender and recipient details
        $mail->setFrom('no-reply@yourwebsite.com', 'The District');
        $mail->addAddress($email); // Send to the client
        $mail->addAddress('you@yourwebsite.com'); // Send to yourself for notification (optional)

        // Email content
        $mail->isHTML(true);
        $mail->Subject = 'Confirmation de commande';
        $mail->Body = "
            <h3>Confirmation de votre commande</h3>
            <p><strong>Nom:</strong> $name</p>
            <p><strong>Téléphone:</strong> $phone</p>
            <p><strong>Email:</strong> $email</p>
            <p><strong>Adresse:</strong> $address</p>
            <p><strong>ID du plat:</strong> $dishId</p>
            <p><strong>Quantité:</strong> $quantity</p>
            <p><strong>Total:</strong> €$total</p>
            <p>Merci pour votre commande !</p>
        ";

        // Attempt to send the email
        $mail->send();
        echo '<p class="alert alert-success">Email de confirmation envoyé avec succès !</p>';
    } catch (Exception $e) {
        echo '<p class="alert alert-danger">Erreur d\'envoi de l\'email: ' . $mail->ErrorInfo . '</p>';
    }
}

// Fetch dish details from URL parameters
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$name = isset($_GET['name']) ? $_GET['name'] : '';
$image = isset($_GET['image']) ? $_GET['image'] : '';
$price = isset($_GET['price']) ? floatval($_GET['price']) : '';

// Fetch dish details for display
if ($id > 0) {
    $sql = $conn->prepare("SELECT * FROM plat WHERE id = ?");
    $sql->bind_param("i", $id);
    $sql->execute();
    $result = $sql->get_result();
    if ($result->num_rows > 0) {
        $dish = $result->fetch_assoc();
    } else {
        echo "<p class='alert alert-warning'>Aucun plat trouvé.</p>";
    }
    $sql->close();
} else {
    echo "<p class='alert alert-danger'>ID de plat invalide.</p>";
}
?>


  <?php if (isset($message)) echo $message; ?>

  <form class="order-form" method="POST" action="">
    <div class="row justify-content-center">
      <div class="col-md-6 mb-4">
        <div class="card dish-card text-center">
          <img id="dish-img" src="Images/food/<?php echo htmlspecialchars($dish['image'] ?? $image); ?>" class="card-img-top mx-auto" alt="<?php echo htmlspecialchars($dish['libelle'] ?? $name); ?>">
          <div class="card-body">
            <h5 id="dish-title" class="card-title"><?php echo htmlspecialchars($dish['libelle'] ?? $name); ?></h5>
            <p id="dish-description" class="card-text"><?php echo htmlspecialchars($dish['description'] ?? ''); ?></p>
            <p class="card-text"><strong>Prix: </strong><?php echo htmlspecialchars($dish['prix'] ?? $price); ?> €</p>
            <div class="mb-3">
              <label for="id_plat" class="form-label">Plat</label>
              <select class="form-select" id="id_plat" name="id_plat" required>
                <option value="<?php echo htmlspecialchars($id); ?>" selected><?php echo htmlspecialchars($name); ?></option>
              </select>
            </div>
            <div class="mb-3">
              <label for="quantity" class="form-label">Quantité</label>
              <input type="number" class="form-control" id="quantity" name="quantity" min="1" required>
            </div>
          </div>
        </div>
      </div>
    </div>

    <h3>Informations Personnelles</h3>
    <div class="mb-3">
      <label for="first-name" class="form-label">Nom</label>
      <input type="text" class="form-control" id="first-name" name="first-name" required>
    </div>
    <div class="mb-3">
      <label for="last-name" class="form-label">Prénom</label>
      <input type="text" class="form-control" id="last-name" name="last-name" required>
    </div>
    <div class="mb-3">
      <label for="email" class="form-label">Email</label>
      <input type="email" class="form-control" id="email" name="email" required>
    </div>
    <div class="mb-3">
      <label for="phone" class="form-label">Téléphone</label>
      <input type="tel" class="form-control" id="phone" name="phone" required>
    </div>
    <div class="mb-3">
      <label for="address" class="form-label">Votre Adresse</label>
      <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
    </div>

    <button type="submit" class="btn btn-primary">Envoyer</button>
  </form>
</main>

<footer class="bg-dark text-center py-3">
  <div class="social-icons">
    <a href="https://www.facebook.com" target="_blank" class="text-light me-3"><i class="fab fa-facebook-f"></i></a>
    <a href="https://www.twitter.com" target="_blank" class="text-light me-3"><i class="fab fa-twitter"></i></a>
    <a href="https://www.instagram.com" target="_blank" class="text-light me-3"><i class="fab fa-instagram"></i></a>
    <a href="https://www.linkedin.com" target="_blank" class="text-light"><i class="fab fa-linkedin-in"></i></a>
  </div>
  <p class="text-light">© 2023 Nom du Site. Tous droits réservés.</p>
</footer>

</body>
</html>

