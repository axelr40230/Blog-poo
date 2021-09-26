<?php

use App\App;

?>
<header role="header">

    <?php if ($isConnect == false) : ?>

        <div class="container">
            <div class="row">
                <div class="col-12 offset-md-8 col-md-2 text-right">
                    <a class="btn btn-red my-5" href="<?= App::url('login') ?>">Connexion</a>
                </div>
            </div>
        </div>

    <?php elseif ($identity->status == 'admin') : ?>

        <div class="container">
            <div class="row">
                <div class="col-12 offset-md-8 col-md-2 text-right">
                    <a class="btn btn-red my-5" href="<?= App::url('admin') ?>">Accéder au back office</a>
                </div>
            </div>
        </div>

    <?php else : ?>

        <div class="container">
            <div class="row">
                <div class="col-12 offset-md-8 col-md-2 text-right">
                    <a class="btn btn-red my-5" href="<?= App::url('logout') ?>">Se déconnecter</a>
                </div>
            </div>
        </div>

    <?php endif; ?>

    <div class="container">

        <div class="row">

            <div class="col-12">
                <!-- logo -->

                <h1>

                    <a href="<?= App::url('') ?>" title="Alexandra Rochette"><img
                                src="<?= App::url('') ?>public/images/logo.png" alt="Alexandra Rochette"/></a>

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
        </div>

    </div>

</header>
