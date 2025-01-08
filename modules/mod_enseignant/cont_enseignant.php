
<?php
include_once 'modele_enseignant.php';
include_once 'vue_enseignant.php';

class Cont_enseignant {
    private $vue_enseignant;
    private $modele_enseignant;
    private $action;

    public function __construct() {
        $this->vue_enseignant = new vue_enseignant();
        $this->modele_enseignant = new modele_enseignant();
        $this->action = isset($_GET['action']) ? $_GET['action'] : "Bienvenue";
    }

    public function afficher() {
        $this->vue_enseignant->formulaire();
    }

    public function exec() {
        session_start();
        $enseignantId = $_SESSION['user_id'] ?? null;

        if (!$enseignantId) {
            die("Erreur : Vous devez être connecté pour accéder à cette fonctionnalité.");
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['groupe_id'])) {
                $this->validerGroupe($_POST['groupe_id']);
            } elseif (isset($_POST['projet_id'], $_POST['enseignant_id'])) {
                $this->ajouterEnseignantAuProjet($_POST['projet_id'], $_POST['enseignant_id']);
            }
        } else {
            $this->groupeProposer($enseignantId);
        }
    }

    public function validerGroupe($groupeId) {
        $success = $this->modele_enseignant->validerGroupe($groupeId);
        if ($success) {
            echo "<p>Groupe validé avec succès.</p>";
        } else {
            echo "<p>Échec de la validation du groupe.</p>";
        }
    }

    public function groupeProposer($enseignantId) {
        $groupes = $this->modele_enseignant->getGroupeProposer($enseignantId);
        $this->vue_enseignant->afficherGroupes($groupes);
    }

    public function ajouterEnseignantAuProjet($projetId, $enseignantId) {
        $success = $this->modele_enseignant->ajouterEnseignantAuProjet($projetId, $enseignantId);
        if ($success) {
            echo "<p>Enseignant ajouté avec succès au projet.</p>";
        } else {
            echo "<p>Erreur lors de l'ajout de l'enseignant au projet.</p>";
        }
    }

    public function afficherEtudiantsSansGroupe($projetId) {
        $etudiants = $this->modele_enseignant->getEtudiantsSansGroupe($projetId);
        $this->vue_enseignant->afficherEtudiantsSansGroupe($etudiants);
    }
}
?>
