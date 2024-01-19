<?php
$title = "Page de connexion";
$bsIcons = true;
?>
<?php ob_start(); ?>

<div class="container">
    <?= App\Class\Feedback::getMessage() ?>

    <fieldset class="border border-dark rounded-3 px-3 mb-4">        
        <legend class="float-none w-auto px-2">Filtrer les consultations
        <a href="consultations">
            <button type="button" class="btn btn-primary btn-show ms-3">Toutes les consultations</button>
        </a>
        </legend>
        <form action="<?= $_SERVER["REQUEST_URI"] ?>" method="POST" class="mb-4">
            <input type="hidden" name="action" value="filter">
            <div class="row d-flex justify-content-center gx-3">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="appointmentDate" class="form-label">Date</label>
                        <input type="date" class="form-control" id="appointmentDate" name="appointmentDate">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="idDoctor" class="form-label">Médecin</label>
                        <select class="form-select" id="idDoctor" name="idDoctor">
                            <option value="" selected disabled>Sélectionnez un médecin</option>
                            <?php foreach ($doctors as $doctor) : ?>
                                <option value="<?= $doctor->idDoctor ?>"><?= $doctor->lastName ?> <?= $doctor->firstName ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="row col-md-2 mt-3">
                    <button type="submit" class="btn btn-primary btn-block"><i class="bi bi-search"></i></button>
                </div>
            </div>
        </form>

    </fieldset>
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary col-3 mb-3" data-bs-toggle="modal" data-bs-target="#addConsult">Ajouter une consultation <i class="bi bi-plus-lg"></i></button>
    <?php
        if (!empty($consults)){?>
        <h2>Liste des consultations</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Heure</th>
                    <th>Durée</th>
                    <th>Usager</th>
                    <th>Médecin</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <!-- Remplacez le tableau $consultations par votre tableau de consultations -->
                <?php foreach ($consults as $consult){
                    echo $consult->setTabLine();
                } ?>
            </tbody>
        </table>

        <?php } ?>
    </div>


    <!-- Modal d'ajout d'une consultation -->
    <div class="modal fade" id="addConsult" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="<?= $_SERVER["REQUEST_URI"] ?>" method="POST">
                <input type="hidden" name="action" value="addConsult">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="newUserLabel">Ajouter consultation</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="inputDate">Date</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-calendar"></i></span>
                                <input id="inputDate" type="date" class="form-control" name="appointmentDate" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="inputTime">Heure</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-clock"></i></span>
                                <input id="inputTime" type="time" class="form-control" name="hour" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="inputDuration">Durée</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-clock"></i></span>
                                <input id="inputDuration" type="time" class="form-control" name="duration" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="idUser">Usager</label>
                            <select class="form-select" id="idUser" name="idUser" required>
                                <option value="" selected>Sélectionnez un usager</option>
                                <?php foreach ($users as $user) : ?>
                                    <option value="<?= $user->idUser ?>"><?= $user->lastName ?> <?= $user->firstName ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>


                        <div class="mb-3">
                            <label for="idDoctor">Médecin</label>
                            <select class="form-select" id="idDoctor" name="idDoctor" required>
                                <option value="" selected>Sélectionnez un médecin</option>
                                <?php foreach ($doctors as $doctor) : ?>
                                    <option value="<?= $doctor->idDoctor ?>"><?= $doctor->lastName ?> <?= $doctor->firstName ?></option>
                                <?php endforeach; ?>
                            </select>
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
            </form>
        </div>
    </div>

</div>

<!-- Modal de Modification -->
<div class="modal fade" id="editConsultModal" tabindex="-1" aria-labelledby="editConsultModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="<?= $_SERVER["REQUEST_URI"] ?>" method="POST">
            <input type="hidden" name="action" value="updateConsult">
            <input type="hidden" id="editIdUser" name="idUser">
            <input type="hidden" id="editIdDoctor" name="idDoctor">
            <input type="hidden" id="currentAppointmentDate" name="appointmentDate">
            <input type="hidden" id="currentHour" name="hour">
            <input type="hidden" id="currentDuration" name="duration">


            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editConsultModalLabel">Modifier Consultation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Champs du formulaire pour modifier la consultation -->
                    <input type="date" class="form-control mb-2" id="editAppointmentDate" name="newAppointmentDate" required>
                    <input type="time" class="form-control mb-2" id="editHour" name="newHour" required>
                    <input type="time" class="form-control mb-2" id="editDuration" name="newDuration" required>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                    <button type="submit" class="btn btn-primary">Sauvegarder </button>
                </div>
            </div>
        </form>
    </div>
</div>

<?php 
$content = ob_get_clean();
require("../app/views/layout.php");
?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    document.querySelectorAll(".btn-removed").forEach(form => {
    form.addEventListener("click", e => {
        e.stopPropagation();
        if(!window.confirm("Voulez vous vraiment supprimer ce rendez-vous ?"))
            e.preventDefault();
    });
});

$('#editConsultModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Bouton qui a déclenché la modal

        // Extraction des données actuelles de la consultation
        var idUser = button.data('iduser');
        var idDoctor = button.data('iddoctor');
        var appointmentDate = button.data('appointmentdate');
        var hour = button.data('hour');
        var duration = button.data('duration');

        // Remplissage du formulaire avec les données actuelles
        var modal = $(this);
        modal.find('#editIdUser').val(idUser);
        modal.find('#editIdDoctor').val(idDoctor);
        modal.find('#editNewAppointmentDate').val(appointmentDate);
        modal.find('#editNewHour').val(hour);
        modal.find('#editNewDuration').val(duration);
        modal.find('#editAppointmentDate').val(appointmentDate);
        modal.find('#editHour').val(hour);
        modal.find('#editDuration').val(duration);

        // Remplissage des champs cachés pour identifier la consultation
        modal.find('#currentAppointmentDate').val(appointmentDate);
        modal.find('#currentHour').val(hour);
        modal.find('#currentIdUser').val(idUser);
        modal.find('#currentIdDoctor').val(idDoctor);
    });
</script>