<?php
use App\App;
use App\Form;

$form = new Form(array());
$trad = new App();

?>
<!-- Begin Page Content -->
<div class="container-fluid">

    <div class="row">

        <section class="col-12">

            <!-- Edit post -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h1 class="h3 mb-2 text-gray-800">
                        <?php $trad->translate($pageTitle); ?>
                    </h1>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <form action="" method="post">
                                <div class="p-2">
                                <?php echo $form->label('title','Votre titre'); ?>
                                <?php echo $form->input('title','w-100', 'text','title', 'email'); ?>

                                </div>
                                <div class="p-2">
                                <?php echo $form->label('introduction','Ajouter une introduction'); ?>
                                <?php echo $form->input('introduction','w-100','text', 'introduction'); ?>
                                </div>
                                <div class="p-2">
                                <?php echo $form->label('content','Modifier le contenu'); ?>
                                <?php echo $form->textarea('', 'content'); ?>
                                </div>
                                <div class="p-2">
                                    <?php echo $form->submit('Enregistrer en tant que brouillon', 'insert', 'btn btn-light w-100'); ?>
                                    <?php echo $form->submit('Publier', 'insert', 'btn btn-success w-100'); ?>
                                </div>

                            </form>
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