<?php

use App\App;
use App\Form;

$form = new Form(array());
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
                                <?php if ($comment->status == 'waiting') : ?>

                                    <?= $form->submit('Publier', 'update', 'btn btn-success w-100', 'approuved'); ?>

                                    <?= $form->submit('Mettre à  la corbeille', 'update', 'btn btn-danger w-100', 'intrash'); ?>


                                <?php elseif ($comment->status == 'approuved') : ?>

                                    <?= $form->submit('Mettre en attente d\'approbation', 'update', 'btn btn-light w-100', 'waiting'); ?>

                                    <?= $form->submit('Mettre à  la corbeille', 'update', 'btn btn-danger w-100', 'intrash'); ?>


                                <?php elseif ($comment->status == 'intrash') : ?>

                                <?= $form->submit('Mettre en attente d\'approbation', 'update', 'btn btn-light w-100', 'waiting'); ?>

                                <?= $form->submit('Publier', 'update', 'btn btn-success w-100', 'approuved'); ?>
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
                                Créé le <?= $comment->date_fr('exact', 'created_at'); ?><br/>
                                Statut : <?= $translator($comment->status); ?><br/>
                                Auteur : <?= $comment->author->first_name . ' ' . $comment->author->last_name; ?><br/>
                                Article : <?= $comment->article_id->title; ?> - <a class="text-info" href="<?= App::url('admin/posts/edit') ?>/<?= $comment->article_id->slug; ?>">Modifier l'article</a>
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