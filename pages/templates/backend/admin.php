<?php

use App\App;

?>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tableau de bord</h1>

    </div>

    <!-- Content Row -->
    <div class="row">

        <!-- SESSION -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Bienvenue
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $user->first_name; ?> <?= $user->last_name; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-door-open fa-2x text-gray-300"></i>
                        </div>
                    </div>
                    <div class="row py-3">
                        <a href="<?= App::url('admin/users/') ?><?= $user->id; ?>" class="btn btn-primary">Gérer mon
                            compte</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- UTILISATEURS -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Nombre d'utilisateurs
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $numberUsers; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-skating fa-2x text-gray-300"></i>
                        </div>
                    </div>
                    <div class="row py-3">
                        <a href="<?= App::url('admin/users') ?>" class="btn btn-success">Gérer les utilisateurs</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- ARTICLES -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Nombre d'articles
                                publiés
                            </div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?= $numberPosts; ?></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                    <div class="row py-3">
                        <a href="<?= App::url('admin/posts') ?>" class="btn btn-info">Gérer les articles</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- COMMENTAIRES -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Nombre de commentaires à approuver
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $numberComments; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-comments fa-2x text-gray-300"></i>
                        </div>
                    </div>
                    <div class="row py-3">
                        <a href="<?= App::url('admin/comments') ?>" class="btn btn-warning">Gérer les commentaires</a>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->