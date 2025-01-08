<?php
class modele_etudiant extends connexion{
    public function getDepotsActifs() {
        $query = "SELECT * FROM depots WHERE date_limite >= CURDATE()";
        $stmt = self::$bdd->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function deposerFichier($depotId, $etudiantId, $filePath) {
        $query = "INSERT INTO depot_etudiants (depot_id, etudiant_id, fichier, date_depot) 
                  VALUES (:depot_id, :etudiant_id, :fichier, NOW())";
        $stmt = self::$bdd->prepare($query);
        $stmt->execute([
            'depot_id' => $depotId,
            'etudiant_id' => $etudiantId,
            'fichier' => $filePath
        ]);
        return $stmt->rowCount() > 0;
    }

}

?>
