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
                            <td><a class="text-info" href="mailto:<?= $user->email; ?>"><?= $user->email; ?></a></td>
                            <td>
                                <?= $user->status; ?>
                            </td>
                            <td>
                                Le <?= $user->created_at; ?>
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

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->