<?php
$title = "Usagers";
$bsIcons = true;
?>
<?php ob_start(); ?>

<div class="container">
    <?= App\Class\Feedback::getMessage() ?>

    <fieldset class="border border-dark rounded-3 p-3 mb-4">
        <legend class="float-none w-auto px-2">Filtrer les usagers
        <a href="accueil">
            <button type="button" class="btn btn-primary btn-show ms-3">Tous les usagers</button>
        </a>
        </legend>
        <form action="<?= $_SERVER["REQUEST_URI"] ?>" method="POST"  class="mb-4">
            <input type="hidden" name="action" value="filter">
            <div class="row gx-3 d-flex justify-content-center">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="lastName" class="form-label">Nom</label>
                        <input type="text" class="form-control" id="lastName" name="lastName">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="firstName" class="form-label">Prénom</label>
                        <input type="text" class="form-control" id="firstName" name="firstName">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label col-12 mb-3">Civilité</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="gender" id="homme" value="1">
                            <label class="form-check-label" for="homme">Mr</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="gender" id="femme" value="2">
                            <label class="form-check-label" for="femme">Mme</label>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="city" class="form-label">Ville</label>
                        <input type="text" class="form-control" id="city" name="city">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="postalCode" class="form-label">Code Postal</label>
                        <input type="text" class="form-control" id="postalCode" name="postalCode">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="mb-2" for="idDoctor">Médecin traitant</label>
                        <div class="input-group col-md-4">
                            <select id="idDoctor" class="form-select" name="idDoctor">
                                <option value="" selected>Sélectionnez un médecin</option>
                                <?php foreach ($doctors as $doctor) : ?>
                                    <option value="<?= $doctor->idDoctor ?>"><?= $doctor->lastName ?> <?= $doctor->firstName ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="row col-md-2 mt-3">
                    <button type="submit" class="btn btn-primary btn-block"><i class="bi bi-search"></i></button>
                </div>
            </div>
        </form>
    </fieldset>
    <button type="button " class="btn btn-primary col-2 mb-3" data-bs-toggle="modal" data-bs-target="#addUserModal">
        Ajouter un usager <i class="bi bi-plus-lg"></i>
    </button>
    <?php
        if (!empty($usagers)){?>
            <h2 class="float-none w-auto px-2">Liste des usagers</h2>
            <div class="row my-4 d-flex justify-content-around">
            <?php        
                foreach ($usagers as $usager){
                    echo $usager->getCarduser($doctors);
                }} ?>
            </div>
    </div>

    <!-- Modal d'ajout d'utilisateur-->
    <div class="modal fade" id="addUserModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form action="<?= $_SERVER["REQUEST_URI"] ?>" method="POST">
                <input type="hidden" name="action" value="addUser">                    
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="newUserLabel">Ajouter usager</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row d-flex justify-content-center">
                            <div class="col-4 d-flex justify-content-center align-items-center">
                                <label for="inputImgUserAdd">
                                    <img src="/assets/images/usagers/user.png" class="w-75">
                                </label>
                                <input id="inputImgUserAdd" type="file" class="d-none" name="picture">
                            </div>
                            <div class="col-8 d-flex flex-column justify-content-between">
                                <div class="mb-3">
                                    <label class="me-5" for="inputFirstName">Civilité</label>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="gender" id="homme" value="1" required>
                                        <label class="form-check-label" for="inlineRadio1">Mr</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="gender" id="femme" value="2">
                                        <label class="form-check-label" for="inlineRadio2">Mme</label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="inputLastName">Nom</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-person-vcard"></i></span>
                                        <input id="inputLastName" type="text" class="form-control" name="lastName" required>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="inputFirstName">Prénom</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-person-vcard"></i></span>
                                        <input id="inputFirstName" type="text" class="form-control" name="firstName" required>
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
                                        <input id="inputCity" type="text" class="form-control" name="city" required>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <label for="inputPostal">Code postal</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-123"></i></span>
                                        <input id="inputPostal" type="number" pattern="[0-9]{5-5}" class="form-control" name="postalCode" required>
                                    </div>
                                </div>
                                <div class="col-12 my-3">
                                    <label for="inputAdress">Adresse complète</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-house-door"></i></span>
                                        <input id="inputAdress" type="text" class="form-control" name="adress" required>
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
                                        <input id="inputBirthPlace" type="text" class="form-control" name="birthPlace" required>
                                    </div>
                                </div>
                                <div class="col-12 my-3">
                                    <label for="inputBirthDay">Date de naissance</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-cake2"></i></span>
                                        <input id="inputBirthDay" type="date" class="form-control" name="birthDay" required>
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
                                        <input id="inputSecuNum" type="text" class="form-control" name="secuNum" required>
                                    </div>
                                </div>

                                <div class="col-6 my-3">
                                    <label for="inputDoctor">Médecin traitant</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-capsule"></i></span>
                                        <select id="inputDoctor" class="form-select" name="idDoctor" required>
                                            <option value="" selected>Sélectionnez un médecin</option>
                                            <?php foreach ($doctors as $doctor) : ?>
                                                <option value="<?= $doctor->idDoctor ?>"><?= $doctor->lastName ?> <?= $doctor->firstName ?></option>
                                            <?php endforeach; ?>
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
</div>

<?php 
$content = ob_get_clean();
require("../app/views/layout.php");
?>

<script>
    document.querySelectorAll(".btn-removed").forEach(form => {
    form.addEventListener("click", e => {
        e.stopPropagation();
        if(!window.confirm("Voulez vous vraiment supprimer cet usager ?"))
            e.preventDefault();
    });
});
</script>