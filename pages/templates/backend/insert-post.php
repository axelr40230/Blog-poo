<?php

use App\App;

?>
<!-- Begin Page Content -->
<div class="container-fluid">

    <div class="row">

        <section class="col-12 col-md-6">

            <!-- Edit post -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h1 class="h3 mb-2 text-gray-800">
                        <?= $pageTitle ?>
                    </h1>
                    <?php if ($errors) : ?>
                        <div class="alert alert-danger text-center" role="alert">
                            <?= $errors ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <form action="" method="post">
                                <div class="p-2">
                                    <?= $form->label('title', 'Votre titre'); ?>
                                    <?= $form->input('title', 'form-control', 'text', 'title', 'Donnez un joli titre à votre article'); ?>
                                </div>
                                <div class="p-2">
                                    <?= $form->label('introduction', 'Ajouter une introduction'); ?>
                                    <?= $form->input('introduction', 'form-control', 'text', 'introduction', 'Une petite introduction pour donner envie de lire la suite'); ?>
                                </div>
                                <div class="p-2">
                                    <?= $form->label('content', 'Modifier le contenu'); ?>
                                    <?= $form->textarea('', 'content'); ?>
                                </div>
                                <div class="p-2">
                                    <?= $form->submit('Enregistrer en tant que brouillon', 'insert', 'btn btn-light w-100', 'draft'); ?>
                                    <?= $form->submit('Publier', 'insert', 'btn btn-success w-100', 'publish'); ?>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </section>
        <section class="col-12 col-md-6 d-none d-md-block">
            <div class="dog-write">
                <img src="<?= App::url('') ?>/public/images/admin/dog-write.jpg" alt="Rédiger un article" class="w-100">
            </div>

        </section>

    </div>


</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->