<?php

use App\App;

?>
<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= App::url('admin') ?>">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Blog P5|OC</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="<?= App::url('admin') ?>">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Tableau de bord</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Blog
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
           aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-feather"></i>
            <span>Articles</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Gérer les articles</h6>
                <a class="collapse-item" href="<?= App::url('admin/posts') ?>">Tous les articles</a>
                <a class="collapse-item" href="<?= App::url('admin/posts/insert') ?>">Ajouter un article</a>
                <!--                <a class="collapse-item" href="cards.html">Catégories</a>-->
            </div>
        </div>
    </li>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseThree"
           aria-expanded="true" aria-controls="collapseThree">
            <i class="fas fa-comment-dots"></i>
            <span>Commentaires</span>
        </a>
        <div id="collapseThree" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Gérer les commentaires</h6>
                <a class="collapse-item" href="<?= App::url('admin/comments') ?>">Tous les commentaires</a>
            </div>
        </div>
    </li>


    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Outils
    </div>


    <!-- Nav Item - Charts -->
    <li class="nav-item">
        <a class="nav-link" href="<?= App::url('admin/users') ?>">
            <i class="fas fa-restroom"></i>
            <span>Utilisateurs</span></a>
    </li>

    <!-- Nav Item - Tables
    <li class="nav-item">
        <a class="nav-link" href="tables.html">
            <i class="far fa-images"></i>
            <span>Médias</span></a>
    </li> -->

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

    <!-- Sidebar Message -->
    <div class="sidebar-card">
        <img class="sidebar-card-illustration mb-2" src="<?= App::url('') ?>public/images/admin/undraw_rocket.svg"
             alt="">
        <p class="text-center mb-2"><strong>Bienvenue</strong> dans votre administration !</p>
        <a class="btn btn-success btn-sm" href="<?= App::url('') ?>">Voir le site</a>
    </div>

</ul>
<!-- End of Sidebar -->

