<?php

function homePage()
{
    require_once('models/functions.php');
    $pageTitle = 'Accueil';
    render('frontend/index', ['pageTitle' => $pageTitle], 'frontend');
}

function listPosts()
{
    require_once('models/functions.php');
    $pageTitle = 'Blog';
    render('frontend/posts', ['pageTitle' => $pageTitle], 'frontend');
}

function post()
{
    require_once('models/functions.php');
    $pageTitle = 'Article';
    render('frontend/post', ['pageTitle' => $pageTitle], 'frontend');
}
