<?php
//session_start();
use App\App;
?>
<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?= $pageTitle ?></title>

    <!-- Custom fonts for this template-->
    <link href="<?= App::url('') ?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
            href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
            rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?= App::url('') ?>public/css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="<?= App::url('') ?>vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

    <link href="//cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css" rel="stylesheet">

    <script src="https://cdn.tiny.cloud/1/cfxs3qxefmtsich5szb75tensvbgsgfhth2h6e6q551rcy0h/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

</head>

<body id="page-top">

<!-- Page Wrapper -->
<div id="wrapper">
<?php require 'sidebar.php';
?>
<?php require 'header.php';
?>
<?= $content ?>

<?php require('footer.php'); ?>
</body>
</html>

