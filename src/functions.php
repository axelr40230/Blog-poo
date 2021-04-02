<?php

/** RENDER FUNCTION
 * @param string $path
 * @param array $variables
 */
function render(string $path, array $variables = [], string $folder) : void
{
    extract($variables);
    ob_start();
    require('templates/'.$path.'.php');
    $pageContent = ob_get_clean();
    require('templates/'.$folder.'/layout.php');
}

/** TRANSLATIONS
 * @param $term
 * @return string[][]
 */
function translate($term) : array
{
    // Gestion des traductions
    $trad = array(
        'fr' => array(
            'approuved' => 'Approuvé',
            'intrash' => 'A la corbeille',
            'waiting' => 'En attente de validation',
            'admin' => 'Administrateur du site',
            'author' => 'Auteur',
            'user' => 'Utilisateur',
            'draft' => 'Brouillon',
            'publish' => 'Publié',
            'intrash' => 'A la corbeille'
        ),

        'en' => array(
            'approuved' => 'Approuved',
            'intrash' => 'In trash',
            'waiting' => 'Waiting for validation',
            'admin' => 'Administrator',
            'author' => 'Author',
            'user' => 'User',
            'draft' => 'draft',
            'publish' => 'publish',
            'intrash' => 'in trash'
        ));

    return $trad;
}