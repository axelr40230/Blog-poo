<?php

namespace App\Controller;

use App\App;
use App\Mailer;
use App\Table\ContactTable;

class GlobalController extends Controller
{
    /**
     * @param $contact
     * @return mixed
     */
    public function table($contact)
    {
        $contact = ucfirst($contact);
        $table = "App\Table\\" . $contact . "Table";

        return $table = new $table();
    }

    public function contact()
    {
        $errors = [];
        $pageTitle = 'Me contacter';
        $this->render('contact', ['pageTitle' => $pageTitle, 'errors' => $errors], 'frontend');
    }

    public function notFound()
    {
        $pageTitle = 'Page introuvable';
        $this->render('404', ['pageTitle' => $pageTitle], 'frontend');
    }

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
            $email = 'axelr.apl@gmail.com';
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