<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 11/10/17
 * Time: 16:07
 * PHP version 7
 */

namespace Controller;

use Model\CommentManager;
use Model\Item;
use Model\ItemManager;

/**
 * Class ItemController
 *
 */
class ItemController extends AbstractController
{

    /**
     * Display item listing
     *
     * @return string
     */
    public function index()
    {
        $message = null;

        if (isset($_SESSION['message'])) {
            $message = $_SESSION['message'];
            unset($_SESSION['message']);
        }
        $itemManager = new ItemManager();
        $items = $itemManager->selectAll();

        return $this->twig->render('Item/index.html.twig', [
            'items' => $items,
            'message' => $message,
        ]);
    }

    /**
     * Display item informations specified by $id
     *
     * @param  int $id
     *
     * @return string
     */
    public function show(int $id)
    {
        $message = null;

        //item information
        $itemManager = new ItemManager();
        $item = $itemManager->selectOneById($id);

        //ITEM : Delete case
        if (isset($_POST['submitDelete'])) {
            if (isset($_POST['itemId'])) {

                $id = (int) $_POST['itemId']; //int to delete method

                if ($id === $item->getId()) {
                    //delete : appel de la fonction de cette class
                    $this->delete($item->getId());

                    $_SESSION['message'] = 'Suppression de l\'item ' . $item->getTitle() . ' !';
                    header('Location: /');
                    die;

                } else {
                    $message = 'La suppression n\'est pas possible : incohérence d\'id !';
                }
            }
        }

        //COMMENT : add case
        if (isset($_POST['submitComment'])) {
            //$datas = [];

            //Add comment in db
            if (!empty($_POST['author']) && !empty($_POST['comment'])) {
                $dateNow = new \DateTime();
                $createdAt = $dateNow->format('Y-m-d H:i:s');

                $datas = [
                    'itemId' => $id,
                    'author' => $_POST['author'],
                    'comment' => $_POST['comment'],
                    'createdAt' => $createdAt,
                ];

                $commentManager = new CommentManager();
                $commentManager->insert($datas);

                $message = 'Commentaire de ' . $datas['author'] . ' ajouté !';

            } else {
                $message = 'Merci de saisir un auteur et un commentaire !';
            }
        }

        //COMMENT : display comment for update case
        if (!empty($_GET['IdCommentToUpdate'])) {
            $commentIdUpd = (int) $_GET['IdCommentToUpdate'];

            $commentManager = new CommentManager();
            $commentUpd = $commentManager->selectOneById($commentIdUpd);
        } else {
            $commentUpd = [];
        }

        //COMMENT : Update case
        if (isset($_POST['submitCommentUpdate'])) {

            $commentId = (int) $_POST['commentId'];
            $dateNow = new \DateTime();
            $updatedAt = $dateNow->format('Y-m-d H:i:s');

            $datas = [
                'commentId' => $commentId,
                'itemId' => $id,
                'author' => $_POST['author'],
                'comment' => $_POST['comment'],
                'createdAt' => $_POST['createdAt'],
                'updatedAt' => $updatedAt,
            ];

            $commentManager = new CommentManager();
            $commentManager->update($commentId, $datas);

            $_SESSION['message'] = ' Mise à jour du commentaire ' . $datas['author'] . ' le ' . $datas['updatedAt'] . ' !';
            header('Location: /item/' . $id);
            die;
        }

        //COMMENT : delete case
        if (!empty($_GET['IdCommentToDelete'])) {

            $commentId = (int) $_GET['IdCommentToDelete']; //int to delete method

            $commentManager = new CommentManager();
            $commentManager->delete($commentId);

            $_SESSION['message'] = 'Suppression du commentaire d\'id : ' . $commentId . ' !';
            header('Location: /item/' . $id);
            die;
        }

        //COMMENT : Comment List
        $commentManager = new CommentManager();
        $comments = $commentManager->selectAllById($id);
        //var_dump($comments);

        //MESSAGE before header()
        if (isset($_SESSION['message'])) {
            $message = $_SESSION['message'];
            unset($_SESSION['message']);
        }

        return $this->twig->render('Item/show.html.twig', [
            'item' => $item,
            'message' => $message,
            'comments' => $comments,
            'commentUpd' => $commentUpd,
            ]);
    }

    /**
     * Display item edition page specified by $id
     *
     * @param  int $id
     *
     * @return string
     */
    public function edit(int $id)
    {
        $itemManager = new ItemManager();
        $item = $itemManager->selectOneById($id);

        $datas = [];

        if (isset($_POST)) {
            if (isset($_POST['title']) && $_POST['id']) {
                $datas['title'] = $_POST['title'];

                $itemManager = new ItemManager();
                $itemManager->update($id, $datas);

                $_SESSION['message'] = ' Mise à jour de l\'item ' . $datas['title'] . ' !';
                header('Location: /');
                die;
            }
        }

        return $this->twig->render('Item/edit.html.twig', ['item' => $item]);
    }

    /**
     * Display item creation page
     *
     * @return string
     */
    public function add()
    {
        $datas = [];

        if (isset($_POST)) {
            if (isset($_POST['title'])) {
                $datas['title'] = $_POST['title'];
                $itemManager = new ItemManager();
                $itemManager->insert($datas);

                $_SESSION['message'] = 'Création de l\'item ' . $datas['title'] . ' Ok !';
                header('Location: /');
                die;
            }
        }
        return $this->twig->render('Item/add.html.twig');
    }

    /**
     * Display item delete page
     *
     * @param  int $id
     *
     * @return string
     */
    public function delete(int $id)
    {
        $itemManager = new ItemManager();
        $item = $itemManager->selectOneById($id);//info sur item en cours de delete

        $itemManager->delete($id); //delete

        $_SESSION['message'] = 'Suppression de l\'item ' . $item->getTitle() .' !';

        header('Location: /');
        die;
        //return $this->twig->render('Item/index.html.twig');
    }
}
