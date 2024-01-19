<?php
namespace App\Models;
use Config\Database;
use App\Class\Consult;
use App\Class\Feedback;
//model de la consultation
class ConsultModel {
//Recuperer les consultations
    public static function getConsults() {
        try {
            $consults = [];
            $res = Database::getInstance()->prepare("SELECT * FROM appointment ORDER BY appointmentDate DESC");
            $res->execute();
            if($res->rowCount() === 0) {
                Feedback::setError("Aucune consultation n'existe");
                return;
            }
            while($consult = $res->fetch()) {
                $user = UserModel::getUserById($consult->idUser);
                $doctor = DoctorModel::getDoctorById($consult->idDoctor);
                $consults[] = new Consult($consult,$user,$doctor);
            }
            return $consults;
        } catch (\Exception $e) {
            Feedback::setError("Une erreur s'est produite lors du chargement de la page.");
        } finally {
            if(!empty($res))
                $res->closeCursor();
        }
    }
//Recuperer les consultation filtrées
    public static function getConsultsByFilter() {
        try {
            $consults = [];
            $sql="SELECT * FROM appointment WHERE 1=1";
            if (!empty($_POST['appointmentDate'])) 
                $sql .= " AND appointmentDate = :appointmentDate";
            if (!empty($_POST['idDoctor'])) 
                $sql .= " AND idDoctor = :idDoctor";
            $sql .= " ORDER BY appointmentDate";

            $res = Database::getInstance()->prepare($sql);

            if (!empty($_POST['appointmentDate']))
                $res->bindParam(':appointmentDate', $_POST['appointmentDate']);
            if (!empty($_POST['idDoctor'])) 
                $res->bindParam(':idDoctor', $_POST['idDoctor']);

            $res->execute();
            if($res->rowCount() === 0) {
                Feedback::setError("Aucune consultation n'existe pour ce filtrage");
                return;
            }
            while($consult = $res->fetch()) {
                $user = UserModel::getUserById($consult->idUser);
                $doctor = DoctorModel::getDoctorById($consult->idDoctor);
                $consults[] = new Consult($consult,$user,$doctor);
            }
            return $consults;
        } catch (\Exception $e) {
            Feedback::setError("Une erreur s'est produite lors du chargement de la page.");
        } finally {
            if(!empty($res))
                $res->closeCursor();
        }
    }
//Ajouter une consultation
    public static function addConsult(array $args) {
        try {
            $keys = ["appointmentDate", "hour", "idUser", "idDoctor", "duration"];
    
            Database::getInstance()
                ->prepare("INSERT INTO appointment (appointmentDate, hour, idUser, idDoctor, duration)
                           VALUES (:appointmentDate, :hour, :idUser, :idDoctor, :duration)")
                ->execute(array_intersect_key($args, array_flip($keys)));
    
            Feedback::setSuccess("Ajout de la consultation enregistré.");
        } catch (\Exception $e) {
            Feedback::setError("Une erreur s'est produite lors de l'ajout de la consultation.");
        }
    }
//Supprimer une consultation
    public static function deleteConsult(){
        try {
            $args = $_POST;
            $keys = ["idUser", "idDoctor", "appointmentDate", "hour"];
            Database::getInstance()
                ->prepare("DELETE FROM appointment WHERE idUser = :idUser AND idDoctor = :idDoctor AND appointmentDate = :appointmentDate AND hour = :hour")
                ->execute(array_intersect_key($args, array_flip($keys)));
            Feedback::setSuccess("Suppression de la consultation enregistrée.");
        } catch (\Exception $e) {
            throw $e;
            Feedback::setError("Une erreur s'est produite lors de la suppression de la consultation.");
        }
    }

    public static function updateConsult(array $args) {
        try {
            // Assurez-vous que tous les clés nécessaires sont présentes
            $keys = ["appointmentDate", "hour", "idUser", "idDoctor", "newAppointmentDate", "newHour", "newDuration"];
    
            // Préparation de la requête SQL pour mettre à jour la consultation
            $sql = "UPDATE appointment 
                    SET appointmentDate = :newAppointmentDate, 
                        hour = :newHour, 
                        duration = :newDuration
                    WHERE appointmentDate = :appointmentDate 
                    AND hour = :hour 
                    AND idUser = :idUser 
                    AND idDoctor = :idDoctor";
    
            $stmt = Database::getInstance()->prepare($sql);
            $stmt->execute(array_intersect_key($args, array_flip($keys)));
    
            Feedback::setSuccess("Mise à jour de la consultation enregistrée.");
        } catch (\Exception $e) {
            throw $e;
            Feedback::setError("Une erreur s'est produite lors de la mise à jour de la consultation.");
        }
    }
    

}
