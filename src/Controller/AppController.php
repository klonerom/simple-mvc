<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 11/10/17
 * Time: 16:07
 * PHP version 7
 */

namespace Controller;


/**
 * Class AppController
 *
 */
class AppController extends AbstractController
{

    /**
     * Display item listing
     *
     * @return string
     */
    public function contact()
    {
        return $this->twig->render('App/contact.html.twig', ['items' => $items]);
    }

}
