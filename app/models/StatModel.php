<?php
namespace App\Models;
use Config\Database;
use DateTime;


class StatModel {

    //Recuperer les dates et les genres des utilisateurs
    private static function getAllUsers() {
        $db = Database::getInstance();
        $sql = "SELECT birthDay, gender FROM user";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    //calculer leur age
    private static function calculAge($dateNaissance) {
        $dateActuelle = new DateTime();
        $dateNaissance = new DateTime($dateNaissance);
        $difference = $dateActuelle->diff($dateNaissance);
        return $difference->y;
    }
    //fonction pour calculer le nombre d'usage dans une tranche d'age donnée
    private static function countUsersByAgeRange($users, $minAge, $maxAge, $gender) {
        $count = 0;
        foreach ($users as $user) {
            $age = self::calculAge($user->birthDay);
            if ($age >= $minAge && $age < $maxAge && $user->gender == $gender) {
                $count++;
            }
        }
        return $count;
    }
    //Homme de moins de 25 ans
    public static function getUnder25Men(){
        $users = self::getAllUsers();
        return self::countUsersByAgeRange($users, 0, 25, 1);
    }
    //Femme de moins de 25 ans
    public static function getUnder25Women(){
        $users = self::getAllUsers();
        return self::countUsersByAgeRange($users, 0, 25, 2);
    }
    //Homme entre 25 et 50 ans
    public static function getBetween25_50Men(){
        $users = self::getAllUsers();
        return self::countUsersByAgeRange($users, 25, 50, 1);
    }
    //Femme entre 25 et 50 ans
    public static function getBetween25_50Women(){
        $users = self::getAllUsers();
        return self::countUsersByAgeRange($users, 25, 50, 2);
    }
    //Homme de plus de 50 ans
    public static function getOver50Men(){
        $users = self::getAllUsers();
        return self::countUsersByAgeRange($users, 50, PHP_INT_MAX, 1);
    }
    //Femme de plus de 50 ans
    public static function getOver50Women(){
        $users = self::getAllUsers();
        return self::countUsersByAgeRange($users, 50, PHP_INT_MAX, 2);
    }

    public static function getTotalConsultationDurationByDoctor() {
        $db = Database::getInstance();
        $sql = "SELECT idDoctor, SEC_TO_TIME(SUM(TIME_TO_SEC(duration))) as totalDuration 
                FROM appointment 
                WHERE CONCAT(appointmentDate, ' ', hour) <= NOW()
                GROUP BY idDoctor";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function getTotalFutureConsultationDurationByDoctor() {
        $db = Database::getInstance();
        $sql = "SELECT idDoctor, SEC_TO_TIME(SUM(TIME_TO_SEC(duration))) as totalDuration 
                FROM appointment 
                WHERE CONCAT(appointmentDate, ' ', hour) > NOW()
                GROUP BY idDoctor";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
