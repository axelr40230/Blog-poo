<?php
use App\App;
use App\Form;
$form = new Form(array());
//var_dump($comment);

use App\Table\UserTable;
use App\Table\PostTable;


$status = new App();
$status_comment = $comment->status;
$form = new Form(array());

$authorInfos = new UserTable();
$id_author = $comment->author;
$author = $authorInfos->author($id_author);
//var_dump($form);

$date = $comment->date_fr('exact', 'created_at');

$table = new PostTable();
$postId = $comment->article_id;
$post = $table->one($postId);


?>
<!-- Begin Page Content -->
<div class="container-fluid">

    <div class="row">

        <section class="col-12 col-md-8">

            <!-- Edit post -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h1 class="h3 mb-2 text-gray-800"><?= $pageTitle ?></h1>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <p><?= $comment->comment ?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <form action="" method="post">
                                <?php if ($status_comment == 'waiting') : ?>

                                    <?php echo $form->submit('Publier', 'update', 'btn btn-success w-100', 'approuved'); ?>

                                    <?php echo $form->submit('Mettre à  la corbeille', 'update', 'btn btn-danger w-100', 'intrash'); ?>


                                <?php elseif ($status_comment == 'approuved') : ?>

                                    <?php echo $form->submit('Mettre en attente d\'approbation', 'update', 'btn btn-light w-100', 'waiting'); ?>

                                    <?php echo $form->submit('Mettre à  la corbeille', 'update', 'btn btn-danger w-100', 'intrash'); ?>


                                <?php elseif ($status_comment == 'intrash') : ?>

                                <?php echo $form->submit('Mettre en attente d\'approbation', 'update', 'btn btn-light w-100', 'waiting'); ?>

                                <?php echo $form->submit('Publier', 'update', 'btn btn-success w-100', 'approuved'); ?>
                            </form>
                            <?php endif; ?>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="col-12 col-md-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h2 class="h3 mb-2 text-gray-800">Informations sur le commentaire</h2>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <p>
                                Créé le <?= $date; ?><br/>
                                Statut : <?php
                                $trad = $status->translate($comment->status);
                                echo $trad;
                                ?><br/>
                                Auteur : <?= $author->first_name.' '.$author->last_name; ?><br/>
                                Article : <?= $post->title; ?> - <a class="text-info" href="<?= App::url('admin/posts/edit') ?>/<?= $post->slug; ?>">Modifier l'article</a>
                            </p>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>





</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->