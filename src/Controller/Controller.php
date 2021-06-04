<?php

namespace App\Controller;

class Controller
{
    /** RENDER FUNCTION
     * @param string $path
     * @param array $variables
     */
    public function render(string $path, array $variables = [], string $folder): void
    {
        extract($variables);
        ob_start();
        require('pages/templates/' . $folder . '/' . $path . '.php');
        $content = ob_get_clean();
        require('pages/templates/' . $folder . '/layout.php');
    }

}