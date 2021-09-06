<?php

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
                        <div class="col-lg-6 d-none d-lg-block bg-password-image"></div>
                        <div class="col-lg-6">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-2"><?= $pageTitle; ?></h1>
                                    <p class="mb-4"><?= $text; ?></p>
                                </div>
                                <form class="user" action="" method="post">
                                    <?= $validator->csrf(); ?>
                                    <p><?= $validator->errorToken('_token'); ?></p>

                                    <div class="form-group">

                                        <?= $form->input('email','w-100 form-control form-control-user', 'email','email', 'Entrer votre adresse mail...'); ?>
                                        <?= $validator->error('email'); ?>
                                    </div>

                                    <?= $form->submit('Réinitialiser le mot de passe', 'ForgotPass', 'btn btn-primary btn-user btn-block', 'ForgotPass'); ?>

                                </form>
                                <hr>
                                <div class="text-center">
                                    <a class="small" href="register">Créer un compte</a>
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

    </div>

</div>