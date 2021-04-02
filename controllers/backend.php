<?php

function login()
{
    require('src/functions.php');
    $pageTitle = 'Connexion';
    render('backend/login', ['pageTitle' => $pageTitle], 'backend');
}

function logout()
{
    require('src/functions.php');
    $pageTitle = 'Déconnexion';
    render('backend/logout', ['pageTitle' => $pageTitle], 'backend');
}

function admin()
{
    require('src/functions.php');
    $pageTitle = 'Tableau de bord';
    render('backend/admin', ['pageTitle' => $pageTitle], 'backend');
}

function dashboard()
{
    require('src/functions.php');
    $pageTitle = 'Mon profil';
    render('backend/dashboard', ['pageTitle' => $pageTitle], 'backend');
}

function postsAdmin()
{
    require('src/functions.php');
    $pageTitle = 'Gérer les articles';
    render('backend/postsAdmin', ['pageTitle' => $pageTitle], 'backend');
}

function mediasAdmin()
{
    require('src/functions.php');
    $pageTitle = 'Gérer les médias';
    render('backend/mediasAdmin', ['pageTitle' => $pageTitle], 'backend');
}

function commentsAdmin()
{
    require('src/functions.php');
    $pageTitle = 'Gérer les commentaires';
    render('backend/commentsAdmin', ['pageTitle' => $pageTitle], 'backend');
}

function usersAdmin()
{
    require('src/functions.php');
    $pageTitle = 'Gérer les utilisateurs';
    render('backend/usersAdmin', ['pageTitle' => $pageTitle], 'backend');
}

function editArticle()
{
    require('src/functions.php');
    $pageTitle = 'Editer l\'article';
    render('backend/editArticle', ['pageTitle' => $pageTitle], 'backend');
}

function deleteArticle()
{
    require('src/functions.php');
    $pageTitle = 'Supprimer l\'article';
    render('backend/deleteArticle', ['pageTitle' => $pageTitle], 'backend');
}

function deleteUser()
{
    require('src/functions.php');
    $pageTitle = 'Supprimer un utilisateur';
    render('backend/deleteUSer', ['pageTitle' => $pageTitle], 'backend');
}

function editUser()
{
    require('src/functions.php');
    $pageTitle = 'Modifier l\'utilisateur';
    render('backend/editUser', ['pageTitle' => $pageTitle], 'backend');
}

function editComment()
{
    require('src/functions.php');
    $pageTitle = 'Modifier le commentaire';
    render('backend/editComment', ['pageTitle' => $pageTitle], 'backend');
}

function deleteMedia()
{
    require('src/functions.php');
    $pageTitle = 'Supprimer un média';
    render('backend/deleteMedia', ['pageTitle' => $pageTitle], 'backend');
}

function editMedia()
{
    require('src/functions.php');
    $pageTitle = 'Ajouter un média';
    render('backend/editMedia', ['pageTitle' => $pageTitle], 'backend');
}

function upload()
{
    require('src/functions.php');
    $pageTitle = 'Upload un media';
    render('backend/upload', ['pageTitle' => $pageTitle], 'backend');
}

function commentByArticle()
{
    require('src/functions.php');
    $pageTitle = 'Commentaires de l\'article';
    render('backend/commentByArticle', ['pageTitle' => $pageTitle], 'backend');
}

