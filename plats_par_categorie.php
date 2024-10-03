<?php
include 'db_connect.php';

// Get category ID from URL
$category_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch category name for display
$category_query = "SELECT libelle FROM categorie WHERE id = ?";
$stmt = $conn->prepare($category_query);
$stmt->bind_param("i", $category_id);
$stmt->execute();
$category_result = $stmt->get_result();
$category = $category_result->fetch_assoc();

if (!$category) {
    die("Category not found.");
}

// Fetch dishes for the selected category
$plat_query = "SELECT * FROM plat WHERE id_categorie = ?";
$stmt = $conn->prepare($plat_query);
$stmt->bind_param("i", $category_id);
$stmt->execute();
$plat_result = $stmt->get_result();
$plats = [];
while ($row = $plat_result->fetch_assoc()) {
    $plats[] = $row;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title><?php echo htmlspecialchars($category['libelle']); ?> - The District</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="stylesheet" href="style.css">
  <style>
    .card-img-top {
      width: 100%;
      height: 200px;
      object-fit: cover;
    }
  </style>
</head>
<body class="bg-danger">
  <nav class="navbar navbar-expand-sm bg-danger navbar-dark fixed-top">
    <div class="container-fluid">
      <a class="navbar-brand me-3" href="#">
        <img src="Images/brand/logo_transparent.png" alt="Logo" style="width:120px; object-fit: cover;" class="rounded-pill">
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavbar">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="collapsibleNavbar">
        <ul class="navbar-nav mx-auto">
          <li class="nav-item"><a class="nav-link" href="accueil.php">Accueil</a></li>
          <li class="nav-item"><a class="nav-link" href="categories.php">Catégorie</a></li>
          <li class="nav-item"><a class="nav-link" href="plats.php">Plats</a></li>
          <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
        </ul>
      </div>
    </div>
  </nav>
  <div class="search-container">
    <img src="Images/bg2.jpeg" alt="Background Image" style="height: 750px;">
  </div>
  <main class="container my-5">
    <h2>Plats de la catégorie <?php echo htmlspecialchars($category['libelle']); ?></h2>
    <hr>
    <div class="row">
      <?php if (empty($plats)): ?>
        <p>Aucun plat disponible dans cette catégorie.</p>
      <?php else: ?>
        <?php foreach ($plats as $plat): ?>
          <div class="col-md-4 mb-4">
            <div class="card">
              <img src="Images/food/<?php echo htmlspecialchars($plat['image']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($plat['libelle']); ?>">
              <div class="card-body">
                <h5 class="card-title"><?php echo htmlspecialchars($plat['libelle']); ?></h5>
                <p class="card-text"><?php echo htmlspecialchars($plat['description']); ?></p>
                <p class="card-text"><strong>Prix:</strong> $<?php echo number_format($plat['prix'], 2); ?></p>
                <a href="commande.php?id=<?php echo htmlspecialchars($plat['id']); ?>" class="btn btn-primary">Commander</a>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </main>
  <footer class="bg-dark text-center py-3 fixed-bottom">
    <div class="social-icons">
      <a href="https://www.facebook.com" target="_blank"><i class="fab fa-facebook-f"></i></a>
      <a href="https://www.twitter.com" target="_blank"><i class="fab fa-twitter"></i></a>
      <a href="https://www.instagram.com" target="_blank"><i class="fab fa-instagram"></i></a>
      <a href="https://www.linkedin.com" target="_blank"><i class="fab fa-linkedin-in"></i></a>
    </div>
    <p><strong>© 2024 The District. Tous droits réservés.</strong></p>
  </footer>
</body>
</html>
