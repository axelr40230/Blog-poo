<?php
use App\Form;
$form = new Form(array());
?>
<!-- Begin Page Content -->
<div class="container-fluid">

    <div class="row">

        <section class="col-12 col-md-8">

            <!-- Edit user -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h1 class="h3 mb-2 text-gray-800"><?= $user->first_name.' '.$user->last_name ?></h1>
                </div>
                <div class="card-body">
                    <div class="row">
                        <d class="col-12">
                            <form action="" method="post">
                                <div class="p-2">
                                    <?php echo $form->label('last_name','Modifier le nom'); ?>
                                    <?php echo $form->input('last_name','w-100', 'text','last_name', $user->last_name); ?>
                                </div>
                                <div class="p-2">
                                    <?php echo $form->label('first_name','Modifier le prénom'); ?>
                                    <?php echo $form->input('first_name','w-100', 'text','first_name', $user->first_name); ?>
                                </div>
                                <div class="p-2">
                                    <?php echo $form->label('email','Modifier l\'email'); ?>
                                    <?php echo $form->input('email','w-100', 'text','email', $user->email); ?>
                                </div>
                                <div class="p-2">
                                    <?php echo $form->submit('Mettre à jour', 'update', 'btn btn-primary w-100'); ?>
                                </div>

                        </div>
                    </div>
                </div>

        </section>

        <section class="col-12 col-md-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h2 class="h3 mb-2 text-gray-800">Informations sur l'utilisateur</h2>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <p>

                            </p>

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