<?php
namespace App\Controllers;
use Config\Database;
use App\Models\DoctorModel;

class DoctorController {

    public function home() {
        $doctors= DoctorModel::getDoctors();
        require("../app/views/medecins/doctor_list.php");
    }

    public function filterSearch() {
        $doctors= DoctorModel::getDoctorsByFilter();
        require("../app/views/medecins/doctor_list.php");
    }

    public function addDoctor() {
        DoctorModel::addDoctor($_POST);
    }

    public function deleteDoctor(){
        DoctorModel::deleteDoctor();
    }

    public function editDoctor(){
        DoctorModel::editDoctor($_POST);
    }

}