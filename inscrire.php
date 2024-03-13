<?php
//Déterminer si le formulaire a été soumis
//Utilisation d'une variable superglobale
//$_SERVER : tableau associatif contenant des informations sur la requêtes HTTP
$erreurs = [];
$pseudo_utilisateur = "";
$email_utilisateur = "";
$mdp_utilisateur = "";
$mdp_utilisateur2 = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    //Le formulaire a été soumis
    //Traiter les données de formulaire
    //Récupérer les valeur saisie par l'utilisateur
    //Superglobale $_POST : tableau associatif
    $pseudo_utilisateur = $_POST['pseudo_utilisateur'];
    $email_utilisateur = $_POST['email_utilisateur'];
    $mdp_utilisateur = $_POST['mdp_utilisateur'];
    $mdp_utilisateur2 = $_POST['mdp_utilisateur2'];

    //Validation des données
    if (empty($pseudo_utilisateur)) {
        $erreurs['pseudo_utilisateur'] = "Le pseudo_utilisateur est obligatoire";
    }
    if (empty($email_utilisateur)) {
        $erreurs['email_utilisateur'] = "L'email_utilisateur est obligatoire";
    } elseif (!filter_var($email_utilisateur, FILTER_VALIDATE_EMAIL)) {
        $erreurs['email_utilisateur'] = "L'email_utilisateur n'est pas valide";
    }
    if (empty($mdp_utilisateur)) {
        $erreurs['mdp_utilisateur'] = "Le mot de passe est obligatoire";
    }
    if (empty($mdp_utilisateur2)) {
        $erreurs['mdp_utilisateur2'] = "Le mot de passe est obligatoire";
    } elseif ($mdp_utilisateur != $mdp_utilisateur2) {
        $erreurs['mdp_utilisateur'] = "Veuillez saisir deux fois le même mot de passe";
    }
    //Traiter les données
    if (empty($erreurs)) {
        //Traitement des données (insertion dans une base de données)
        //Rediriger l'utilisateur vers une autre page (la page d'accueil)
        header(header: "Location: ../index.php");
        /**
         * @var PDO $pdo
         */
        require "./config/db-config.php";
        $mdp_utilisateur = password_hash($mdp_utilisateur, PASSWORD_ARGON2I);
        $requete = $pdo->prepare(query: "INSERT INTO `utilisateur` (`id_utilisateur`, `pseudo_utilisateur`, `email_utilisateur`, `mdp_utilisateur`) VALUES (NULL, '$pseudo_utilisateur', '$email_utilisateur', '$mdp_utilisateur');");
        $requete->execute();

        exit();
    }
}
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
    <title>S'inscrire</title>
</head>

<body class="bg-secondary">
<h1 class="text-center fw-bold text-white mt-3">
    S'incrire
</h1>
<div class="container">
    <div class="w-50 mx-auto shadow my-5 p-4 bg-dark">
        <form action="" method="POST" novalidate>
            <div class="mb-3">
                <label for="pseudo_utilisateur" class="form-label text-white">pseudo_utilisateur*</label>
                <input
                        type="text"
                        class="form-control <?= isset($erreurs['pseudo_utilisateur']) ? "border border-2 border-danger" : "" ?>"
                        id="pseudo_utilisateur"
                        name="pseudo_utilisateur"
                        value="<?= $pseudo_utilisateur ?>"
                        placeholder="Saisir votre pseudo"
                        aria-describedby="email_Help">
                <?php if (isset($erreurs['pseudo_utilisateur'])) : ?>
                    <p class="form-text text-danger"><?= $erreurs['pseudo_utilisateur'] ?></p>
                <?php endif; ?>

            </div>
            <div class="mb-3">
                <label for="email_utilisateur" class="form-label text-white">email_utilisateur*</label>
                <input
                        type="email"
                        class="form-control <?= isset($erreurs['email_utilisateur']) ? "border border-2 border-danger" : "" ?>"
                        id="email_utilisateur"
                        name="email_utilisateur"
                        value="<?= $email_utilisateur ?>"
                        placeholder="Saisir un email valide"
                        aria-describedby="email_Help">
                <?php if (isset($erreurs['email_utilisateur'])) : ?>
                    <p class="form-text text-danger"><?= $erreurs['email_utilisateur'] ?></p>
                <?php endif; ?>


            </div>
            <div class="mb-3">
                <label for="mdp_utilisateur" class="form-label text-white">mot de passe*</label>
                <input
                        type="password"
                        class="form-control <?= isset($erreurs['mdp_utilisateur']) ? "border border-2 border-danger" : "" ?>"
                        id="mdp_utilisateur"
                        name="mdp_utilisateur"
                        value="<?= $mdp_utilisateur ?>"
                        placeholder="Saisir votre mot de passe"
                        aria-describedby="password_Help">
                <?php if (isset($erreurs['mdp_utilisateur'])) : ?>
                    <p class="form-text text-danger"><?= $erreurs['mdp_utilisateur'] ?></p>
                <?php endif; ?>
            </div>
            <div class="mb-3">
                <label for="mdp_utilisateur2" class="form-label text-white">Confirmer le mot de passe*</label>
                <input
                        type="password"
                        class="form-control <?= isset($erreurs['mdp_utilisateur2']) ? "border border-2 border-danger" : "" ?>"
                        id="mdp_utilisateur2"
                        name="mdp_utilisateur2"
                        value="<?= $mdp_utilisateur ?>"
                        placeholder="Saisir votre mot de passe"
                        aria-describedby="password_Help">
                <?php if (isset($erreurs['mdp_utilisateur2'])) : ?>
                    <p class="form-text text-danger"><?= $erreurs['mdp_utilisateur2'] ?></p>
                <?php endif; ?>
                <div id="email_Help" class="form-text text-white">Ne partager jamais votre mot de passe</div>
            </div>
            <button type="submit" class="btn btn-primary">Valider</button>
        </form>
    </div>
</div>
<script src="./assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>