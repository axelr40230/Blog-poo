<?php

use App\App;

?>
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="text-center">
                <p class="lead text-gray-800 mb-5">Félicitations !</p>
                <p class="text-gray-500 mb-0 ">Votre message a bien été envoyé. Il va être étudié par notre équipe de modération. Vous serez informés par mail de sa validation</p>
            </div>
            <div class="text-center py-5">
                <a class=" btn btn-red" href="<?= App::url('posts') ?>">&larr; Retourner aux articles</a>
            </div>
        </div>
    </div>
</div>
