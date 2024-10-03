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

<body class="bg-danger">

  <?php include 'db_connect.php'; ?>

  <nav class="navbar navbar-expand-sm bg-danger navbar-dark fixed-top">
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
            <a class="nav-link  active" href="#"   >Accueil</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="categories.php">Catégorie</a>
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
    <img src="Images/bg.jpg" alt="Background Image" style="height: 750px;">
    <div class="search-bar">
      <!-- Search form -->
      <form class="d-flex" method="GET" action="">
        <input class="form-control" type="text" name="search" placeholder="Search"
          value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
        <button class="btn btn-warning ms-2" type="submit">Search</button>
      </form>
    </div>
  </div>
  <hr>

  <main class="container my-5">
    <h2>Catégories</h2><br>
    <hr>
    <div class="row">
      <?php
      // Check if a search query is set
      $search = isset($_GET['search']) ? $_GET['search'] : '';

      // Fetch categories based on search query
      $sql = "SELECT * FROM categorie WHERE active = 'Yes'";
      if ($search) {
        $sql .= " AND libelle LIKE '%$search%'";
      }
      $sql .= " LIMIT 3";
      $result = $conn->query($sql);

      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          echo '<div class="col-md-4 mb-4">
                    <div class="card category-card">
                      <a href="categories.php?id=' . $row["id"] . '">
                        <img src="Images/category/' . $row["image"] . '" class="card-img-top" alt="' . $row["libelle"] . '">
                      </a>
                      <div class="card-body">
                        <h5 class="card-title">' . $row["libelle"] . '</h5>
                      </div>
                    </div>
                  </div>';
        }
      } else {
        echo "<p>No categories found.</p>";
      }
      ?>
    </div>
    <hr>
    <h2>Plats</h2>
    <hr>
    <div class="row">
      <?php
      // Fetch plats based on search query
      $sql = "SELECT * FROM plat WHERE active = 'Yes'";
      if ($search) {
        $sql .= " AND libelle LIKE '%$search%'";
      }
      $sql .= " LIMIT 3";
      $result = $conn->query($sql);

      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          echo '<div class="col-md-4 mb-4">
                    <div class="card category-card">
                      <a href="plats.php?id=' . $row["id_categorie"] . '">
                        <img src="Images/food/' . $row["image"] . '" class="card-img-top" alt="' . $row["libelle"] . '">
                      </a>
                      <div class="card-body">
                        <h5 class="card-title">' . $row["libelle"] . '</h5>
                      </div>
                    </div>
                  </div>';
        }
      } else {
        echo "<p>No plats found.</p>";
      }
      ?>
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