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

        $itemManager = new ItemManager();
        $item = $itemManager->selectOneById($id);
        if (isset($_POST['submitDelete'])) {//Delete case
            if (isset($_POST['itemId'])) {

                $id = (int) $_POST['itemId']; //int to delete method

                if ($id === $item->getId()) {

                    $this->delete($item->getId());

                } else {
                    $message = 'La suppression n\'est pas possible : incohérence d\'id !';
                }
            }

        }

        if (isset($_POST['submitComment'])) {//add comment
            $datas = [];

            //eAdd comment in db
            if (isset($_POST['author']) && isset($_POST['comment'])) {
                $dateNow = new \DateTime();
                $createdAt = $dateNow->format('Y-m-d H:i:s');

                $datas = [
                    'itemId' => $id,
                    'author' => $_POST['author'],
                    'comment' => $_POST['comment'],
                    'createdAt' => $createdAt,
                ];

                $CommentManager = new CommentManager();
                $CommentManager->insert($datas);

                $_SESSION['message'] = 'Création du commentaire de' . $datas['author'] . ' !';
                header('Location: /item/' . $id);
                die;
            }
        }

        //List comment
        $commentManager = new CommentManager();
        $comments = $commentManager->selectAllById($id);

        return $this->twig->render('Item/show.html.twig', [
            'item' => $item,
            'message' => $message,
            'comments' => $comments,
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
