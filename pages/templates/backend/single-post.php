<?php
use App\App;
use App\Form;
use App\Table\UserTable;


$status = new App();
$status_post = $post->status;
$form = new Form(array());

$infos = new UserTable();
$id_author = $post->author;
$author = $infos->author($id_author);
//var_dump($form);

$date = $post->date_fr('exact', 'created_at');
$dateModify = $post->date_fr('exact', 'modify_at');
?>
<!-- Begin Page Content -->
<div class="container-fluid">

    <div class="row">

        <section class="col-12 col-md-8">

            <!-- Edit post -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h1 class="h3 mb-2 text-gray-800"><?= $pageTitle ?> - <a href="<?= App::url('posts') ?>/<?= $post->id; ?>">Voir l'article</a></h1>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <form action="" method="post">
                                <div class="p-2">
                                <?php echo $form->label('title','Modifier le titre'); ?>
                                <?php echo $form->input('title','form-control', 'text','title', $pageTitle); ?>

                                </div>
                                <div class="p-2">
                                <?php echo $form->label('introduction','Modifier l\'introduction'); ?>
                                <?php echo $form->input('introduction','form-control','text', 'introduction', $post->introduction); ?>
                                </div>
                                <div class="p-2">
                                <?php echo $form->label('content','Modifier le contenu'); ?>
                                <?php echo $form->textarea($post->content, 'content'); ?>
                                </div>



                        </div>
                    </div>
                </div>
            </div>

        </section>
        <section class="col-12 col-md-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h2 class="h3 mb-2 text-gray-800">Informations sur l'article</h2>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <p>
                                Créé le <?= $date; ?><br/>
                                Statut : <?php
                                $trad = $status->translate($post->status);
                                echo $trad;
                                ?><br/>
                                Dernière modification le <?= $dateModify; ?><br/>
                                Auteur : <?= $author->first_name.' '.$author->last_name; ?>
                            </p>
                                <?php if($status_post == 'draft') : ?>

                                    <?php echo $form->submit('Mettre à jour', 'update', 'btn btn-primary w-100'); ?>
                                    <a href="#" class="btn btn-success btn-icon-split">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-check"></i>
                                        </span>
                                        <span class="text">Split Button Success</span>
                                    </a>

                                    <?php echo $form->input('publish','form-control','hidden', 'status', 'publish'); ?>
                                    <?php echo $form->submit('Publier', 'update', 'btn btn-success w-100'); ?>


                                    <?php echo $form->input('intrash','w-100','hidden', 'status', 'intrash'); ?>
                                    <?php echo $form->submit('Mettre à  la corbeille', 'update', 'btn btn-danger w-100'); ?>


                                <?php elseif($status_post == 'publish') : ?>

                                    <?php echo $form->submit('Mettre à jour', 'update', 'btn btn-primary w-100'); ?>

                                    <?php echo $form->input('draft','w-100','hidden', 'status', 'draft'); ?>
                                    <?php echo $form->submit('Enregistrer en tant que brouillon', 'update', 'btn btn-light w-100'); ?>



                                    <?php echo $form->input('intrash','w-100','hidden', 'status', 'intrash'); ?>
                                    <?php echo $form->submit('Mettre à  la corbeille', 'update', 'btn btn-danger w-100'); ?>


                                <?php elseif($status_post == 'intrash') : ?>

                                    <?php echo $form->submit('Mettre à jour', 'update', 'btn btn-primary w-100'); ?>

                                    <?php echo $form->input('draft','w-100','hidden', 'status', 'draft'); ?>
                                    <?php echo $form->submit('Enregistrer en tant que brouillon', 'update', 'btn btn-light w-100'); ?>



                                    <?php echo $form->input('publish','w-100','hidden', 'status', 'publish'); ?>
                                    <?php echo $form->submit('Publier', 'update', 'btn btn-success w-100'); ?>
                                </form>
                            <?php endif; ?>
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