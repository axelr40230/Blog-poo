<?php


namespace App;


class Mailer
{
    const URL_FILE = 'pages/templates/mails';

    public $headers = 'Content-type: text/html; charset=iso-8859-1';
    public $message;

    public function file($file): string
    {
        $path = self::URL_FILE;

        return $filePath = $path . '/' . $file . '.php';
    }

    public function extract($fileTemplate) {
        if(file_exists($fileTemplate)) {
            $content = 'Whatever you want to insert...';
            $tpl = file_get_contents($fileTemplate);
            $tpl = str_replace('{{content}}', $content, $tpl);

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
         {
            $headers = $this->headers;
            mail($to, $subject, $message, $headers);
        }


    }
}