<!-- main -->

<main role="main-inner-wrapper" class="container">


    <div class="row">


        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 ">

            <article role="pge-title-content" class="contact-header">

                <header>
                    <h1><?= $pageTitle; ?></h1>
                    <h2><span>Promis</span> Je ne mords pas.</h2>
                    <?= $text ?>

                </header>

                <p><a href="tel:+3365482234"><i class="fa fa-phone" aria-hidden="true"></i> +33 6 85 48 22 34</a><a
                            href="mailto:axelr.apl@gmail.com"><i class="fa fa-envelope" aria-hidden="true"></i>
                        axelr.apl@gmail.com</a></p>

            </article>

        </div>

        <!-- map -->

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">

            <div class="demo-wrapper">

                <div id="surabaya">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d46216.59720731598!2d-1.2895078608004389!3d43.61617424549602!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd514d8632f87867%3A0x1bc6d631c0901be9!2s40230%20Saint-Jean-de-Marsacq!5e0!3m2!1sfr!2sfr!4v1615027159660!5m2!1sfr!2sfr"
                            width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                </div>

            </div>

        </div>

        <!-- map -->

        <div class="clearfix"></div>


        <!-- contact-from-wrapper -->

        <div class="contat-from-wrapper">

            <div id="message"></div>

            <form method="post" action="" name="cform" id="cform">
                <?= $validator->csrf(); ?>
                <p><?= $validator->errorToken('_token'); ?></p>
                <div class="row">

                    <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">

                        <?= $form->input('name', '', 'text', 'name', 'Quel est votre nom ?'); ?>

                    </div>

                    <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">

                        <?= $form->input('email', '', 'email', 'email', 'Et votre email ?'); ?>
                        <?= $validator->error('email'); ?>

                    </div>

                </div>

                <div class="clearfix"></div>

                <?= $form->textarea('', 'message', 'Un petit mot ?'); ?>

                <div class="clearfix"></div>

                <div class="text-center">

                    <?= $form->submit('C\'est parti !!', 'send-message', 'btn btn-red my-5', 'send-message'); ?>

                </div>


                <div id="simple-msg"></div>

            </form>

        </div>

        <!-- contact-from-wrapper -->


    </div>

</main>

<!-- main -->