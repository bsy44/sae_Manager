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
                $this->vue_enseignant->formulaireAjoutSAE($this->modele_enseignant->getListeSemestre(), $this->modele_enseignant->getListeEnseignant($_SESSION['login']));
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
            case "groupeTemporaire":
                $this->ConsulterGroupeEnAttente();
                break;
            case "detailGroupe":
                $this->detailGroupe();
                break;
            case "validationGroupe":
                $this->validationGroupe();
                break;
            case "supprimerSae":
                $this->supprimerSae();
                break;
            case "supInterveanant":
                $this->supprimerIntervenant();
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
        $semestre = isset($_POST['semestre']) ? htmlspecialchars($_POST['semestre']) : null;
        $coReposable = isset($_POST['coresposable']) ? htmlspecialchars($_POST['coresposable']) : null;
        $idEns = $this->getIdEns();

        if($dateDebut>$dateFin){
           echo 'Date de fin ne peut pas être avant la date deébut';
           $this->vue_enseignant->formulaireAjoutSAE($this->modele_enseignant->getListeSemestre(), $this->modele_enseignant->getListeEnseignant($_SESSION['login']));
        }
        else if ($this->modele_enseignant->ajouterSAE($intitule, $dateDebut,$dateFin, $description, $lien, $semestre, $idEns, $coReposable) ){
            $this->acceuil();
        } 
        else{
            $this->vue_enseignant->formulaireAjoutSAE($this->modele_enseignant->getListeSemestre(), $this->modele_enseignant->getListeEnseignant($_SESSION['login']));
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
       if ($this->modele_enseignant->peutModifier($this->getIdEns(), $_SESSION['idProjet'])){
           $this->vue_enseignant->outilsAjout();
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
            return ;
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
        if(!empty($idens)){
            $this->modele_enseignant->ajoutIntervenant($idens, $_SESSION['idProjet']);
        }
        
        $this->vue_enseignant->affichelisteIntervenant($this->modele_enseignant->getlisteintervenant($_SESSION['idProjet']));
        $this->vue_enseignant->formulaireAjoutIntervenant($this->modele_enseignant->getlistenseignantNonIntervenant($_SESSION['idProjet']));
        
    }

    public function ConsulterGroupeEnAttente() {
        $groupes = $this->modele_enseignant->getGroupePropose($_SESSION['idProjet']);
        $this->vue_enseignant->consulterGroupeProposer($groupes);
    }

    public function detailGroupe(){
        $detail = $this->modele_enseignant->detailEleve($_GET['id']);
        $this->vue_enseignant->afficheDetail($detail);
    }

    public function validationGroupe() {
        if (isset($_POST['action'], $_POST['idGroupe'], $_POST['idProjet'], $_POST['idEtudiants'])) {
            $action = htmlspecialchars($_POST['action']);
            $idGroupe = htmlspecialchars($_POST['idGroupe']);
            $idProjet = htmlspecialchars($_POST['idProjet']);
            $etudiants = $_POST['idEtudiants'];

            if ($action === "Accepter groupe") {
                echo "Groupe accepté avec les étudiants : " . implode(", ", $etudiants);
                foreach ($etudiants as $idEtudiant) {
                    $idEtudiant = htmlspecialchars($idEtudiant);
                    $this->modele_enseignant->insertionFinaleGroupe($idGroupe, $idEtudiant, $idProjet);
                    $this->modele_enseignant->supprimerGroupeTemporaire($idGroupe, $idEtudiant,$idProjet);
                    
                }
            } else if ($action === "Refuser groupe") {
                echo "Groupe refusé";
                foreach($etudiants as $idEtudiant){
                    $this->modele_enseignant->supprimerGroupeTemporaire($idGroupe, $idEtudiant, $idProjet);
                }
            }
        } else {
            echo "Erreur lors de l'envoie du formulaire.";
        }
    }

    public function supprimerIntervenant(){
        $idEns = isset($_POST['idEns']) ? htmlspecialchars($_POST['idEns']) : null;
        if(!empty($idEns)){
            $this->modele_enseignant->supprimerIntervenant($idEns, $_SESSION['idProjet']);
        }
        $this->vue_enseignant->affichelisteIntervenant($this->modele_enseignant->getlisteintervenant($_SESSION['idProjet']));
        $this->vue_enseignant->formulaireAjoutIntervenant($this->modele_enseignant->getlistenseignantNonIntervenant($_SESSION['idProjet']));
    }
}
?>