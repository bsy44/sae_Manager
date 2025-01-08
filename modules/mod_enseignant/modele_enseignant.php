
<?php
class modele_enseignant extends connexion {


    public function getProjetsEnseignant($enseignantId) {
        $query = "SELECT * FROM projets WHERE createur_id = :enseignant_id";
        $stmt = self::$bdd->prepare($query);
        $stmt->execute(['enseignant_id' => $enseignantId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function getGroupeProposer($enseignantId) {
        $query = "SELECT * FROM groupes WHERE statut = 'proposé' AND enseignant_id = :enseignant_id";
        $stmt = self::$bdd->prepare($query);
        $stmt->execute(['enseignant_id' => $enseignantId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function validerGroupe($groupeId) {
        $query = "UPDATE groupes SET statut = 'validé' WHERE id_groupe = :groupe_id";
        $stmt = self::$bdd->prepare($query);
        $stmt->execute(['groupe_id' => $groupeId]);
        return $stmt->rowCount() > 0;
    }


    public function ajouterEnseignantAuProjet($projetId, $enseignantId) {
        $query = "INSERT INTO enseignants_projets (projet_id, enseignant_id) VALUES (:projet_id, :enseignant_id)";
        $stmt = self::$bdd->prepare($query);
        $stmt->execute(['projet_id' => $projetId, 'enseignant_id' => $enseignantId]);
        return $stmt->rowCount() > 0;
    }

    public function getEtudiantsSansGroupe($projetId) {
        $query = "SELECT e.id, e.nom, e.prenom 
                  FROM etudiants e
                  WHERE e.id NOT IN (
                      SELECT etudiant_id 
                      FROM etudiants_groupes eg
                      JOIN groupes g ON eg.groupe_id = g.id_groupe
                      WHERE g.projet_id = :projet_id
                  )";
        $stmt = self::$bdd->prepare($query);
        $stmt->execute(['projet_id' => $projetId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


}
?>
