<?php
$title = "Page de connexion";
$bsIcons = true;
?>
<?php ob_start();?>

<div class="container">
    <?= App\Class\Feedback::getMessage() ?>

    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="sessions-tab" data-bs-toggle="tab" data-bs-target="#users"
                type="button" role="tab" aria-controls="sessions" aria-selected="true">Répartition usagers</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="eleves-tab" data-bs-toggle="tab" data-bs-target="#doctors" type="button"
                role="tab" aria-controls="eleves" aria-selected="false">Consultations par médecin</button>
        </li>
    </ul>
    <!--Tableau de statistique sur les tranches d'âges-->
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="users" role="tabpanel" aria-labelledby="sessions-tab">
            <h2 class="my-5">Répartition des usagers selon leur sexe et leur âge</h2>
            <table class="table table-bordered border-dark">
                <tr>
                    <th>Tranche d'âge</th>
                    <th>Homme</th>
                    <th>Femme</th>
                </tr>
                <tr>
                    <th>Moins de 25 ans</th>
                    <td><?=htmlentities($MUnder25)?></td>
                    <td><?=htmlentities($WUnder25)?></td>
                </tr>
                <tr>
                    <th>Entre 25 et 50 ans</th>
                    <td><?=htmlentities($MBetween25_50)?></td>
                    <td><?=htmlentities($WBetween25_50)?></td>
                </tr>
                <tr>
                    <th>Plus de 50 ans</th>
                    <td><?=htmlentities($MOver50)?></td>
                    <td><?=htmlentities($WOver50)?></td>
                </tr>
            </table>
        </div>
        <!--Crétation d'un tableau, une ligne pour chaque docteur avec son temps de consultation associé-->
        <div class="tab-pane fade" id="doctors" role="tabpanel" aria-labelledby="eleves-tab">
            <h2 class="my-5">Durées totales de consultations effectuées par chaque médecin</h2>
            <table class="table table-bordered border-dark">
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Temps de Consultation effectué</th>
                    <th>Temps de Consultation à venir</th>
                </tr>
                <?php foreach($doctors as $doctor) { 
                    $totalDuration = "00:00:00";
                    $totalFutureDuration = "00:00:00";

                    // Recherche des durées de consultations passées si le tableau n'est pas vide
                    if (!empty($ConsultationTimes)) {
                        foreach ($ConsultationTimes as $consultation) {
                            if ($consultation->idDoctor == $doctor->idDoctor) {
                                $totalDuration = $consultation->totalDuration;
                                break;
                            }
                        }
                    }

                    // Recherche des durées de consultations futures si le tableau n'est pas vide
                    if (!empty($ConsultationFutureTimes)) {
                        foreach ($ConsultationFutureTimes as $consultationF) {
                            if ($consultationF->idDoctor == $doctor->idDoctor) {
                                $totalFutureDuration = $consultationF->totalDuration;
                                break;
                            }
                        }
                    }
                ?>
                    <tr>
                        <th><?= strtoupper(htmlentities($doctor->lastName)) ?></th>
                        <th><?= htmlentities($doctor->firstName) ?></th>
                        <td><?= htmlentities($totalDuration) ?></td>
                        <td><?= htmlentities($totalFutureDuration) ?></td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </div>
    
</div>

<?php 
$content = ob_get_clean();
require("../app/views/layout.php");
?>
