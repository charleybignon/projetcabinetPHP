<?php
require_once("../vendor/autoload.php");

use App\Controllers\{
    UserController,
    ConnexionController,
    DoctorController,
    ConsultController,
    StatsController
};
session_start();

if(!in_array($_SERVER["REQUEST_URI"], ["/connexion"])) {
    if(!isset($_SESSION["login"])) {
        header("Location: /connexion");
        exit();
    }
}
$router = new AltoRouter();
//$router->setBasePath("/public");

/*######################################################################################
                                      CONNECTION
#######################################################################################*/
$router->map("GET", "/connexion", function () {
    $controller = new ConnexionController();
    $controller->login();
});
$router->map("POST", "/connexion", function () {
    $controller = new ConnexionController();
    if(isset($_POST["action"])) {
        switch($_POST["action"]) {
            case "verifLogin":
                $controller->verifLogin();
                break;
            case "disconnect":
                $controller->disconnect();
                break;
        }
    }
     else {
        $controller->login();
     }
});
$router->map("GET", "/disconnect", function() {
    $controller = new ConnexionController();
    $controller->disconnect();
});

/*######################################################################################
                                      USAGER
#######################################################################################*/

$router->map("GET", "/accueil", function () {
    $controller = new UserController();
    $controller->home();
});
$router->map("POST", "/accueil", function () {
    $controller = new UserController();
    if(isset($_POST["action"])) {
        switch($_POST["action"]) {
            case "filter":
                $controller->filterSearch();
                break;
            case "addUser":
                $controller->addUser();
                header("Location: " . $_SERVER["REQUEST_URI"]);
                break;
            case "deleteUser":
                $controller->deleteUser();
                header("Location: " . $_SERVER["REQUEST_URI"]);
                break;
            case "editUser":
                $controller->editUser();
                header("Location: " . $_SERVER["REQUEST_URI"]);
                break;
        }
    }
     else {
        $controller->login();
     }
});


/*######################################################################################
                                      DOCTEUR
#######################################################################################*/

$router->map("GET", "/medecins", function () {
    $controller = new DoctorController();
    $controller->home();
});

$router->map("POST", "/medecins", function () {
    $controller = new DoctorController();
    if(isset($_POST["action"])) {
        switch($_POST["action"]) {
            case "filter":
                $controller->filterSearch();
                break;
            case "addDoctor":
                $controller->addDoctor();
                header("Location: " . $_SERVER["REQUEST_URI"]);
                break;
            case "deleteDoctor":
                $controller->deleteDoctor();
                header("Location: " . $_SERVER["REQUEST_URI"]);
                break;
            case "editDoctor":
                $controller->editDoctor();
                header("Location: " . $_SERVER["REQUEST_URI"]);
                break;
        }

    } else {
        $controller->login();
    }
});

/*######################################################################################
                                      CONSULTATIONS
#######################################################################################*/

$router->map("GET", "/consultations", function () {
    $controller = new ConsultController();
    $controller->home();
});

$router->map("POST", "/consultations", function () {
    $controller = new ConsultController();
    if(isset($_POST["action"])) {
        switch($_POST["action"]) {
            case "filter":
                $controller->filterSearch();
                break;
            case "addConsult":
                $controller->addConsult();
                header("Location: " . $_SERVER["REQUEST_URI"]);
                break;
            case "deleteConsult":
                $controller->deleteConsult();
                header("Location: " . $_SERVER["REQUEST_URI"]);
                break;
            case "updateConsult":
                $controller->updateConsult();
                header("Location: " . $_SERVER["REQUEST_URI"]);
                break;
        }

    } else {
        $controller->login();
    }
});

/*######################################################################################
                                      STATISTIQUES
#######################################################################################*/

$router->map("GET", "/statistiques", function () {
    $controller = new StatsController();
    $controller->home();
});


$match = $router->match();
if($match != null) {
    call_user_func_array($match['target'], $match['params']);
} else {
    echo "error 404";
}