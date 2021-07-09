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
<p>Un utilisateur vient de vous envoyer un message<br/><br/>
    Son nom : {{name}}<br/>
    Son email : <a href="mailto:{email}">{{email}}</a><br/>
    Son message : {{message}}
</p>
</body>
</html>