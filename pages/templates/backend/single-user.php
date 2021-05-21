<?php
use App\App;
use App\Form;
$form = new Form(array());

$status = new App();
$status_post = $user->status;

$date = $user->date_fr('exact', 'created_at');
//var_dump($user);
?>
<!-- Begin Page Content -->
<div class="container-fluid">

    <div class="row">

        <section class="col-12 col-md-6">

            <!-- Edit user -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h1 class="h3 mb-2 text-gray-800"><?= $user->first_name.' '.$user->last_name ?></h1>
                    <h2 class=text-xs>Date d'inscription : <?= $date ?></h2>
                    <h3 class=text-xs>Statut : <?php
                        $trad = $status->translate($user->status);
                        echo $trad;
                        ?></h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <d class="col-12">
                            <form action="" method="post">
                                <div class="p-2">
                                    <?php echo $form->label('last_name','Modifier le nom'); ?>
                                    <?php echo $form->input('last_name','form-control', 'text','last_name', $user->last_name, $user->last_name); ?>
                                </div>
                                <div class="p-2">
                                    <?php echo $form->label('first_name','Modifier le prénom'); ?>
                                    <?php echo $form->input('first_name','form-control', 'text','first_name', $user->first_name, $user->first_name); ?>
                                </div>
                                <div class="p-2">
                                    <?php echo $form->label('email','Modifier l\'email'); ?>
                                    <?php echo $form->input('email','form-control', 'text','email', $user->email, $user->email); ?>
                                </div>
                                <div class="p-2">
                                    <?php echo $form->label('password','Modifier le mot de passe'); ?>
                                    <?php echo $form->input('password','form-control', 'password','password'); ?>
                                </div>
                                <div class="p-2">
                                    <?php echo $form->label('password','Confirmer le mot de passe'); ?>
                                    <?php echo $form->input('password','form-control', 'password','password'); ?>
                                </div>
                                <div class="p-2">
                                        <?php echo $form->input('publish','w-100','hidden', 'status', 'publish','publish'); ?>
                                        <?php echo $form->submit('Mettre à jour', 'update', 'btn btn-primary'); ?>
                                </div>

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