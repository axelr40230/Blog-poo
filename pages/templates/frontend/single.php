<!-- main -->
<?php

use App\App;

?>

<main role="main-inner-wrapper" class="container">


    <div class="blog-details">

        <article class="post-details" id="post-details">

            <header role="bog-header" class="bog-header text-center">

                <h1 class="post-title"><span><?= $post->title; ?></span></h1>
                <h3>Modifié le <?= $post->date_fr('long', 'modify_at'); ?> | Rédigé par <span>
                            <?= $post->author->first_name . ' ' . $post->author->last_name; ?>
                        </span></h3>
                <h2><?= $post->introduction; ?></h2>

            </header>


            <figure>

                <p class="text-center"><img src="   " alt="" class="img-responsive"/></p>

            </figure>


            <div class="enter-content">

                <p><?= htmlspecialchars_decode($post->content); ?></p>

                <a href="<?= App::url('posts') ?>" target="_blank" class="btn btn-red my-5">Retourner aux actus</a>

            </div>

        </article>


        <!-- Comments -->

        <div class="comments-pan">

            <h3><?php

                if ($number == 0) : ?>
                    Aucun commentaire
                <?php

                elseif ($number == 1) :
                    echo $number; ?>
                    commentaire

                <?php
                else :

                echo $number;

                ?> commentaires</h3>
            <?php endif; ?>


            <ul class="comments-reply">
                <?php


                foreach ($comments as $comment) {

                    ?>

                    <li>

                        <figure>

                            <img src="../public/images/blog-images/image-1.png" alt="" class="img-responsive"/>

                        </figure>

                        <section>

                            <h4><?php //echo $author
                                ?></h4>

                            <div class="date-pan">Le <?= $comment->date_fr('long', 'created_at'); ?>
                                , <?= $comment->author->first_name . ' ' . $comment->author->last_name; ?> à écrit
                            </div>
                            <?= $comment->comment ?>

                        </section>

                    </li>
                    <?php
                }
                ?>

            </ul>

            <?php if ($isConnect == true) : ?>

                <div class="commentys-form">

                    <h4>Laisser un commentaire</h4>


                    <div class="row">

                        <form action="" method="post">


                            <div class="clearfix"></div>

                            <div class="col-xs-12 col-sm-12 col-md-12">

                                <!--                                <textarea name="" cols="" rows="" placeholder="Votre com'"></textarea>-->
                                <?= $form->textarea('', 'comment', 'Votre com\''); ?>


                            </div>

                            <div class="text-center">

                                <!--                                <input name="" type="button" value="Envoyer le com'">-->
                                <?= $form->submit('Envoyer le com\'', 'addComment', 'btn btn-red my-5', 'addComment'); ?>

                            </div>


                        </form>

                    </div>


                </div>

            <?php else : ?>

                <div class="text-center">
                    <h2 class="text-center">Vous devez vous identifier pour pouvoir laisser un commentaire</h2>
                    <a class="btn btn-red my-5" href="<?= App::url('login') ?>">Connexion</a>
                </div>

            <?php endif; ?>


        </div>


    </div>


</main>

<!-- main -->