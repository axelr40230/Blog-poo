# Blog-poo

Projet n°5 de la formation Développeur PHP / Symfony OpenClassRooms

## Installation du projet 

* Clonez le repository.

`git clone https://github.com/axelr40230/Blog-poo.git`

* Importez le fichier SQL sur votre serveur de base de donnée MySQL.

`mysql -u -p nomdelabase < blogpoo.sql`

* Modifiez le fichier .env en renseignant vos informations de connexion.

`cp .env.example .env && open .env`

* Démarrez le projet en local

`php -S localhost:8000 -t public/`

## Administration

- email : axelr.apl@gmail.com
- pswd : admin

Lancer maildev :
Depuis le terminal, saisir maildev
Puis suivre le lien et remplacer les 0 par localhost