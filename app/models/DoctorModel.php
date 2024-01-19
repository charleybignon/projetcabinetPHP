<?php
namespace App\Models;
use Config\Database;
use App\Class\Doctor;
use App\Class\Feedback;

class DoctorModel {

    public static function getDoctors() {
        try {
            $doctors = [];
            $res = Database::getInstance()->prepare("SELECT * FROM doctor ORDER BY lastName");
            $res->execute();
            if($res->rowCount() === 0) {
                Feedback::setError("Aucun médecin n'existe");
                return;
            }
            while($doctor = $res->fetch()) {
                $doctors[] = new Doctor($doctor);
            }
            return $doctors;
        } catch (\Exception $e) {
            Feedback::setError("Une erreur s'est produite lors du chargement de la page.");
        } finally {
            if(!empty($res))
                $res->closeCursor();
        }
    }

    public static function getDoctorById($id) {
        try {
            $res = Database::getInstance()->prepare("SELECT * FROM doctor WHERE idDoctor = :idDoctor");
            $res->execute(array("idDoctor" => $id));
            if(!$userData = $res->fetch()){
                Feedback::setError("Aucun médecin n'existe pour cet identifiant");
                return;
            }else{
                $user = new Doctor($userData);
                return $user;
            }
        } catch (\Exception $e) {
            Feedback::setError("Une erreur s'est produite lors du chargement de la page.");
        } finally {
            if(!empty($res))
                $res->closeCursor();
        }
    }

    public static function getDoctorsByFilter() {
        try {
            $doctors = [];
            $sql="SELECT * FROM doctor WHERE 1=1";
            if (!empty($_POST['lastName'])) 
                $sql .= " AND lastName = :lastName";
            if (!empty($_POST['firstName'])) 
                $sql .= " AND firstName = :firstName";
            if (!empty($_POST['gender'])) 
                $sql .= " AND gender = :gender";
            $sql .= " ORDER BY lastName";

            $res = Database::getInstance()->prepare($sql);

            if (!empty($_POST['lastName']))
                $res->bindParam(':lastName', $_POST['lastName']);
            if (!empty($_POST['firstName'])) 
                $res->bindParam(':firstName', $_POST['firstName']);
            if (!empty($_POST['gender'])) 
                $res->bindParam(':gender', $_POST['gender']);

            $res->execute();
            if($res->rowCount() === 0) {
                Feedback::setError("Aucun médecin n'existe pour ce filtrage");
                return;
            }
            while($doctor = $res->fetch()) {
                $doctors[] = new Doctor($doctor);
            }
            return $doctors;
        } catch (\Exception $e) {
            Feedback::setError("Une erreur s'est produite lors du chargement de la page.");
        } finally {
            if(!empty($res))
                $res->closeCursor();
        }
    }

    public static function addDoctor(array $args) {
        try {
            $keys = ["gender", "lastName", "firstName"];
    
            Database::getInstance()
                ->prepare("INSERT INTO doctor (gender, lastName, firstName)
                           VALUES (:gender, :lastName, :firstName)")
                ->execute(array_intersect_key($args, array_flip($keys)));
    
            Feedback::setSuccess("Ajout du médecin enregistré.");
        } catch (\Exception $e) {
            throw $e;
            Feedback::setError("Une erreur s'est produite lors de l'ajout du médecin.");
        }
    }

    public static function deleteDoctor(){
        try {
            Database::getInstance()
                ->prepare("DELETE FROM doctor WHERE idDoctor = :idDoctor")
                ->execute(["idDoctor" => $_POST["idDoctor"]]);
            Feedback::setSuccess("Suppression du médecin enregistrée.");
        } catch (\Exception $e) {
            throw $e;
            Feedback::setError("Une erreur s'est produite lors de la suppression du médecin.");
        }
    }

    public static function editDoctor(array $args) {
        try {
            $keys = ["idDoctor", "gender", "lastName", "firstName"];
    
            Database::getInstance()
                ->prepare("UPDATE doctor
                           SET gender = :gender, lastName = :lastName, firstName = :firstName
                           WHERE idDoctor = :idDoctor;")
                ->execute(array_intersect_key($args, array_flip($keys)));
    
            Feedback::setSuccess("Modification du médecin enregistrée");
        } catch (\Exception $e) {
            throw $e;
            Feedback::setError("Une erreur s'est produite lors de la modification du médecin");
        }
    }


    public static function verifyDispo($idDoctor, $appointmentDate, $startTime, $endTime, $duration) {
        $checkDispo = "SELECT * FROM appointment WHERE idDoctor = :idDoctor AND appointmentDate = :appointmentDate 
                        AND ((UNIX_TIMESTAMP(hour) < :endTime AND UNIX_TIMESTAMP(hour) + TIME_TO_SEC(duration) > :startTime)
                            OR (UNIX_TIMESTAMP(hour) >= :startTime AND UNIX_TIMESTAMP(hour) < :endTime))";
        $res = Database::getInstance()->prepare($checkDispo);
        $res->bindParam(':idDoctor', $idDoctor);
        $res->bindParam(':appointmentDate', $appointmentDate);
        $res->bindParam(':startTime', $startTime);
        $res->bindParam(':endTime', $endTime);
        $res->execute();
    
        return $res->rowCount() !== 0;
    }
    

}