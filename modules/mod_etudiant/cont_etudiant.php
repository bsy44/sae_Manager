
<?php
include_once 'modele_etudiant.php';
include_once 'vue_etudiant.php';

class Cont_etudiant {
    private $vue_etudiant;
    private $modele_etudiant;

    public function __construct() {
        $this->vue_etudiant = new vue_etudiant();
        $this->modele_etudiant = new modele_etudiant();
    }

    public function exec() {
        session_start();
        $etudiantId = $_SESSION['user_id'] ?? null;

        if (!$etudiantId) {
            die("Erreur : Vous devez être connecté pour accéder à cette fonctionnalité.");
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['depot_id']) && isset($_FILES['fichier'])) {

            $this->deposerFichier($etudiantId, $_POST['depot_id'], $_FILES['fichier']);
        } else {
            $this->afficherDepotsActifs();
        }
    }

    private function afficherDepotsActifs() {
        $depots = $this->modele_etudiant->getDepotsActifs();
        $this->vue_etudiant->afficherDepots($depots);
    }

    private function deposerFichier($etudiantId, $depotId, $file) {
        $uploadDir = '../uploads/';
        $filePath = $uploadDir . basename($file['name']);


        if (move_uploaded_file($file['tmp_name'], $filePath)) {
            $success = $this->modele_etudiant->deposerFichier($depotId, $etudiantId, $filePath);
            if ($success) {
                echo "<p>Fichier déposé avec succès.</p>";
            } else {
                echo "<p>Erreur lors de l'enregistrement du fichier en base de données.</p>";
            }
        } else {
            echo "<p>Erreur lors du téléchargement du fichier.</p>";
        }
    }
}
?>
