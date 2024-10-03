<!DOCTYPE html>
<html lang="en">

<head>
    <title>Les Plats</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
        .category-card img {
            width: 100%;
            height: 200px; /* Set a consistent height */
            object-fit: cover; /* Ensure the image covers the area without distortion */
        }
    </style>
</head>

<body class="bg-danger">

    <nav class="navbar navbar-expand-sm bg-danger navbar-dark fixed-top" >
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
                        <a class="nav-link" href="index.php">Accueil</a>
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
        <img src="Images/ibg.jpg" alt="Background Image" style="height: 750px;">
    </div>

    <main class="container my-5">
        <h2>Les Plats</h2>
        <hr>
        <div class="row">
            <?php
            include 'db_connect.php';

            // Fetch active dishes and their categories
            $sql = "SELECT p.id, p.libelle, p.description, p.prix, p.image, c.libelle AS category
                    FROM plat p
                    JOIN categorie c ON p.id_categorie = c.id
                    WHERE p.active = 'Yes'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="col-md-4 mb-4">
                            <div class="card category-card">
                                <img src="Images/food/' . $row["image"] . '" class="card-img-top" alt="' . $row["libelle"] . '">
                                <div class="card-body">
                                    <h5 class="card-title">' . $row["libelle"] . '</h5>
                                    <p class="card-text">' . $row["description"] . '</p>
                                    <p class="card-text"><strong>Price: </strong>' . $row["prix"] . ' €</p>
                                    <p class="card-text"><strong>Category: </strong>' . $row["category"] . '</p>
                                    <a href="commande.php?id=' . $row["id"] . '&name=' . urlencode($row["libelle"]) . '&image=' . urlencode($row["image"]) . '&price=' . $row["prix"] . '" class="btn btn-primary mt-2">Commander</a>
                                </div>
                            </div>
                          </div>';
                }
            } else {
                echo "<p>No plats available.</p>";
            }

            $conn->close();
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
