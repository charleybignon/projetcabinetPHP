<?php
namespace App\Controllers;
use Config\Database;
use App\Models\{
    UserModel,
    StatModel,
    DoctorModel
};
//controller sur les statistiques
class StatsController {

    public function home() {
        $MUnder25 = StatModel::getUnder25Men();
        $WUnder25 = StatModel::getUnder25Women();
        $MBetween25_50 = StatModel::getBetween25_50Men();
        $WBetween25_50 = StatModel::getBetween25_50Women();
        $MOver50 = StatModel::getOver50Men();
        $WOver50 = StatModel::getOver50Women();
        $ConsultationTimes = StatModel::getTotalConsultationDurationByDoctor();
        $ConsultationFutureTimes= StatModel::getTotalFutureConsultationDurationByDoctor();
        $doctors= DoctorModel::getDoctors();
        require("../app/views/statistiques/stats.php");
    }


}