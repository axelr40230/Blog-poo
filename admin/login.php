<?php
// lancement de la session
session_start();
if (isset($_SESSION['id'])) :
header('Location: admin.php');
endif;

// connexion à la bdd
$db = new \PDO('mysql:host=localhost;dbname=blogpoo;charset=utf8', 'root', '');

// initialisation messages alerte formulaires
$message='';
$messageNew='';


// traitement formulaire de connexion
if (isset($_POST['connexion'])) :

    if (!empty($_POST['email']) AND !empty($_POST['password'])) :
        $email      = htmlspecialchars($_POST['email']);
        $password      = htmlspecialchars($_POST['password']);
        //vérification de la présence du nom utilisateur
        $req_count       = $db->prepare('SELECT * FROM users WHERE email = :email');
        $req_count->execute(array(
            'email' => $email
        ));
        $count     = $req_count->rowCount();
        //dans le cas où aucun utilisateur est trouvé
        if ($count == 0) :
            $message = 'user non trouvé';
            $req_count->closeCursor();
        else :
            $req = $db->prepare('SELECT id, password FROM users WHERE email = :email');
            $req->execute(array(
                'email' => $email
            ));
            $result            = $req->fetch();
            $hash              = $result['password'];
            $isPasswordCorrect = password_verify($password, $hash);
            if (!$isPasswordCorrect) :
                $message = 'erreur de mot de passe';
            else :
                if (isset($_POST['souvenir'])) :
                    require '../cookies.php';
                    $req->closeCursor();
                    header('location:admin.php');
                    else :
                        $_SESSION['id']   = $result['id'];
                        $_SESSION['email'] = $email;
                        $req->closeCursor();
                        header('location:admin.php');
                endif;
            endif;
        endif;
        else :
            $message = 'Oops ! Vous avez oublié de remplir tous les champs :)';
    endif;

    // traitement du formulaire d'inscription

    elseif (isset($_POST['inscription'])) :

        if (!empty($_POST['new-name']) AND !empty($_POST['new-firstname']) AND !empty($_POST['new-email']) AND !empty($_POST['new-password']) AND !empty($_POST['password-repeat'])) :
            // validation des données envoyées par l'utilisateur
            $nom          = htmlspecialchars($_POST['new-name']);
            $prenom       = htmlspecialchars($_POST['new-firstname']);
            $email         = htmlspecialchars($_POST['new-email']);
            $pass         = htmlspecialchars($_POST['new-password']);
            $pass_confirm = htmlspecialchars($_POST['password-repeat']);
            $status = 'user';

            //vérification mots de passe identiques
            if ($pass == $pass_confirm) :
                //hashage du mot de passe
                $options = [
                    'cost' => 10,
                ];
                $pass_hash  = password_hash($pass, PASSWORD_DEFAULT, $options);
                $req   = $db->prepare("SELECT * FROM user WHERE email = :email");
                $req->execute(array(
                    'email' => $email
                ));
                //vérification user libre
                $count = $req->rowCount();

                if ($count == 0) :
                    $req->closeCursor();
                    //preparation requete insertion dans la BDD
                    $register = $db->prepare('INSERT INTO users(first_name, last_name, email, password, status, date_add) VALUES(:first_name, :last_name, :email, :password, :status, NOW())');
                    $register->execute(array(
                            'first_name' => $prenom,
                            'last_name' => $nom,
                            'email' => $email,
                            'password' => $pass_hash,
                            'status' => $status,
                            )
                    );
                    $register->closeCursor();
                    header('location:admin.php');
                else :
                        $messageNew = 'Cet email est déjà utilisé';
                endif;

                else :
                    $messageNew = 'Les mots de passe ne sont pas identiques';
            endif;
            else :
            $messageNew = 'tous les champs doivent être remplis';
        endif;

    else :

endif;

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Page de connexion </title>
</head>
<body>

<?php // formulaire de connexion ?>
<h1>Connexion</h1>
<form action="" method="post">
    <?= $message; ?>
    <label for="email">Email</label>
    <input type="text" id="email" placeholder="Votre email" name="email">
    <label for="password">Votre mot de passe</label>
    <input type="password" id="password" name="password">
    <input type="checkbox" name="souvenir" id="souvenir">
    <label for="souvenir">Se souvenir de moi</label>
    <input type="submit" value="connexion" name="connexion">
    <p>
        <a href="forgot-password.php">Mot de passe oublié ?</a>
    </p>
</form>

<p>ou créer un compte</p>

<?php // formulaire d'inscription ?>

<form action="" method="post">
    <?php echo $messageNew ?>
    <label for="new-name">Nom</label>
    <input type="text" id="new-name" name="new-name" placeholder="Votre nom">
    <label for="new-firstname">Prénom</label>
    <input type="text" id="new-firstname" name="new-firstname" placeholder="Votre prénom">
    <label for="new-email">Email</label>
    <input type="text" id="new-email" name="new-email" placeholder="Votre email">
    <label for="new-password">Votre mot de passe</label>
    <input type="new-password" name="new-password" id="new-password">
    <label for="password-repeat">Répétez votre mot de passe</label>
    <input type="password-repeat" name="password-repeat" id="password-repeat">
    <input type="submit" value="inscription" name="inscription">
</form>

</body>
</html>