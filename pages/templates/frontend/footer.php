<?php
use App\App;
?>
<!-- footer -->

<footer role="footer">

    <!-- logo -->

    <h1>

        <a href="<?= App::url('') ?>" title="avana LLC"><img src="<?= App::url('/') ?>public/images/logo.png" title="avana LLC" alt="avana LLC"/></a>

    </h1>

    <!-- logo -->

    <!-- nav -->

    <nav role="footer-nav">

        <ul>

            <li><a href="<?php __DIR__ ?>/blog/home" title="About">Accueil</a></li>

            <li><a href="<?php __DIR__ ?>/blog/posts" title="Blog">Blog</a></li>

            <li><a href="<?php __DIR__ ?>/blog/contact" title="Contact">Contact</a></li>

        </ul>

    </nav>

    <!-- nav -->

    <ul role="social-icons">

        <li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>

        <li><a href="#"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>

        <li><a href="#"><i class="fa fa-github" aria-hidden="true"></i></a></li>

    </ul>

    <p class="copy-right">&copy; 2021  Alexandra Rochette.. Tous droits réservés</p>

</footer>

<!-- footer -->



<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->

<script src="<?= App::url('/') ?>public/js/jquery.min.js" type="text/javascript"></script>

<!-- custom -->

<script src="<?= App::url('/') ?>public/js/nav.js" type="text/javascript"></script>

<script src="<?= App::url('/') ?>public/js/custom.js" type="text/javascript"></script>

<!-- Include all compiled plugins (below), or include individual files as needed -->

<script src="<?= App::url('/') ?>public/js/bootstrap.min.js" type="text/javascript"></script>

<script src="<?= App::url('/') ?>public/js/effects/masonry.pkgd.min.js" type="text/javascript"></script>

<script src="<?= App::url('/') ?>public/js/effects/imagesloaded.js" type="text/javascript"></script>

<script src="<?= App::url('/') ?>public/js/effects/classie.js" type="text/javascript"></script>

<script src="<?= App::url('/') ?>public/js/effects/AnimOnScroll.js" type="text/javascript"></script>

<script src="<?= App::url('/') ?>public/js/effects/modernizr.custom.js"></script>

<!-- jquery.countdown -->

<script src="<?= App::url('/') ?>public/js/html5shiv.js" type="text/javascript"></script>