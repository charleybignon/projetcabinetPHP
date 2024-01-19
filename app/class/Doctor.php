<?php
namespace App\Class;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class Doctor {

    const PATH = "/assets/images/medecins/";

    public $idDoctor;
    public $gender;
    public $lastName;
    public $firstName;
    public $picture;

    public function __construct(object $obj) {
        $this->idDoctor =  $obj->idDoctor;
        $this->gender = $obj->gender;
        $this->lastName = $obj->lastName;
        $this->firstName = $obj->firstName;
        $this->picture = self::PATH . $obj->picture;
    }

    public function getCardDoctor(){
        ob_start(); ?>
        <div class="col-md-5 mb-3 border border-dark rounded-3 shadow-lg">
            <div class="user-item d-flex align-items-center">
                <img src="<?= $this->picture ?>" alt="<?= $this->lastName . ' ' . $this->firstName ?>" class="my-2 img-fluid me-3 w-25">
                <div class="user-details flex-grow-1">
                    <h5><?= strtoupper($this->lastName) . ' ' . $this->firstName ?></h5>
                </div>

                <button type="button" class="btn btn-primary me-3" data-bs-toggle="modal" data-bs-target="#editDoctorModal<?= $this->idDoctor ?>">
                    <i class="bi bi-pencil"></i>
                </button>
                <form action="<?= $_SERVER["REQUEST_URI"] ?>" method="POST">
                    <input type="hidden" name="action" value="deleteDoctor">
                    <input type="hidden" name="idDoctor" value="<?= htmlentities($this->idDoctor) ?>">
                    <button class="btn btn-primary btn-removed me-3">
                        <i class="bi bi-trash"></i>
                    </button>
                </form>
            </div>
        </div>


        <!-- Modal de modification de médecin -->
        <div class="modal fade" id="editDoctorModal<?= $this->idDoctor ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <form action="<?= $_SERVER["REQUEST_URI"] ?>" method="POST">
                <input type="hidden" name="action" value="editDoctor">
                <input type="hidden" name="idDoctor" value="<?= htmlentities($this->idDoctor) ?>">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="newUserLabel">Modifier médecin</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row d-flex justify-content-center">
                                <div class="col-4 d-flex justify-content-center align-items-center">
                                    <label for="inputImgUserEdit">
                                        <img src="<?= $this->picture ?>" class="w-75">
                                    </label>
                                    <input id="inputImgUserEdit" type="file" class="d-none" name="picture">
                                </div>

                                <div class="col-8 d-flex flex-column justify-content-between">
                                    <div class="mb-3">
                                        <label class="me-5" for="inputGender">Civilité</label>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="gender" id="hommeEdit" value="1" <?= $this->gender == 1 ? 'checked' : '' ?> required>
                                            <label class="form-check-label" for="hommeEdit">Mr</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="gender" id="femmeEdit" value="2" <?= $this->gender == 2 ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="femmeEdit">Mme</label>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="inputLastNameEdit">Nom</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-person-vcard"></i></span>
                                            <input id="inputLastNameEdit" type="text" class="form-control" name="lastName" value="<?= $this->lastName ?>" required>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="inputFirstNameEdit">Prénom</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-person-vcard"></i></span>
                                            <input id="inputFirstNameEdit" type="text" class="form-control" name="firstName" value="<?= $this->firstName ?>" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer text-center">
                            <button type="button" class="btn btn-danger me-2" data-bs-dismiss="modal">
                                <i class="bi bi-x-circle me-2"></i>Annuler
                            </button>
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-check-circle me-2"></i>Valider
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>


        <?php return ob_get_clean();
    }
}
?>
