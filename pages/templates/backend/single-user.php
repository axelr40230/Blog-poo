<?php

use App\App;

?>
<!-- Begin Page Content -->
<div class="container-fluid">

    <div class="row">

        <section class="col-12 col-md-6">

            <!-- Edit user -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h1 class="h3 mb-2 text-gray-800"><?= $user->first_name . ' ' . $user->last_name ?></h1>
                    <h2 class=text-xs>Date d'inscription : <?= $date ?></h2>
                    <h3 class=text-xs>Statut : <?= $translator($user->status) ?></h3>
                    <a class="text-danger" href="<?= App::url('admin/users/delete') ?>/<?= $user->id; ?>">Supprimer
                        l'utilisateur</a><br/>

                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <form action="" method="post">
                                <div class="p-2">
                                    <?= $form->label('last_name', 'Modifier le nom'); ?>
                                    <?= $form->input('last_name', 'form-control', 'text', 'last_name', $user->last_name, $user->last_name); ?>
                                </div>
                                <div class="p-2">
                                    <?= $form->label('first_name', 'Modifier le prénom'); ?>
                                    <?= $form->input('first_name', 'form-control', 'text', 'first_name', $user->first_name, $user->first_name); ?>
                                </div>
                                <div class="p-2">
                                    <?= $form->label('email', 'Modifier l\'email'); ?>
                                    <?= $form->input('email', 'form-control', 'text', 'email', $user->email, $user->email); ?>
                                </div>
                                <div class="p-2">
                                    <div class="form-group">
                                        <?= $form->label('status', 'Modifier le statut'); ?>
                                        <?= $form->select('users','status', $user->status, 'enumeration'); ?>
                                    </div>
                                </div>
                                <div class="p-2">
                                    <?php //echo $form->input('publish','w-100','hidden', 'send', 'publish','publish'); ?>
                                    <?= $form->submit('Mettre à jour', 'update', 'btn btn-primary', 'publish'); ?>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
        </section>

        <section class="col-12 col-md-6 d-none d-md-block">
            <div class="dog-write">
                <img src="<?= App::url('') ?>/public/images/admin/dog-hero.jpg" alt="Rédiger un article">
            </div>

        </section>

    </div>


</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->