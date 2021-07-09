<?php


namespace App;


class Mailer
{
    const URL_FILE = 'pages/templates/mails';

    public $headers = 'Content-type: text/html; charset=iso-8859-1';
    public $message;
    public $infos = [];

    /**
     * @param $file
     * @return string
     */
    public function file($file): string
    {
        $path = self::URL_FILE;

        return $filePath = $path . '/' . $file . '.php';
    }

    /**
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
     * @param $to
     * @param $subject
     * @param $message
     */

    public function send($to, $subject, $message)
    {
        mail($to, $subject, $message, $this->headers);
    }
}