<?php

use App\App;

?>
<div class="container">
    <div class="row">
        <h1 class="text-center">PAGE 404</h1>
        <div class="alert alert-danger text" role="alert">
            <p class="text-center">La page demandée n'existe pas..</p>
        </div>
        <div class="text-center py-5">
            <a class="btn btn-red text-uppercase" href="<?= App::url('') ?>" role="button">Retourner à l'accueil</a>
        </div>
    </div>
</div>