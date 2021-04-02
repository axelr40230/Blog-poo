<?php
setcookie("id", $_POST['id'], time() + 365 * 24 * 3600, null, null, false, true);
setcookie("email", $_POST['email'], time() + 365 * 24 * 3600, null, null, false, true);
setcookie("password", $_POST['password'], time() + 365 * 24 * 3600, null, null, false, true);
session_start();
$_SESSION['id']   = $result['id'];
$_SESSION['email'] = $email;
Header('Location: partners.php');