<?php
$title = "Page de connexion";
$bsIcons = true;
?>
<?php ob_start(); ?>

<div class="container">
    <?= App\Class\Feedback::getMessage() ?>

    <fieldset class="border border-dark rounded-3 px-3 mb-4">        
        <legend class="float-none w-auto px-2">Filtrer les médecins
        <a href="medecins">
            <button type="button" class="btn btn-primary btn-show ms-3">Tous les médecins</button>
        </a>
        </legend>
        <form action="<?= $_SERVER["REQUEST_URI"] ?>" method="POST"  class="mb-4">
            <input type="hidden" name="action" value="filter">
            <div class="row mt-2 d-flex justify-content-center gx-3">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="nom" class="form-label">Nom</label>
                        <input type="text" class="form-control" id="lastName" name="lastName">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="prenom" class="form-label">Prénom</label>
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

                <div class="row col-md-2 mt-3">
                    <button type="submit" class="btn btn-primary btn-block"><i class="bi bi-search"></i></button>
                </div>
            </div>
        </form>
    </fieldset>
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary col-2 mb-3" data-bs-toggle="modal" data-bs-target="#addDoctor">
    Ajouter un médecin <i class="bi bi-plus-lg"></i>
    </button>
    <?php
        if (!empty($doctors)){?>
        <h2>Liste des médecins</h2>
        <div class="row my-4 d-flex justify-content-around">
        <?php        
            foreach ($doctors as $doctor){
                echo $doctor->getCardDoctor();
            }} ?>
    </div>


    <!-- Modal d'ajout de médecin -->
    <div class="modal fade" id="addDoctor" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <form action="<?= $_SERVER["REQUEST_URI"] ?>" method="POST">
            <input type="hidden" name="action" value="addDoctor">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newUserLabel">Ajouter médecin</h5>
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
                                <input class="form-check-input" type="radio" name="gender" id="homme" value=1 required>
                                <label class="form-check-label" for="inlineRadio1">Mr</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="gender" id="femme" value=2>
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
        if(!window.confirm("Voulez vous vraiment supprimer ce médecin ?"))
            e.preventDefault();
    });
});
</script>