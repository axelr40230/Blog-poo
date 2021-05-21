    <!-- main -->
    <?php

    use App\App;
    use App\Table\UserTable;
    use App\Table\CommentTable;

    $infos = new UserTable();
    $id_author = $post->author;
    $author = $infos->author($id_author);

    $date = $post->date_fr('long', 'created_at');
    //var_dump($post->id);
    $tableComments = new CommentTable();
    $comments = $tableComments->elements($post->id, 'approuved');
    $number = $tableComments->howManyComments($post->id, 'approuved');




    //var_dump($comments);



    ?>

    <main role="main-inner-wrapper" class="container">



        <div class="blog-details">

            <article class="post-details" id="post-details">

                <header role="bog-header" class="bog-header text-center">

                    <h1 class="post-title"><span><?= $post->title; ?></span></h1>
                    <h3>Publié le <?= $date; ?> par <span>
                            <?php echo $author->first_name.' '.$author->last_name; ?>
                        </span></h3>
                    <h2><?= $post->introduction; ?></h2>

                </header>



                <figure>

                    <p class="text-center"><img src="   " alt="" class="img-responsive" /></p>

                </figure>



                <div class="enter-content">

                    <p><?= htmlspecialchars_decode($post->content); ?></p>

                    <a href="<?= App::url('posts') ?>" target="_blank" class="btn btn-red my-5">Retourner aux actus</a>

                </div>

            </article>



            <!-- Comments -->

            <div class="comments-pan">

                <h3><?php

                    if($number == 0) : ?>
                        Aucun commentaire
                    <?php

                    elseif($number == 1) :
                    echo $number; ?>
                    commentaire

                    <?php
                    else :

                    echo $number;

                    ?> commentaires</h3>
                    <?php endif; ?>



                <ul class="comments-reply">
                    <?php


                    foreach ($comments as $comment)
                    {

                        $table = new UserTable();
                        $idAuthorComment = $comment->author;
                        $authorComment = $table->author($idAuthorComment);
                        //var_dump($comment);
                        ?>

                        <li>

                            <figure>

                                <img src="../public/images/blog-images/image-1.png" alt="" class="img-responsive"/>

                            </figure>

                            <section>

                                <h4><?php //echo $author ?></h4>

                                <div class="date-pan">Le <?= $dateComment = $comment->date_fr('long', 'created_at'); ?>, <?php echo $authorComment->first_name.' '.$authorComment->last_name; ?> à écrit</div>
                                <?= $comment->comment ?>

                            </section>

                        </li>
                        <?php
                   }
                    ?>

                </ul>



                <div class="commentys-form">

                    <h4>Laisser un commentaire</h4>



                    <div class="row">

                        <form action="" method="get">



                            <div class="col-xs-12 col-sm-4 col-md-4">

                                <input name="" type="text" placeholder="Quel est votre nom ? *">

                            </div>

                            <div class="col-xs-12 col-sm-4 col-md-4">

                                <input name="" type="email" placeholder="Votre email ? *">

                            </div>

                            <div class="col-xs-12 col-sm-4 col-md-4">

                                <input name="" type="url" placeholder="Un site web peut-être ?">

                            </div>

                            <div class="clearfix"></div>

                            <div class="col-xs-12 col-sm-12 col-md-12">

                                <textarea name="" cols="" rows="" placeholder="Votre com'"></textarea>

                            </div>

                            <div class="text-center">

                                <input name="" type="button" value="Envoyer le com'">

                            </div>





                        </form>

                    </div>



                </div>



            </div>



        </div>


    </main>

    <!-- main -->