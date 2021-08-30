<?php

use App\App;

?>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800 py-5 text-center">
        <?= $pageTitle; ?>
    </h1>

    <?php if ($posts) : ?>


        <!-- DataTales Example -->
        <div class="card shadow mb-4">

            <div class="card-body">
                <h2 class="py-3 small text-success"><?= $countPosts; ?> parmi les articles</h2>
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>Titre de l'article</th>
                            <th>Statut</th>
                            <th>Auteur</th>
                            <th>Date d'ajout</th>
                            <th>Editer</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>Titre de l'article</th>
                            <th>Statut</th>
                            <th>Auteur</th>
                            <th>Date d'ajout</th>
                            <th>Editer</th>
                        </tr>
                        </tfoot>

                        <tbody>
                        <?php foreach ($posts as $post) : ?>
                            <tr>
                                <td><a class="text-info"
                                       href="<?= App::url('posts') ?>/<?= $post->slug; ?>"><?= $post->title; ?></a></td>
                                <td>
                                    <?= $translator($post->status); ?>
                                </td>
                                <td><a class="text-info"
                                       href="<?= App::url('admin/users') ?>/<?= $post->author->id; ?>"><?php
                                        echo $post->author->first_name . ' ' . $post->author->last_name;
                                        ?></a></td>
                                <td>
                                    <?php $date = $post->date_fr('exact', 'created_at');

                                    ?>
                                    Le <?= $date; ?>
                                </td>
                                <td>
                                    <a class="text-info" href="<?= App::url('admin/posts/edit') ?>/<?= $post->slug; ?>">Modifier</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    <?php endif;

    if ($users) : ?>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">

            <div class="card-body">
                <h2 class="py-3 small text-success"><?= $countUsers; ?> parmi les utilisateurs</h2>
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Email</th>
                            <th>Statut</th>
                            <th>Date d'ajout</th>
                            <th>Editer</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Email</th>
                            <th>Statut</th>
                            <th>Date d'ajout</th>
                            <th>Editer</th>
                        </tr>
                        </tfoot>

                        <tbody>
                        <?php foreach ($users as $user) : ?>
                            <tr>
                                <td><?= $user->last_name; ?></td>
                                <td><?= $user->first_name; ?></td>
                                <td><a class="text-info" href="mailto:<?= $user->email; ?>"><?= $user->email; ?></a>
                                </td>
                                <td>
                                    <?= $user->status; ?>
                                </td>
                                <td>
                                    <?php $date = $user->date_fr('exact', 'created_at');

                                    ?>
                                    Le <?= $date; ?>
                                </td>
                                <td>
                                    <a class="text-info" href="<?= $user->url(); ?>">Modifier</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    <?php endif; ?>

    <?php if ($comments) : ?>


        <!-- DataTales Example -->
        <div class="card shadow mb-4">

            <div class="card-body">
                <h2 class="py-3 small text-success"><?= $countComments; ?> parmi les commentaires</h2>
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>Auteur</th>
                            <th>Article lié</th>
                            <th>Statut</th>
                            <th>Date d'ajout</th>
                            <th>Editer</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>Auteur</th>
                            <th>Article lié</th>
                            <th>Statut</th>
                            <th>Date d'ajout</th>
                            <th>Editer</th>
                        </tr>
                        </tfoot>

                        <tbody>
                        <?php foreach ($comments as $comment) : ?>
                            <tr>
                                <td><a class="text-info"
                                       href="<?= App::url('admin/users') ?>/<?= $comment->author->id; ?>"><?php
                                        echo $comment->author->first_name . ' ' . $comment->author->last_name;
                                        ?></a></td>
                                <td><a class="text-info"
                                       href="<?= App::url('posts') ?>/<?= $comment->article_id; ?>"><?= $comment->article_id; ?></a>
                                </td>
                                <td><?= $translator($comment->status); ?></td>
                                <td>
                                    <?php $date = $comment->date_fr('exact', 'created_at');

                                    ?>
                                    Le <?= $date; ?>
                                </td>
                                <td>
                                    <a class="text-info" href="<?= $comment->url(); ?>">Consulter</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    <?php endif; ?>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->