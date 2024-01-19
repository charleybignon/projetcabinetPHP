<?php
namespace App\Models;
use Config\Database;
use App\Class\User;
use App\Class\Feedback;

class ConnexionModel {

    public static function verifyLogin($username, $password) {
        // Connexion à la base de données
        $db = Database::getInstance();

        // Préparation de la requête
        $sql = "SELECT * FROM CONNEXION WHERE login = :username AND pwd = :password";
        $stmt = $db->prepare($sql);

        // Liaison des paramètres
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);

        // Exécution de la requête
        $stmt->execute();

        // Vérification si un enregistrement a été trouvé
        if ($stmt->rowCount() > 0) {
            // Utilisateur trouvé
            return true;
        } else {
            // Utilisateur non trouvé
            return false;
        }
    }


}