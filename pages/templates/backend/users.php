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
                        <th>Prénom Nom</th>
                        <th>Email</th>
                        <th>Date d'ajout</th>
                        <th>Editer</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Date d'ajout</th>
                        <th>Editer</th>
                    </tr>
                    </tfoot>

                    <tbody>
                    <?php foreach ($users as $user) : ?>
                        <tr>
                            <td><?= $user->first_name; ?> <?= $user->last_name; ?></td>
                            <td><a class="text-info" href="mailto:<?= $user->email; ?>"><?= $user->email; ?></a></td>

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