<?php

use App\App;

?>
<header role="header">

    <div class="container">
        <div class="row">
            <div class="col-12 offset-md-10 col-md-2 text-right">
                <a class="btn btn-red my-5" href="<?= App::url('login') ?>">Connexion</a>
            </div>
        </div>

    </div>

    <div class="container">

        <!-- logo -->

        <h1>

            <a href="<?= App::url('') ?>" title="Alexandra Rochette"><img src="<?= App::url('') ?>public/images/logo.png" alt="Alexandra Rochette"/></a>

        </h1>

        <!-- logo -->

        <!-- nav -->

        <nav role="header-nav" class="navy">

            <ul>

                <li><a href="<?= App::url('') ?>" title="About">Accueil</a></li>

                <li><a href="<?= App::url('posts') ?>" title="Blog">Blog</a></li>

                <li><a href="<?= App::url('contact') ?>" title="Contact">Contact</a></li>

            </ul>

        </nav>

        <!-- nav -->

    </div>

</header>
