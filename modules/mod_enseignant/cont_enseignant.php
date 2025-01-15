<?php
include_once 'modele_enseignant.php';
include_once 'vue_enseignant.php';

class Cont_enseignant{
    private $vue_enseignant;
    private $modele_enseignant;
    private $action;
    private $idProjet;
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
        $this->vue_enseignant->affichelisteSAE("En cours", $this->modele_enseignant->getlisteSAEencours($_SESSION['login']));
        $this->vue_enseignant->affichelisteSAE("A Venir", $this->modele_enseignant->getlisteSAEavenir($_SESSION['login']));
        $this->vue_enseignant->affichelisteSAE("Terminé", $this->modele_enseignant->getlisteSAEtermine($_SESSION['login']));
    }

    public function exec(){
       
        switch($this->action){
            case "Bienvenue";
                $this->acceuil();
                break;
            case "btnajoutsae":
                $this->acceuil();
                $this->vue_enseignant->formulaireAjoutSAE();
                break;
            case "ajoutsae":
                $this->ajoutersae();
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
        }
    }

    public function getIdEns(){
        return $this->modele_enseignant->idEns($_SESSION['login']);
    }

    public function ajouterSAE(){
        $intitule = isset($_POST['intitule']) ? htmlspecialchars($_POST['intitule']) : exit;
        $dateDebut = isset($_POST['DateDebut']) ? htmlspecialchars($_POST['DateDebut']) : null;
        $dateFin = isset($_POST['DateFin']) ? htmlspecialchars($_POST['DateFin']) : null;
        $description = isset($_POST['description']) ? htmlspecialchars($_POST['description']) : null;
        $lien = isset($_POST['lien']) ? htmlspecialchars($_POST['lien']) : null;
        $annee = isset($_POST['annee']) ? htmlspecialchars($_POST['annee']) : null;
        $semestre = isset($_POST['semestre']) ? htmlspecialchars($_POST['semestre']) : null;
        $idEns = $this->getIdEns();

        if($dateDebut>$dateFin){
           echo 'Date de fin ne peut pas être avant la date deébut';
           $this->vue_enseignant->formulaireAjoutSAE();
        }
        else if ($this->modele_enseignant->ajouterSAE($intitule, $dateDebut,$dateFin, $description, $lien, $annee, $semestre, $idEns)){
            $this->acceuil();
        }
        else{
            $this->vue_enseignant->formulaireAjoutSAE();
        }
            
    }
    
    public function detailsSae(){
        if ($this->modele_enseignant->peutModifier($this->getIdEns(), $_SESSION['idProjet'])){
            $this->vue_enseignant->outilsAjout();
        }
        $this->vue_enseignant->listeressource($this->modele_enseignant-> getRessource($_SESSION['idProjet']));
        $this->vue_enseignant->listeDepot($this->modele_enseignant-> getDepot($_SESSION['idProjet']));
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
}
?>