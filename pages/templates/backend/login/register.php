<?php

use App\Form;

$form = new Form(array());

?>

<div class="container">

    <div class="card o-hidden border-0 shadow-lg my-5 bg-white">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
                <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
                <div class="col-lg-7">
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">Créer un compte !</h1>
                        </div>
                        <form class="user" action="" method="post">
                            <?= $validator->csrf(); ?>
                            <!-- <input type="hidden" name="_token" value="zofhozjgozgj" /> -->
                            <p><?= $validator->errorToken('_token'); ?></p>


                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <?= $form->input('first_name', 'w-100 form-control form-control-user', 'text', 'first_name', 'Votre prénom', $validator->old('firstname')); ?>
                                    <?= $validator->error('first_name'); ?>
                                </div>
                                <div class="col-sm-6">
                                    <?= $form->input('last_name', 'w-100 form-control form-control-user', 'text', 'last_name', 'Votre nom', $validator->old('firstname')); ?>
                                    <?= $validator->error('last_name'); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <?= $form->input('email', 'w-100 form-control form-control-user', 'email', 'email', 'Votre email', $validator->old('firstname')); ?>
                                <?= $validator->error('email'); ?>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <?= $form->input('password', 'w-100 form-control form-control-user', 'password', 'password', 'Saisissez un mot de passe'); ?>
                                    <?= $validator->error('password'); ?>
                                </div>
                                <div class="col-sm-6">
                                    <?= $form->input('password_confirmed', 'w-100 form-control form-control-user', 'password', 'password_confirmed', 'Confirmez le mot de passe'); ?>
                                </div>
                            </div>
                            <?= $form->submit('S\'enregistrer', 'register', 'btn btn-primary btn-user btn-block', 'register'); ?>
                        </form>
                        <hr>
                        <div class="text-center">
                            <a class="small" href="forgot-password">Mot de passe oublié ?</a>
                        </div>
                        <div class="text-center">
                            <a class="small" href="login">J'ai déjà un compte... Je me connecte !</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>