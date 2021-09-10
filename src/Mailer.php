<?php


namespace App;

/**
 * Class Mailer
 * @package App
 */
class Mailer
{
    const URL_FILE = 'pages/templates/mails';

    public $headers = 'Content-type: text/html; charset=iso-8859-1';
    public $message;
    public $infos = [];

    /**
     * définit le bon chemin vers le bon template
     * defines the right path to the right template
     * @param $file
     * @return string
     */
    public function file($file): string
    {
        $path = self::URL_FILE;

        return $filePath = $path . '/' . $file . '.php';
    }

    /**
     * vérifie si le template existe et va chercher les variables à y intégrer
     * checks if the template exists and will look for the variables to integrate into it
     * @param $fileTemplate
     * @return string|string[]
     */
    public function extract($fileTemplate, $infos)
    {
        if (file_exists($fileTemplate)) {
            $tpl = file_get_contents($fileTemplate);
            foreach (array_keys($infos) as $key) {
                $regex = "/{{\s?$key\s?}}/iu";
                $tpl = preg_replace($regex, $infos[$key], $tpl);
            }


            return $tpl;
        }
    }

    /**
     * fonction d'envoi de l'email
     * email sending function
     * @param $to
     * @param $subject
     * @param $message
     */

    public function send($to, $subject, $message)
    {
        mail($to, $subject, $message, $this->headers);
    }
}