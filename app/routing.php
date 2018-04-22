<?php
/**
 * This file hold all routes definitions.
 *
 * PHP version 7
 *
 * @author   WCS <contact@wildcodeschool.fr>
 *
 * @link     https://github.com/WildCodeSchool/simple-mvc
 */

$routes = [
    'Item' => [ // Controller
        ['index', '/', 'GET'], // action, url, method
        ['add', '/item/add', ['GET', 'POST']], // action, url, method, GET ou POST (voir doc fastrout utilisée dans le disptacher : le GET permet d'afficher la page (donc obligatoire) et le POST de récupérer les élement du formulaire de la page add
        ['edit', '/item/edit/{id:\d+}', ['GET', 'POST']], // action, url, method
        ['show', '/item/{id:\d+}', ['GET', 'POST']], // action, url, method
    ],
    'App' => [
        ['contact', '/contact', 'GET'],
    ],
];
