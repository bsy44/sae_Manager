<?php
include_once 'connexion.php';
require_once 'modules/mod_connexion/mod_connexion.php';
require_once 'modules/mod_enseignant/mod_enseignant.php';
require_once 'modules/mod_etudiant/mod_etudiant.php';
require_once 'modules/mod_admin/mod_admin.php';
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta charset="UTF-8">
        <link href="style/style.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="scripts/script.js" defer></script>
    </head>

    <body>
        <header>
            <nav class="navbar navbar-expand-lg bg-body-tertiary">
                <div class="container-fluid">
                    <a class="navbar-brand" href="#">SAE Manager</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="#">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Features</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Pricing</a>
                            </li>
                        </ul>
                    </div>

                </div>
            </nav>
        </header>

        <main class="w-100">
            <?php
            $connexion = new Connexion();
            $connexion->initConnexion();

            $module = isset($_GET["module"]) ? $_GET["module"] : "mod_connexion";
            switch($module){
                case "mod_admin":
                    new ModAdmin();
                    break;
                case "mod_enseignant":
                    new Modenseignant();
                    break;
                case "mod_etudiant":
                    new Modetudiant();
                    break;
                case "mod_connexion":
                    new modconnexion();
                    break;
            }
            ?>
        </main>

        <footer>
            <div class="align-items-center text-body-secondary text-center p-3">
                <p class="text-white">&copy;2025 | SAE Manager groupe 24</p>
            </div>
        </footer>

    </body>
</html>
