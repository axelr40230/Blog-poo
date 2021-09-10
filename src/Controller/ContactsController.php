<?php

namespace App\Controller;

use App\App;
use App\Auth;
use App\Table\PostTable;
use App\Table\UserTable;

/**
 * Class ContactsController
 * @package App\Controller
 */
class ContactsController extends Controller
{
    /**
     * makes the link with the contacts table
     * fait le lien avec la table contacts
     * @param $contacts
     * @return mixed
     */
    public function table($contacts)
    {
        $contacts = ucfirst($contacts);
        $contacts = rtrim($contacts, 's');
        $table = "App\Table\\" . $contacts . "Table";

        return $table = new $table();
    }

    /**
     * list all contacts
     * liste tous les contacts
     */
    public function list()
    {
        if ($this->isConnected()) {
            if (Auth::isAdmin()) {
                $table = $this->table('contacts');
                $trad = new App();
                $pageTitle = 'Vos messages';


                // On détermine sur quelle page on se trouve
                if (isset($_GET['page']) && !empty($_GET['page'])) {
                    $currentPage = (int)strip_tags($_GET['page']);
                } else {
                    $currentPage = 1;
                }

                $totalContacts = $table->findAll();

                $nbArticles = count($totalContacts);
                // On détermine le nombre d'articles par page
                $parPage = 10;
                // On calcule le nombre de pages total
                $pages = ceil($nbArticles / $parPage);
                // Calcul du 1er article de la page
                $premier = ($currentPage * $parPage) - $parPage;

                $contacts = $table->findWithPagination($premier, $parPage);

                $this->render('contacts', ['pageTitle' => $pageTitle, 'contacts' => $contacts, 'currentPage' => $currentPage, 'pages' => $pages], 'backend');
            }
        }
    }

    /**
     * allows you to edit a comment
     * permet d'éditer un commentaire
     * @param $id
     */
    public function edit($id)
    {
        if ($this->isConnected()) {
            if (Auth::isAdmin()) {
                $contact = $this->table('contacts')->one($id);
                if ($contact == false) {
                    $this->error();
                }
                $contacts = rtrim('comments', 's');
                $authorInfos = new UserTable();
                $comment->author = $authorInfos->author($comment->author);
                $posts = new PostTable();
                $comment->article_id = $posts->get_title($comment->article_id);
                $pageTitle = 'Commentaire n°' . $comment->id;
                $this->render('single-' . $comments, ['pageTitle' => $pageTitle, 'id' => $id, $comments => $comment], 'backend');
            }
        }
    }
}