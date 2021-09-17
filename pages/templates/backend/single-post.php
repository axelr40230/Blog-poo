<?php

use App\App;

?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <div class="row">

        <section class="col-12 col-md-8">
            <form action="" method="post">
                <!-- Edit post -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h1 class="h3 mb-2 text-gray-800"><?= $pageTitle ?> - <a
                                    href="<?= App::url('posts') ?>/<?= $post->slug; ?>">Voir l'article</a></h1>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">

                                <div class="form-group">
                                    <?= $form->label('title', 'Titre'); ?>
                                    <?= $form->input('title', 'form-control', 'text', 'title', $pageTitle, $pageTitle); ?>
                                </div>

                                <div class="form-group">
                                    <?= $form->label('slug', 'Permalien'); ?>
                                    <?= $form->input('slug', 'form-control', 'text', 'slug', $post->slug, $post->slug); ?>
                                    <div class="py-2 mx-3">
                                        <?= $form->input('checkSlug', '', 'checkbox', 'checkSlug', '', 'checkSlug'); ?>
                                        <?= $form->label('checkSlug', 'Pour modifier le slug, merci de cocher cette case', 'text-info'); ?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <?= $form->label('author', 'Auteur'); ?>
                                    <?= $form->select('posts', 'author', $author->first_name . ' ' . $author->last_name, 'compare', 'status', 'users', ['status' => 'admin', 'orderBy' => 'status'], ['first' => 'first_name', 'second' => 'last_name']); ?>
                                </div>

                                <div class="form-group">
                                    <?= $form->label('introduction', 'Introduction'); ?>
                                    <?= $form->input('introduction', 'form-control', 'text', 'introduction', $post->introduction, $post->introduction); ?>
                                </div>

                                <div class="form-group">
                                    <?= $form->label('content', 'Contenu'); ?>
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
                                Statut : <?= $translator($post->status); ?><br/>
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

                            <?php endif; ?>
                        </div>
                    </div>

                </div>
            </div>
            </form>
        </section>
    </div>


</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->