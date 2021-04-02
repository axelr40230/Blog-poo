    <!-- main -->
    <?php
    $db = new   \App\Database('blogpoo');
    $post = $db->prepare('SELECT * FROM articles WHERE id = ?' , [$_GET['id']], 'App\Table\Article', true );
    ?>

    <main role="main-inner-wrapper" class="container">



        <div class="blog-details">

            <article class="post-details" id="post-details">

                <header role="bog-header" class="bog-header text-center">

                    <h1 class="post-title"><span><?= $post->title; ?></span></h1>
                    <h3>Publié le date/date par <span>auteur</span></h3>
                    <h2><?= $post->introduction; ?></h2>

                </header>



                <figure>

                    <p class="text-center"><img src="   " alt="" class="img-responsive" /></p>

                </figure>



                <div class="enter-content">

                    <p><?= $post->content; ?></p>

                    <a href="?action=listPosts" target="_blank" class="btn btn-red my-5">Retourner aux actus</a>

                </div>

            </article>



            <!-- Comments -->

            <div class="comments-pan">

                <h3>3 commentaires</h3>

                <ul class="comments-reply">
                    <?php
/*                    $idPost = $_GET['id'];

                    while ($comment = $comments->fetch())
                    {
                        $text = nl2br(htmlspecialchars($comment['commentaire'])) ;

                        */?><!--

                        <li>

                            <figure>

                                <img src="../public/images/blog-images/image-1.jpg" alt="" class="img-responsive"/>

                            </figure>

                            <section>

                                <h4><?/*= htmlspecialchars($comment['auteur']) */?></h4>

                                <div class="date-pan"><?/*= $comment['comment_date_fr'] */?></div>
                                <?/*= $text */?>

                            </section>

                        </li>
                        --><?php
/*                    }
                    */?>

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