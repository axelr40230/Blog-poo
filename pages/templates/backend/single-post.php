<?php

use App\App;

?>
<!-- Begin Page Content -->
<div class="container-fluid">

    <div class="row">

        <section class="col-12 col-md-8">

            <!-- Edit post -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h1 class="h3 mb-2 text-gray-800"><?= $pageTitle ?> - <a
                                href="<?= App::url('posts') ?>/<?= $post->slug; ?>">Voir l'article</a></h1>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <form action="" method="post">
                                <div class="p-2">
                                    <?= $form->label('title', 'Modifier le titre'); ?>
                                    <?= $form->input('title', 'form-control', 'text', 'title', $pageTitle, $pageTitle); ?>
                                </div>
                                <div class="p-2">
                                    <?= $form->label('slug', 'Modifier le permalien'); ?>
                                    <?= $form->input('slug', 'form-control', 'text', 'slug', $post->slug, $post->slug); ?>
                                </div>
                                <div class="p-2">
                                    <?= $form->label('introduction', 'Modifier l\'introduction'); ?>
                                    <?= $form->input('introduction', 'form-control', 'text', 'introduction', $post->introduction, $post->introduction); ?>
                                </div>
                                <div class="p-2">
                                    <?= $form->label('content', 'Modifier le contenu'); ?>
                                    <?= $form->textarea($post->content, 'content'); ?>
                                </div>
                        </div>
                    </div>
                </div>
            </div>

        </section>
        <section class="col-12 col-md-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h2 class="h3 mb-2 text-gray-800">Informations sur l'article</h2>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <p>
                                Créé le <?= $post->date_fr('exact', 'created_at'); ?><br/>
                                Statut : <?= $status ?><br/>
                                <?php if ($post->status == 'intrash') : ?>
                                    <a class="text-danger"
                                       href="<?= App::url('admin/posts/delete') ?>/<?= $post->slug; ?>">Supprimer
                                        définitivement</a><br/>
                                <?php endif; ?>
                                Dernière modification le <?= $post->date_fr('exact', 'modify_at'); ?><br/>
                                Auteur : <?= $author->first_name . ' ' . $author->last_name; ?>
                            </p>
                            <?php if ($post->status == 'draft') : ?>

                                <?= $form->submit('Mettre à jour', 'update', 'btn btn-primary w-100', 'publish'); ?>

                                <?= $form->submit('Publier', 'update', 'btn btn-success w-100', 'publish'); ?>

                                <?= $form->submit('Mettre à  la corbeille', 'update', 'btn btn-danger w-100', 'intrash'); ?>


                            <?php elseif ($post->status == 'publish') : ?>

                                <?= $form->submit('Mettre à jour', 'update', 'btn btn-primary w-100', 'publish'); ?>

                                <?= $form->submit('Enregistrer en tant que brouillon', 'update', 'btn btn-light w-100', 'draft'); ?>

                                <?= $form->submit('Mettre à  la corbeille', 'update', 'btn btn-danger w-100', 'intrash'); ?>


                            <?php elseif ($post->status == 'intrash') : ?>

                                <?= $form->submit('Mettre à jour', 'update', 'btn btn-primary w-100', 'publish'); ?>

                                <?= $form->submit('Enregistrer en tant que brouillon', 'update', 'btn btn-light w-100', 'draft'); ?>

                                <?= $form->submit('Publier', 'update', 'btn btn-success w-100', 'publish'); ?>
                                </form>
                            <?php endif; ?>
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