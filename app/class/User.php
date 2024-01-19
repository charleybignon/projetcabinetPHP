<?php

namespace App\Class;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class User {

    const PATH = "/assets/images/usagers/";

    public $idUser;
    public $gender;
    public $lastName;
    public $firstName;
    public $birthDay;
    public $adress;
    public $city;
    public $postalCode;
    public $birthPlace;
    public $secuNum;
    public $idDoctor;
    public $picture;

    public function __construct(object $obj) {
        $this->idUser =  $obj->idUser;
        $this->gender = $obj->gender;
        $this->lastName = $obj->lastName;
        $this->firstName = $obj->firstName;
        $this->birthDay = $obj->birthDay;
        $this->adress = $obj->adress;
        $this->city = $obj->city;
        $this->postalCode = $obj->postalCode;
        $this->birthPlace = $obj->birthPlace;
        $this->secuNum = $obj->secuNum;
        $this->idDoctor = $obj->idDoctor;
        $this->picture = self::PATH . $obj->picture;
    }


    public function getCardUser($doctors){
        ob_start(); ?>
        <div class="col-md-5 mb-3 border border-dark rounded-3 shadow-lg">
            <div class="user-item d-flex align-items-center">
                <img src="<?= $this->picture ?>" alt="<?= $this->firstName . ' ' . $this->lastName ?>" class="my-2 img-fluid me-3 w-25">
                <div class="user-details flex-grow-1">
                    <h5><?= strtoupper($this->lastName) . ' ' . $this->firstName ?></h5>
                </div>
                <button type="button" class="btn btn-primary me-3" data-bs-toggle="modal" data-bs-target="#editUserModal<?= $this->idUser ?>">
                    <i class="bi bi-pencil"></i>
                </button>
                <form action="<?= $_SERVER["REQUEST_URI"] ?>" method="POST">
                    <input type="hidden" name="action" value="deleteUser">
                    <input type="hidden" name="idUser" value="<?= htmlentities($this->idUser) ?>">
                    <button class=" btn btn-primary btn-removed me-3">
                        <i class="bi bi-trash"></i>
                    </button>
                </form>
            </div>
        </div>

        <div class="modal fade" id="editUserModal<?= $this->idUser ?>" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <form action="<?= $_SERVER["REQUEST_URI"] ?>" method="POST">
                    <input type="hidden" name="action" value="editUser">                    
                    <input type="hidden" name="idUser" value="<?= htmlentities($this->idUser) ?>">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="newUserLabel">Modifier <?= strtoupper($this->lastName)." ".$this->firstName ?></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row d-flex justify-content-center">
                                <div class="col-4 d-flex justify-content-center align-items-center">
                                    <label for="inputImgUserEdit">
                                        <img src="/assets/images/usagers/user.png" class="w-75">
                                    </label>
                                    <input id="inputImgUserEdit" type="file" class="d-none" name="picture">
                                </div>
                                <div class="col-8 d-flex flex-column justify-content-between">
                                    <div class="mb-3">
                                        <label class="me-5" for="inputFirstName">Civilité</label>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="gender" id="homme" value=1 <?= $this->gender == 1 ? 'checked' : '' ?> required>
                                            <label class="form-check-label" for="inlineRadio1">Mr</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="gender" id="femme" value=2 <?= $this->gender == 2 ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="inlineRadio2">Mme</label>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="inputLastName">Nom</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-person-vcard"></i></span>
                                            <input id="inputLastName" type="text" class="form-control" name="lastName" value="<?= $this->lastName ?>" required>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="inputFirstName">Prénom</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-person-vcard"></i></span>
                                            <input id="inputFirstName" type="text" class="form-control" name="firstName" value="<?= $this->firstName ?>" required>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Remplissage de l'adresse -->
                                <fieldset class="row col-6 border border-dark rounded-3 p-0 mb-4 me-5">
                                    <legend class="float-none w-auto px-2 m-0">Adresse <i class="bi bi-geo-alt"></i></legend>
                                    <div class="col-6">
                                        <label for="inputCity">Ville</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-buildings"></i></span>
                                            <input id="inputCity" type="text" class="form-control" name="city" value="<?= $this->city ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <label for="inputPostal">Code postal</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-123"></i></span>
                                            <input id="inputPostal" type="number" pattern="[0-9]{5}" class="form-control" name="postalCode" value="<?= $this->postalCode ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-12 my-3">
                                        <label for="inputAdress">Adresse complète</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-house-door"></i></span>
                                            <input id="inputAdress" type="text" class="form-control" name="adress" value="<?= $this->adress ?>" required>
                                        </div>
                                    </div>
                                </fieldset>

                                <!-- Remplissage des informations médicales -->
                                <fieldset class="row col-5 border border-dark rounded-3 p-0 mb-4">
                                    <legend class="float-none w-auto px-2 m-0">Informations personnelles</legend>
                                    <div class="col-12">
                                        <label for="inputBirthPlace">Lieu de naissance</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-hospital"></i></span>
                                            <input id="inputBirthPlace" type="text" class="form-control" name="birthPlace" value="<?= $this->birthPlace ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-12 my-3">
                                        <label for="inputBirthDay">Date de naissance</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-cake2"></i></span>
                                            <input id="inputBirthDay" type="date" class="form-control" name="birthDay" value="<?= $this->birthDay ?>" required>
                                        </div>
                                    </div>

                                </fieldset>
                                

                                <!-- Remplissage des informations de naissance -->
                                <fieldset class="row col-11 px-4 border border-dark rounded-3 p-0 mb-4">
                                    <legend class="float-none w-auto px-2 m-0">Informations de sécurité sociale et médicales</legend>
                                    <div class="col-6 my-3">
                                        <label for="inputSecuNum">Numéro de sécurité sociale</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-123"></i></span>
                                            <input id="inputSecuNum" type="text" class="form-control" name="secuNum" value="<?= $this->secuNum ?>" required>
                                        </div>
                                    </div>

                                    <div class="col-6 my-3">
                                        <label for="inputDoctor">Médecin traitant</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-capsule"></i></span>
                                            <select id="inputDoctor" class="form-select" name="idDoctor" required>
                                                <option value="">Sélectionnez un médecin</option>
                                                <?php foreach ($doctors as $doctor){
                                                    if ($doctor->idDoctor == $this->idDoctor){?>
                                                        <option value="<?= $doctor->idDoctor ?>" selected>
                                                            <?= htmlentities($doctor->lastName) . " " . htmlentities($doctor->firstName) ?>
                                                        </option>
                                                    <?php }else{?>
                                                        <option value="<?= $doctor->idDoctor ?>">
                                                            <?= htmlentities($doctor->lastName) . " " . htmlentities($doctor->firstName) ?>
                                                        </option>
                                                <?php }} ?>
                                            </select>
                                        </div>
                                    </div>



                                </fieldset>
                                
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
                    </div>
                </form>
            </div>
        </div>



        <?php return ob_get_clean();
    }

}