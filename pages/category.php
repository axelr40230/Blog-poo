    <!-- main -->

    <?php

    $db = new   \App\Database('blogpoo');
    ?>

    <main role="main-inner-wrapper" class="container">



        <div class="row my-5">



            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 ">

                <article role="pge-title-content" class="blog-header">

                    <header>

                        <h2><span>Actus</span> A vous de jouer</h2>

                    </header>

                    <p>Connectez-vous ou créez un compte pour partager vos propres actus</p>

                    <a href="" target="_blank" class="btn btn-red my-5">S'identifier</a>

                    <p>OU commencez à lire les dernières actus dès à présent<br/><br/>
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

                                <img src="../public/images/blog-images/blog-1.jpg" alt=""/>

                            </figure>

                        </section>

                    </li>

                </ul>

            </div>


        </div>
        <div class="row">

            <!--- posts --->

            <?php foreach ($db->query('SELECT * FROM articles', 'App\Table\Article') as $post) : ?>
                <?php
            //var_dump($post);
                //$id = $post['id'];
                ?>

                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">

                    <ul class="grid-lod effect-2" id="grid">

                        <li>

                            <section class="blog-content">

                                <a href="<?= $post->url; ?>">

                                    <figure>

                                        <div class="post-date">

                                            <span>date</span> date

                                        </div>

                                        <?php //if(isset($post['image'])) : ?>

                                            <img src="" alt="" class="img-responsive"/>

                                        <?php //else : ?>

                                            <img src="../public/images/blog-images/blog-1.jpg" alt="" class="img-responsive"/>

                                        <?php //endif; ?>

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
