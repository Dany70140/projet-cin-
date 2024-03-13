<?php
// Récupérer la liste des films dans la table film

// 1. Connexion à la base de donnée db_cinema
/**
 * @var PDO $pdo
 */
require './config/db-config.php';

// 2. Préparation de la requête
$requete = $pdo->prepare(query: "SELECT * FROM film");

// 3. Exécution de la requête
$requete->execute();

// 4. Récupération des enregistrements
// Un enregistrement = un tableau associatif
$films = $requete->fetchAll(PDO::FETCH_ASSOC);
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="./assets/css/bootstrap.min.css">
    <link rel="stylesheet" href=" https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        section {
            padding: 60px 0;
        }
    </style>
    <title>Accueil</title>
</head>
<body class="bg-secondary">
<nav class="navbar navbar-expand-md bg-white">
    <div class="container-fluid">
        <a href="#accueil">
            <i class="bi bi-house border border-1 border-black mx-3 px-2 py-1 btn btn-dark fs-3"></i>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end"
             id="navbarSupportedContent">
            <ul class="navbar-nav mb-2 mb-lg-0">
                <li class="nav-item">
                    <a href="connexion.php">
                        <button class="btn btn-outline-dark">Connexion</button>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="inscrire.php">
                        <button class="btn btn-outline-dark">Inscription</button>
                    </a>
                </li>

            </ul>
        </div>
    </div>
</nav>

<section id="accueil">
    <h1 class="text-center fw-bold text-white mt-3">
        Cinéma
    </h1>
    <div class="d-flex mt-2">
        <div class=" rounded-4 p-3 flex-fill">
            <div class="container ">
                <!-- Votre code -->
                <div class="row text-center  ">
                    <?php foreach ($films as $film) : ?>
                        <div class="card border-success border-2 mb-3 me-2" style="max-width: 20rem;">
                            <div class="card-body bg-white">
                                <h4 class="card-title bg-dark"><img src="<?= $film["image_film"] ?>" alt=""</h4>
                                <p class="card-text"><?= $film["titre_film"] ?></p>
                                <p> <?= $film["duree_film"] . " minutes" ?></p>
                                <p class="card-text">
                                    <a class="btn btn-secondary border border-2 border-success p-2 mb-5" role="button"
                                       href="recup-param.php?id_film=<?= $film['id_film'] ?>">Détails du film</a></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="./assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>