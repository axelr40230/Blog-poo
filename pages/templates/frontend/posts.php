<?php

use App\App;
use App\Auth;
use App\Session;

$session = new Session();
if($session->get('user')) :
$user = $session->get('user');
$status = $user->status;
endif;
?>
<!-- main -->

<main role="main-inner-wrapper" class="container">


    <div class="row my-5">


        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 ">

            <article role="pge-title-content" class="blog-header">

                <header>

                    <h2><span>Actus</span> A vous de jouer</h2>

                </header>

                <p>Votre avis est précieux ! N'hésitez pas à le donner en nous laissant vos commentaires</p>

                <?php
                $isConnect = Auth::isAuth();
                if ($isConnect == false) :
                ?>

                <a href="<?= App::url('login') ?>" target="_blank" class="btn btn-red my-5">S'identifier</a>

                <?php elseif($status == 'admin') : ?>

                <a href="<?= App::url('login') ?>" target="_blank" class="btn btn-red my-5">Accéder au back office</a>

                <?php else : ?>

                <a href="<?= App::url('login') ?>" target="_blank" class="btn btn-red my-5">Se déconnecter</a>

                <?php endif; ?>

                <p>Commencez à lire les dernières actus dès à présent<br/><br/>
                    <i class="fa fa-chevron-down" aria-hidden="true"></i><br/>
                    <i class="fa fa-chevron-down" aria-hidden="true"></i><br/>
                    <i class="fa fa-chevron-down" aria-hidden="true"></i><br/>
                    <i class="fa fa-chevron-down" aria-hidden="true"></i>
                </p>

            </article>

        </div>


        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">

            <ul class="grid-lod effect-2" id="grid">

                <li>

                    <section>

                        <figure>

                            <img src="<?= App::url('') ?>public/images/blog-images/blog-5.jpg" alt=""/>

                        </figure>

                    </section>

                </li>

            </ul>

        </div>


    </div>
    <div class="row">

        <!--- posts --->

        <?php foreach ($posts as $post) : ?>
            <?php
            //var_dump($post);
            //$id = $post['id'];
            ?>

            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">

                <ul class="grid-lod effect-2" id="grid">

                    <li>

                        <section class="blog-content">

                            <a href="<?= $post->url(); ?>">

                                <figure>

                                    <div class="post-date">
                                        <?php $date = $post->date_fr('short', 'created_at');

                                        $day = $date[0];
                                        $date = $date[1];
                                        ?>
                                        <span><?= $day; ?></span><?= $date; ?>

                                    </div>

                                    <?php if (isset($post->image)) : ?>

                                        <img src="" alt="" class="img-responsive"/>

                                    <?php else : ?>

                                        <img src="<?= App::url('') ?>public/images/blog-images/blog-3.jpg" alt=""
                                             class="img-responsive"/>

                                    <?php endif; ?>

                                </figure>

                            </a>

                            <article>

                                <?= $post->title; ?>

                            </article>

                        </section>

                    </li>

                </ul>

            </div>

        <?php endforeach; ?>

        <!--- posts --->


    </div>

</main>

<!-- main -->
