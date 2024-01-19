<?php
namespace App\Controllers;
use Config\Database;
use App\Models\{
    ConsultModel,
    DoctorModel,
    UserModel
};
use App\Class\Feedback;
//Controller consultation

class ConsultController {

    public function home() {
        $consults= ConsultModel::getConsults();
        $users = UserModel::getUsers();
        $doctors= DoctorModel::getDoctors();
        require("../app/views/consultation/consults.php");
    }
//filtre sur la recherche
    public function filterSearch() {
        $consults= ConsultModel::getConsultsByFilter();
        $users = UserModel::getUsers();
        $doctors = DoctorModel::getDoctors();
        require("../app/views/consultation/consults.php");
    }
//ajout d'une consultation
    public function addConsult(){
        $result= $this->verifConsult();
        switch ($result){
            case 1:
                Feedback::setError("L'heure choisie n'est pas dans la plage horaire du médecin");
                break;
            case 2:
                Feedback::setError("Le créneau dépasse la durée maximale de 2h");
                break;
            case 3:
                Feedback::setError("Le médecin choisi n'est pas disponible à cette date");
                break;
            case 4:
                Feedback::setError("L'usager chosi n'est pas disponible à cette date");
                break;
            case 0:
                ConsultModel::addConsult($_POST);
                break;           
        }
    }

    public function updateConsult() {
        $result= $this->verifConsultUpdate();
        switch ($result){
            case 1:
                Feedback::setError("L'heure choisie n'est pas dans la plage horaire du médecin");
                break;
            case 2:
                Feedback::setError("Le créneau dépasse la durée maximale de 2h");
                break;
            case 3:
                Feedback::setError("Le médecin choisi n'est pas disponible à cette date");
                break;
            case 4:
                Feedback::setError("L'usager chosi n'est pas disponible à cette date");
                break;
            case 0:
                ConsultModel::updateConsult($_POST);
                break;           
        }
    }
//Supression d'une consultation
    public function deleteConsult(){
        ConsultModel::deleteConsult();
    }
//Verification d'une consultation (collision/plages horaires/durée trop longue)
    private function verifConsult(){
        $appointmentTime = $_POST['hour'];
        $hour = (int) date('H', strtotime($appointmentTime));
        if ($hour < 8 || $hour >= 18) {
            // Heure en dehors des plages autorisées
            return 1;
        }
        $duration = $_POST['duration'];
        $durationInSeconds = strtotime($duration) - strtotime('00:00:00');
        if ($durationInSeconds > 7200) {
            // Durée supérieure à 2 heures
            return 2;
        }
        $startTime = strtotime($appointmentTime);
        $endTime = $startTime + $durationInSeconds;
        if (DoctorModel::verifyDispo($_POST["idDoctor"], $_POST["appointmentDate"], $startTime, $endTime, $duration)){
            // Le médecin a déjà un rendez-vous à la même date et heure
            return 3;
        }
        if (UserModel::verifyDispoUser($_POST["idUser"], $_POST["appointmentDate"], $startTime, $endTime, $duration)){
            // L'usager a déjà un rendez-vous à la même date et heure
            return 4;
        }
        return 0;
    }

    private function verifConsultUpdate(){
        $appointmentTime = $_POST['newHour'];
        $hour = (int) date('H', strtotime($appointmentTime));
        if ($hour < 8 || $hour >= 18) {
            // Heure en dehors des plages autorisées
            return 1;
        }
        $duration = $_POST['newDuration'];
        $durationInSeconds = strtotime($duration) - strtotime('00:00:00');
        if ($durationInSeconds > 7200) {
            // Durée supérieure à 2 heures
            return 2;
        }
        $startTime = strtotime($appointmentTime);
        $endTime = $startTime + $durationInSeconds;
        if (DoctorModel::verifyDispo($_POST["idDoctor"], $_POST["newAppointmentDate"], $startTime, $endTime, $duration)&& ($_POST["newDuration"] == $_POST["duration"] )){
            // Le médecin a déjà un rendez-vous à la même date et heure
            return 3;
        }
        if (UserModel::verifyDispoUser($_POST["idUser"], $_POST["newAppointmentDate"], $startTime, $endTime, $duration)&& ($_POST["newDuration"] == $_POST["duration"] )){
            // L'usager a déjà un rendez-vous à la même date et heure
            return 4;
        }
        return 0;
    }


}