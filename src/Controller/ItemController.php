<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 11/10/17
 * Time: 16:07
 * PHP version 7
 */

namespace Controller;

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
        $itemManager = new ItemManager();
        $item = $itemManager->selectOneById($id);

        return $this->twig->render('Item/show.html.twig', ['item' => $item]);
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
        // TODO : edit item with id $id
        return $this->twig->render('Item/edit.html.twig', ['item', $id]);
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

                $_SESSION['message'] = 'INSERTION de ' . $datas['title'] . ' Ok !';
                header('Location: /');
                die;
            }
        }
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
        // TODO : delete the item with id $id
        return $this->twig->render('Item/index.html.twig');
    }
}
