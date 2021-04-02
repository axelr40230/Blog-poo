<?php

function homePage()
{
    require_once('src/functions.php');
    $pageTitle = 'Accueil';
    render('frontend/index', ['pageTitle' => $pageTitle], 'frontend');
}

function listPosts()
{
    require_once('src/functions.php');
    $pageTitle = 'Blog';
    render('frontend/posts', ['pageTitle' => $pageTitle], 'frontend');
}

function post()
{
    require_once('src/functions.php');
    $pageTitle = 'Article';
    render('frontend/post', ['pageTitle' => $pageTitle], 'frontend');
}
