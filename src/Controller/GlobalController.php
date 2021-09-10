<?php

namespace App\Controller;

use App\App;
use App\Env;
use App\Mailer;

/**
 * Class GlobalController
 * @package App\Controller
 */
class GlobalController extends Controller
{
    /**
     * makes the link with the table of contacts via the contact page
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
     * manages the display of the contact page
     * gère l'affichage de la page contact
     */
    public function contact()
    {
        $text = '<p>Vous pouvez aussi m\'appeler ou m\'écrire directement</p>';
        $pageTitle = 'Me contacter';
        $this->render('contact', ['pageTitle' => $pageTitle, 'text' => $text], 'frontend');
    }

    /**
     * manages the display of the 404 page in front
     * gère l'affichage de la page 404 en front
     */
    public function notFound()
    {
        $pageTitle = 'Page introuvable';
        $this->render('404', ['pageTitle' => $pageTitle], 'frontend');
    }


    /**
     * manages the contact form (insertion in the database + notification to the administrator
     * gère le formulaire de contact (insertion dans la base de données + notification à l'administrateur
     */
    public function sendContact()
    {
        $validator = App::validator();
        $validator->validate($_POST, [
            'email' => [
                'required',
                'email'
            ]
        ]);

        if ($validator->fails() === false) {
            $pageTitle = 'Oups, il y a eu un souci.';
            $text = '<p class="text-warning border border-warning p-3"><i class="fa fa-exclamation-triangle"></i> Veuillez recommencer !</p>';
            $this->render('contact', ['pageTitle' => $pageTitle, 'text' => $text], 'frontend');
        } else {
            $data = $_POST;
            $table = $this->table('contact');
            $contact = $table->insert($data);
            if ($contact == false) {
                $text = '<p class="text-warning border border-warning p-3"><i class="fa fa-exclamation-triangle"></i> Il y a un souci dans le formulaire</p>';
                $pageTitle = 'Me contacter';
                $this->render('contact', ['pageTitle' => $pageTitle, 'text' => $text], 'frontend');
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
                $text = '<p class="text-success border border-success p-3"><i class="fa fa-thumbs-up"></i> Le message a bien été envoyé</p>';
                $pageTitle = 'Me contacter';
                $ancre = 'error';
                $this->render('contact', ['pageTitle' => $pageTitle, 'text' => $text, 'ancre' => $ancre], 'frontend');
            }
        }

    }

}