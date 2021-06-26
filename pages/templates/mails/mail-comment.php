<!DOCTYPE html>
<html lang="fr">
<html>
<head>
    <meta charset="UTF-8">
    <title>Il y a un commentaire en attente</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        .btn {
            background-color: #fb5353;
            padding: 15px 20px;
            color: white;
            text-decoration: none;
            text-transform: uppercase;
        }
    </style>
</head>
<body>
<p>Bonjour</p>
<p>Un utilisateur vient de publier un commentaire<br/><br/>
    <a class="btn" href="{{content}}">consulter le commentaire</a><br/><br/>
    OU, si ce lien ne fonctionne pas, merci de le saisir dans votre navigateur : <br/><br/>
    {{content}}</p>
<p>Merci de votre confiance</p>
<p>Alexandra</p>
</body>
</html>