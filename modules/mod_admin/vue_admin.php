<?php
class vue_admin{

    public function formualire() {
        echo '
            <form action="index.php?module=mod_connexion&action=deconnexion" method="POST">
            <input type="submit" value="Se déconnecter">
            </form>
            <form action="index.php?module=mod_admin&action=ajoutEns" method="POST">
                <h3>Enseignant</h3>
                <table>
                    <tr>
                        <td>Prénom :</td><td><input type="text" name="prenom" required></td>
                        <td>Nom :</td><td><input type="text" name="nom" required></td>
                        <td>Login :</td><td><input type="text" name="login" required></td>
                        <td>Mot de passe :</td><td><input type="password" name="password" required></td>
                        <td><input type="submit" value="Ajouter"></td>
                    </tr>
                </table>
            </form>
            <form action="index.php?module=mod_admin&action=ajoutEtu" method="POST">
                <h3>Etudiant</h3>
                <table>
                    <tr>
                        <td>Prénom :</td><td><input type="text" name="prenom" required></td>
                        <td>Nom :</td><td><input type="text" name="nom" required></td>
                        <td>Semestre :</td><td><input type="text" name="semestre" required></td>
                        <td>Login :</td><td><input type="text" name="login" required></td>
                        <td>Mot de passe :</td><td><input type="password" name="password" required></td>
                        <td><input type="submit" value="Ajouter"></td>
                    </tr>
                </table>
            </form>
            
        ';
    }
}
?>