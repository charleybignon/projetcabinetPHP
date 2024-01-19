<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <?php 
    if(isset($bsIcons) && $bsIcons === true) {
        echo '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">';
    }
    ?>
    <?= isset($scripts) ? $scripts : "" ?>
    <title><?= isset($title) ? $title : "Titre" ?></title>
</head>
<body>
    <?php
    if(isset($_SESSION["login"])){?>
    <header class="mb-4">
        <div class="container p-0">
            <!-- Menu de navigation Bootstrap -->
            <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
                <div class="container-fluid">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav d-flex">
                            <li class="nav-item flex-fill">
                                <a class="nav-link" href="accueil">Usagers</a>
                            </li>
                            <li class="nav-item flex-fill">
                                <a class="nav-link" href="medecins">Médecins</a>
                            </li>
                            <li class="nav-item flex-fill">
                                <a class="nav-link" href="consultations">Consultations</a>
                            </li>
                            <li class="nav-item flex-fill">
                                <a class="nav-link" href="statistiques">Statistiques</a>
                            </li>
                            <li class="nav-item flex-fill">
                                <a class="nav-link" href="disconnect">Se déconnecter</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </header>
    <?php
    }?>
    <main>
        <?= isset($content) ? $content : "Contenu de la page." ?>
    </main>  
</body>
</html>