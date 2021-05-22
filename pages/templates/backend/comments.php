<?php
use App\App;
use App\Table\UserTable;

$status = new App();
$trad = new App();

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
                        <td><a class="text-info" href="<?= App::url('admin/users') ?>/<?= $comment->author; ?>"><?php
                            $infos = new UserTable();
                            $id_author = $comment->author;
                            $author = $infos->author($id_author);
                            echo $author->first_name.' '.$author->last_name;
                                ?></a></td>
                        <td><a class="text-info" href="<?= App::url('posts') ?>/<?= $comment->article_id; ?>"><?= $comment->article_id; ?></a></td>
                        <td><?= $trad = $status->translate($comment->status); ?></td>
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

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->