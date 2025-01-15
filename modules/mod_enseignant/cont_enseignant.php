<?php
include_once 'modele_enseignant.php';
include_once 'vue_enseignant.php';

class Cont_enseignant{
    private $vue_enseignant;
    private $modele_enseignant;
    private $action;
    public function __construct(){
        $this->vue_enseignant = new vue_enseignant();    
        $this->modele_enseignant = new modele_enseignant();
        $this->action =  isset($_GET['action'])?  $_GET['action'] : "Bienvenue";
        
        if (isset($_GET['idprojet'])) {
            $_SESSION['idProjet'] = $_GET['idprojet'];
        }
    }
    public function acceuil(){
        $this->vue_enseignant->acceuil();

    }

    public function exec(){
        switch($this->action){
            case "Bienvenue":
                $this->acceuil();
                break;
            case "btnajoutsae":
                $this->vue_enseignant->formulaireAjoutSAE(); // N'appelle pas `acceuil()` ici
                break;
            case "ajoutsae":
                $this->ajouterSAE();
                break;
            case "consultsae":
                $this->detailsSae();
                break;
            case "btnajoutdepot":
                $this->vue_enseignant->formulaireAjoutdepot();
                break;
            case "btnajoutressource":
                $this->vue_enseignant->formulaireAjoutresource();
                break;
            case "btnajoutintervenant":
                $this->vue_enseignant->affichelisteIntervenant($this->modele_enseignant->getlisteintervenant($_SESSION['idProjet']));
                $this->vue_enseignant->formulaireAjoutIntervenant($this->modele_enseignant->getlistenseignantNonIntervenant($_SESSION['idProjet']));
                break;
            case "ajoutressource":
                $this->ajoutRessource();
                break;
            case "ajoutdepot":
                $this->ajoutDepot();
                break;
            case "ajoutIntervenant":
                $this->ajoutIntervenant();
                break;
            case "validationGroupe":
                $this->modele_enseignant->validationGroupe();
                break;
            case "supprimerSae":
                $this->supprimerSae();
                break;
        }
    }

    public function getIdEns(){
        return $this->modele_enseignant->idEns($_SESSION['login']);
    }

    public function ajouterSAE() {
        $intitule = isset($_POST['intitule']) ? htmlspecialchars($_POST['intitule']) : exit;
        $dateDebut = isset($_POST['DateDebut']) ? htmlspecialchars($_POST['DateDebut']) : null;
        $dateFin = isset($_POST['DateFin']) ? htmlspecialchars($_POST['DateFin']) : null;
        $description = isset($_POST['description']) ? htmlspecialchars($_POST['description']) : null;
        $lien = isset($_POST['lien']) ? htmlspecialchars($_POST['lien']) : null;
        $annee = isset($_POST['annee']) ? htmlspecialchars($_POST['annee']) : null;
        $semestre = isset($_POST['semestre']) ? htmlspecialchars($_POST['semestre']) : null;
        $idEns = $this->getIdEns();


        if (!is_numeric($annee) || !is_numeric($semestre)) {
            echo "Erreur : Année et semestre doivent être des nombres.";
            return;
        }

        if ($dateDebut > $dateFin) {
            echo 'Erreur : La date de début ne peut pas être après la date de fin.';
            return;
        }

        if ($this->modele_enseignant->ajouterSAE($intitule, $dateDebut, $dateFin, $description, $lien, $annee, $semestre, $idEns)) {
            $this->acceuil();
        } else {
            echo 'Erreur : Impossible d\'ajouter la SAE.';
        }
    }

    public function supprimerSae()
    {
        $idProjet = isset($_POST['idProjet']) ? intval($_POST['idProjet']) : null;

        if ($idProjet && $this->modele_enseignant->supprimerSae($idProjet)) {
            echo '<div class="alert-success">SAE supprimée !</div>';
            $this->acceuil();
        } else {
            echo '<div class="alert-danger">Erreur lors de la suppression de la SAE</div>';
            $this->detailsSae();
        }

    }



//    public function detailsSae(){
//        if ($this->modele_enseignant->peutModifier($this->getIdEns(), $_SESSION['idProjet'])){
//            $this->vue_enseignant->outilsAjout();
//        }
//        $this->vue_enseignant->listeressource($this->modele_enseignant-> getRessource($_SESSION['idProjet']));
//        $this->vue_enseignant->listeDepot($this->modele_enseignant-> getDepot($_SESSION['idProjet']));
//
//
//    }

    public function detailsSae() {

        if (!isset($_SESSION['idProjet'])) {
            echo '<div class="alert-danger">Aucune SAE sélectionnée</div>';
            $this->acceuil();
            return;
        }
        $idProjet = $_SESSION['idProjet'];
        $ressources = $this->modele_enseignant->getRessource($idProjet);
        $depots = $this->modele_enseignant->getDepot($idProjet);
        $this->vue_enseignant->detailsSae($ressources, $depots);
    }


    public function ajoutDepot(){
        $nomDepot = isset($_POST['nomDepot']) ? htmlspecialchars($_POST['nomDepot']) : exit;
        $datepublication = isset($_POST['DatePubli']) ? htmlspecialchars($_POST['DatePubli']) : null;
        $datelimite = isset($_POST['DateLimi']) ? htmlspecialchars($_POST['DateLimi']) : null;
        $description = isset($_POST['descriptionDepot']) ? htmlspecialchars($_POST['descriptionDepot']) : null;
        if($datepublication>$datelimite){
            echo 'Date de fin ne peut pas être avant la date deébut';
            $this->vue_enseignant->formulaireAjoutdepot();
        }
        else if ($this->modele_enseignant->ajoutDepot($_SESSION['idProjet'], $nomDepot, $datepublication, $datelimite, $description)){
            $this->detailsSae();
        }
        else{
            $this->vue_enseignant->formulaireAjoutdepot();
        }
        
    }
    public function ajoutRessource(){
        $nomRessource = isset($_POST['nomRessource']) ? htmlspecialchars($_POST['nomRessource']) : exit;
        $lienRessource = isset($_POST['lienRessource']) ? htmlspecialchars($_POST['lienRessource']) : null;
        
        if ($this->modele_enseignant->ajoutRessource($_SESSION['idProjet'], $nomRessource, $lienRessource)){
            $this->detailsSae();
        }
        else{
            $this->vue_enseignant->formulaireAjoutresource();
        }
    }

    public function ajoutIntervenant(){
        $idens = isset($_POST['idens']) ? htmlspecialchars($_POST['idens']) : null;
        if(!empty($idens) && $this->modele_enseignant->ajoutIntervenant($idens, $_SESSION['idProjet'])){
            $this->detailsSae();
        }
        else{
            $this->vue_enseignant->affichelisteIntervenant($this->modele_enseignant->getlisteintervenant($_SESSION['idProjet']));
            $this->vue_enseignant->formulaireAjoutIntervenant($this->modele_enseignant->getlistenseignantNonIntervenant($_SESSION['idProjet']));
        }
    }
    
}
?>