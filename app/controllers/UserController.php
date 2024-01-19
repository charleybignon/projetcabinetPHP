<?php
namespace App\Controllers;
use Config\Database;
use App\Models\{
    UserModel,
    DoctorModel
};

class UserController {

    public function home() {
        $usagers= UserModel::getUsers();
        $doctors = DoctorModel::getDoctors();
        require("../app/views/usagers/user_list.php");
    }

    public function filterSearch() {
        $usagers= UserModel::getUsersByFilter();
        $doctors = DoctorModel::getDoctors();
        require("../app/views/usagers/user_list.php");
    }

    public function addUser() {
        UserModel::addUser($_POST);
    }

    public function deleteUser(){
        UserModel::deleteUser();
    }

    public function editUser(){
        UserModel::editUser($_POST);
    }

}