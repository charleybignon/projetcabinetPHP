<?php
namespace App\Controllers;
use Config\Database;
use App\Models\ConnexionModel;
use App\Class\Feedback;
//Controller connexion 
class ConnexionController {

    public function login() {
        session_destroy();
        require("../app/views/connexion/connexion.php");
    }

    public function verifLogin() {
        if (isset($_POST['username']) && isset($_POST['password'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];

            if (ConnexionModel::verifyLogin($username, $password)) {
                $_SESSION["login"]="connected";
                header("Location: /accueil");
            } else {
                Feedback::setError("Identifiant ou mot de passe incorrect");
                header("Location: /connexion");
            }
        }
    }

    public function disconnect() {
        session_destroy();
        header("Location: /connexion");
        exit();
    }

}