<?php
include_once 'connexion.php';
require_once 'modules/mod_connexion/mod_connexion.php';
require_once 'modules/mod_enseignant/mod_enseignant.php';
require_once 'modules/mod_etudiant/mod_etudiant.php';
require_once 'modules/mod_admin/mod_admin.php';

$module = isset($_GET["module"]) ? $_GET["module"] : "mod_connexion";
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8">
    <link href="style/LoginPage.css" rel="stylesheet">
    <link href="style/enseignantAcceuil.css" rel="stylesheet">
    <link href="style/PageAjoutSae.css" rel="stylesheet">
    <link href="style/PageDetailSae.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="scripts/script.js" defer></script>
</head>

<body class="<?php echo ($module === 'mod_connexion') ? 'page-connexion' : ''; ?>">
<?php if ($module === 'mod_connexion'): ?>
    <div class="text-center mt-4">
        <h1 id="main-title">Bienvenue sur SAÉ Manager</h1>
    </div>
<?php endif; ?>

<main>
    <?php
    $connexion = new Connexion();
    $connexion->initConnexion();

    switch ($module) {
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

<footer class="py-1 bottom-0 w-30">
    <div class="text-body-secondary text-center">
        <p class="text-white">&copy;2025 | SAE Manager groupe 14</p>
    </div>
</footer>
</body>
</html>
