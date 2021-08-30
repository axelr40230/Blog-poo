<?php

use App\App;


?>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">
        Tous les <?= $pageTitle; ?>
    </h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">

        <div class="card-body">
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

    <nav>
        <ul class="pagination">
            <!-- Lien vers la page précédente (désactivé si on se trouve sur la 1ère page) -->
            <li class="page-item <?= ($currentPage == 1) ? "disabled" : "" ?>">
                <a href="<?= App::url('admin/comments') ?>?page=<?= $currentPage - 1 ?>" class="page-link">Précédente</a>
            </li>
            <?php for($page = 1; $page <= $pages; $page++): ?>
                <!-- Lien vers chacune des pages (activé si on se trouve sur la page correspondante) -->
                <li class="page-item <?= ($currentPage == $page) ? "active" : "" ?>">
                    <a href="<?= App::url('admin/comments') ?>?page=<?= $page ?>" class="page-link"><?= $page ?></a>
                </li>
            <?php endfor ?>
            <!-- Lien vers la page suivante (désactivé si on se trouve sur la dernière page) -->
            <li class="page-item <?= ($currentPage == $pages) ? "disabled" : "" ?>">
                <a href="<?= App::url('admin/comments') ?>?page=<?= $currentPage + 1 ?>" class="page-link">Suivante</a>
            </li>
        </ul>
    </nav>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->