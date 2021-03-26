<?php
require_once('controllers/frontend.php');
require_once('controllers/backend.php');

try {
    if (isset($_GET['action'])) {
        if ($_GET['action'] == 'homePage') {
            homePage();
        }
        elseif ($_GET['action'] == 'contactPage') {
            contactPage();
        }
        elseif ($_GET['action'] == 'listPosts') {
            listPosts();
        }
        elseif ($_GET['action'] == 'login'){
            login();
        }
        elseif ($_GET['action'] == 'admin'){
            admin();
        }
        elseif ($_GET['action'] == 'logout'){
            logout();
        }
        elseif ($_GET['action'] == 'dashboard'){
            dashboard();
        }
        elseif ($_GET['action'] == 'postsAdmin'){
            postsAdmin();
        }
        elseif ($_GET['action'] == 'mediasAdmin'){
            mediasAdmin();
        }
        elseif ($_GET['action'] == 'commentsAdmin'){
            commentsAdmin();
        }
        elseif ($_GET['action'] == 'usersAdmin'){
            usersAdmin();
        }
        elseif ($_GET['action'] == 'editArticle'){
            editArticle();
        }
        elseif ($_GET['action'] == 'deleteArticle'){
            deleteArticle();
        }
        elseif ($_GET['action'] == 'deleteUser'){
            deleteUser();
        }
        elseif ($_GET['action'] == 'editUser'){
            editUser();
        }
        elseif ($_GET['action'] == 'editComment'){
            editComment();
        }
        elseif ($_GET['action'] == 'deleteMedia'){
            deleteMedia();
        }
        elseif ($_GET['action'] == 'editMedia'){
            editMedia();
        }
        elseif ($_GET['action'] == 'upload'){
            upload();
        }
        elseif ($_GET['action'] == 'commentByArticle'){
            commentByArticle();
        }
        elseif ($_GET['action'] == 'post') {
            if (isset($_GET['id']) && $_GET['id'] > 0) {
                post();
            }
            else {
                throw new Exception('Aucun identifiant de billet envoyé');
            }
        }
        elseif ($_GET['action'] == 'addComment') {
            if (isset($_GET['id']) && $_GET['id'] > 0) {
                if (!empty($_POST['author']) && !empty($_POST['comment'])) {
                    addComment($_GET['id'], $_POST['author'], $_POST['comment']);
                }
                else {
                    throw new Exception('Tous les champs ne sont pas remplis !');
                }
            }
            else {
                throw new Exception('Aucun identifiant de billet envoyé');
            }
        }
        elseif ($_GET['action'] == 'viewComment') {
            if (isset($_GET['id']) && $_GET['id'] > 0) {
                getModify();
            }
            else {
                throw new Exception('Aucun identifiant de commentaire envoyé');
            }
        }
        elseif ($_GET['action'] == 'editComment') {
            if (isset($_GET['id']) && $_GET['id'] > 0 && isset($_GET['post_id']) && $_GET['post_id'] > 0) {
                if (!empty($_POST['comment'])) {
                    editComment($_GET['id'], $_POST['comment'],$_GET['post_id']);
                }
                else {
                    throw new Exception('Tous les champs ne sont pas remplis !');
                }
            }
            else {
                throw new Exception('Aucun identifiant de billet envoyé');
            }
        }
    }
    else {
        homePage();
    }
}
catch(Exception $e) { // S'il y a eu une erreur, alors...
    echo 'Erreur : ' . $e->getMessage();
}
