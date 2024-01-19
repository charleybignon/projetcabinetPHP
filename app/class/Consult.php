<?php
namespace App\Class;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
//Classe consultation
class Consult {

    public $appointmentDate;
    public $hour;
    public $user;
    public $doctor;
    public $duration;

    public function __construct(object $obj, object $user, object $doctor) {
        $this->appointmentDate =  $obj->appointmentDate;
        $this->hour = $obj->hour;
        $this->duration = $obj->duration;
        $this->user = $user;
        $this->doctor = $doctor;
    }

    public function setTabLine(){
        ob_start(); ?>
        <tr>
            <td><?= date('d/m/Y', strtotime($this->appointmentDate)) ?></td>
            <td><?= date('H:i', strtotime($this->hour)) ?></td>
            <td><?= date('H:i', strtotime($this->duration)) ?></td>
            <td><?=  strtoupper($this->user->lastName) ?> <?= $this->user->firstName ?></td>
            <td><?=  strtoupper($this->doctor->lastName) ?> <?= $this->doctor->firstName ?></td>
            <td>

                <form action="<?= $_SERVER["REQUEST_URI"] ?>" method="POST">
                    <input type="hidden" name="action" value="deleteConsult">
                    <input type="hidden" name="idUser" value="<?= htmlentities($this->user->idUser) ?>">
                    <input type="hidden" name="idDoctor" value="<?= htmlentities($this->doctor->idDoctor) ?>">
                    <input type="hidden" name="appointmentDate" value="<?= htmlentities($this->appointmentDate) ?>">
                    <input type="hidden" name="hour" value="<?= htmlentities($this->hour) ?>">
                    <input type="hidden" name="duration" value="<?= htmlentities($this->duration) ?>">
                    <button class=" btn btn-primary btn-removed">
                        <i class="bi bi-trash"></i>
                    </button>
                </form>
                <button class="btn btn-primary btn-update" 
                        data-bs-toggle="modal" 
                        data-bs-target="#editConsultModal" 
                        data-appointmentdate="<?= htmlentities($this->appointmentDate) ?>" 
                        data-hour="<?= htmlentities($this->hour) ?>" 
                        data-duration="<?= htmlentities($this->duration) ?>"
                        data-iduser="<?= htmlentities($this->user->idUser) ?>" 
                        data-iddoctor="<?= htmlentities($this->doctor->idDoctor) ?>">
                    <i class="bi bi-pencil"></i>
                </button>
            </td>
        </tr>
        <?php return ob_get_clean();?>
            </td>
        </tr>
        <?php return ob_get_clean();
    }



}