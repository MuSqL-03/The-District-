<?php
include 'db_connect.php';

// Fetch categories from the database
$sql = "SELECT id, libelle, image FROM categorie WHERE active = 'Yes'";
$result = $conn->query($sql);

// Handle potential query errors
if ($result === FALSE) {
    die("Error: " . $conn->error);
}

$categories = [];
while ($row = $result->fetch_assoc()) {
    $categories[] = $row;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>The District</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="stylesheet" href="style.css">
</head>

<script>
    document.addEventListener('DOMContentLoaded', (event) => {
      const cards = Array.from(document.querySelectorAll('#category-container .col-md-4'));
      const numCardsToShow = 3;
      let currentStartIndex = 0;
      
      function showCards(startIndex) {
        cards.forEach((card, index) => {
          card.classList.toggle('d-none', index < startIndex || index >= startIndex + numCardsToShow);
        });
        document.getElementById('prev-btn').disabled = startIndex === 0;
        document.getElementById('next-btn').disabled = startIndex + numCardsToShow >= cards.length;
      }
      
      document.getElementById('next-btn').addEventListener('click', () => {
        if (currentStartIndex + numCardsToShow < cards.length) {
          currentStartIndex += numCardsToShow;
          showCards(currentStartIndex);
        }
      });
      
      document.getElementById('prev-btn').addEventListener('click', () => {
        if (currentStartIndex - numCardsToShow >= 0) {
          currentStartIndex -= numCardsToShow;
          showCards(currentStartIndex);
        }
      });
    
      // Initially show the first set of cards
      showCards(currentStartIndex);
    });
</script>

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
        <li class="nav-item">
          <a class="nav-link" href="accueil.php">Accueil</a>
        </li>
        <li class="nav-item">
          <a class="nav-link  active" href="categories.php">Catégorie</a>
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
<div class="search-container">
  <img src="Images/bg2.jpeg" alt="Background Image" style="height: 750px;" >
</div>

<main class="container my-5">
    <h2>Les Catégories</h2><br>
    <hr>
    <div class="row" id="category-container">
      <?php foreach ($categories as $index => $category): ?>
        <div class="col-md-4 mb-4 d-none" id="card-<?php echo $index + 1; ?>">
          <div class="card category-card">
          <a href="plats_par_categorie.php?id=<?php echo htmlspecialchars($category['id']); ?>">
        <img src="Images/category/<?php echo htmlspecialchars($category['image']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($category['libelle']); ?>">
           </a>
            <div class="card-body">
              <h5 class="card-title"><?php echo htmlspecialchars($category['libelle']); ?></h5>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
     <!-- Navigation buttons -->
     <div class="d-flex justify-content-between my-4">
      <a class="btn btn-primary" id="prev-btn" role="button" aria-label="Previous" disabled>Previous</a>
      <a class="btn btn-primary" id="next-btn" role="button" aria-label="Next">Next</a>
    </div>
    
   
</main>
<footer class="bg-dark text-center py-3 ">
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
