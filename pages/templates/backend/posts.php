<?php
use App\App;
use App\Table\UserTable;

$status = new App();


?>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">
        <?= $pageTitle; ?>
    </h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">

        <div class="card-body">
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
                        <td><a class="text-info" href="<?= App::url('posts') ?>/<?= $post->id; ?>"><?= $post->title; ?></a></td>
                        <td>
                            <?= $trad = $status->translate($post->status); ?>
                        </td>
                        <td><a class="text-info" href="<?= App::url('admin/users') ?>/<?= $post->author; ?>"><?php
                            $infos = new UserTable();
                            $id_author = $post->author;
                                $author = $infos->author($id_author);
                            echo $author->first_name.' '.$author->last_name;
                                ?></a></td>
                        <td>
                            <?php $date = $post->date_fr('exact', 'created_at');

                            ?>
                            Le <?= $date; ?>
                        </td>
                        <td>
                            <a class="text-info" href="<?= $post->url(); ?>">Modifier</a>
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