<?php

namespace App\Controller;

use App\Env;
use App\Mailer;

class GlobalController extends Controller
{
    /**
     * fait le lien avec la table des prises de contact via la page contact
     * @param $contact
     * @return mixed
     */
    public function table($contact)
    {
        $contact = ucfirst($contact);
        $table = "App\Table\\" . $contact . "Table";

        return $table = new $table();
    }

    /**
     * gère l'affichage de la page contact
     */
    public function contact()
    {
        $errors = [];
        $pageTitle = 'Me contacter';
        $this->render('contact', ['pageTitle' => $pageTitle, 'errors' => $errors], 'frontend');
    }

    /**
     * gère l'affichage de la page 404 en front
     */
    public function notFound()
    {
        $pageTitle = 'Page introuvable';
        $this->render('404', ['pageTitle' => $pageTitle], 'frontend');
    }


    /**
     * gère le formulaire de contact (insertion dans la base de données + notification à l'administrateur
     */
    public function sendContact()
    {
        $data = $_POST;
        $table = $this->table('contact');
        $contact = $table->insert($data);
        if ($contact == false) {
            $errors = 'Il y a un souci dans le formulaire';
            $pageTitle = 'Me contacter';
            $this->render('contact', ['pageTitle' => $pageTitle, 'errors' => $errors], 'frontend');
        } else {
            $email = Env::get('ADMIN_EMAIL');
            $infos = [
                'name' => $data['name'],
                'email' => $data['email'],
                'message' => $data['message']
            ];
            $mailer = new Mailer();
            $templateFile = $mailer->file('mail-contact');
            $message = $mailer->extract($templateFile, $infos);
            $mailer->send($email, 'Vous avez un nouveau message', $message);
            $errors = 'Le message a bien été envoyé';
            $pageTitle = 'Me contacter';
            $ancre = 'error';
            $this->render('contact', ['pageTitle' => $pageTitle, 'errors' => $errors, 'ancre' => $ancre], 'frontend');
        }
    }

}