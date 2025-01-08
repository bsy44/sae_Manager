<?php
class modele_etudiant extends connexion {
    
   
    public function getDepotsDisponibles($idProjet) {
        $stmt = self::$bdd->prepare("SELECT * FROM DepotEtudiants WHERE iddepotetudiant = ?");
        $stmt->execute([$idProjet]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    
    public function ajouterDepot($iddepotetudiant, $idEtud, $fichier, $date_depot) {
        $stmt = self::$bdd->prepare("INSERT INTO DepotEtudiants (iddepotetudiant, idEtud, fichier, date_depot) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$iddepotetudiant, $idEtud, $fichier, $date_depot]);
    }
}
?>
