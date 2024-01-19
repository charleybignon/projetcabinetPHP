<?php
$title = "Page de connexion";
$bsIcons = true;
?>
<?php ob_start(); ?>
<?= App\Class\Feedback::getMessage() ?>
<div class="d-flex align-items-center justify-content-center" style="min-height: 80vh;">
    <div class="row col-6 border border-dark rounded-3">
        <div class="mb-3 text-center">
            <h2 class="my-3">Connexion</h2>
        </div>
        <form action = "<?= $_SERVER["REQUEST_URI"] ?>" method = "POST">
            <input type="hidden" name="action" value="verifLogin">
            <div class="mx-3 mb-3">
                <label for="username" class="form-label">Nom d'utilisateur</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="m-3">
                <label for="password" class="form-label">Mot de passe</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="m-3 d-flex align-items-center justify-content-center">
                <button type="submit" class="btn btn-primary col-12">Se connecter</button>
            </div>
        </form>
    </div>
</div>

<?php 
$content = ob_get_clean();
require("../app/views/layout.php");
?>