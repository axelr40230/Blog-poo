<?php

use App\App;
use App\Form;

$form = new Form(array());

?>

<div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

        <div class="col-xl-10 col-lg-12 col-md-9">

            <div class="card o-hidden border-0 shadow-lg my-5 bg-white">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                        <div class="col-lg-6">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Bon retour parmi nous !</h1>
                                </div>
                                <?php if($errors) : ?>
                                    <div class="alert alert-danger text-center" role="alert">
                                        <?= $errors ?>
                                    </div>
                                <?php endif; ?>
                                <form class="user" action="" method="post">
                                    <div class="form-group">
                                        <?php echo $form->input('email','w-100 form-control form-control-user', 'text','email', 'Votre email'); ?>
                                    </div>
                                    <div class="form-group">
                                        <?php echo $form->input('password','w-100 form-control form-control-user', 'password','password', 'Votre mot de passe'); ?>
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox small">
                                            <?php echo $form->input('remember','custom-control-input', 'checkbox','remember '); ?>
                                            <?php echo $form->label('remember','Se souvenir de moi', 'custom-control-label'); ?>
                                        </div>
                                    </div>
                                    <?php echo $form->submit('Se connecter', 'connect', 'btn btn-primary btn-user btn-block'); ?>
                                </form>
                                <hr>
                                <div class="text-center">
                                    <a class="small" href="forgot-password">Mot de passe oublié ?</a>
                                </div>
                                <div class="text-center">
                                    <a class="small" href="register">Créer un compte</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row text-center">
                <div class="col-12">
                    <a class="btn btn-dark btn-user" href="<?= App::url('') ?>">Retourner sur le site</a>
                </div>
            </div>

        </div>

    </div>

</div>