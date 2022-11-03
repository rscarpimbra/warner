<?php

namespace app\controllers\site;

use app\controllers\controller;
use Psr\Http\Message\{
    ServerRequestInterface as Request,
    ResponseInterface as Response
};

use app\models\panel\categories;

class HomeCtrl extends controller
{
    /**
     * Render the home page
     *
     * @param Request $request
     * @param Response $response
     * @param [type] $args
     * @return void
     */
    public function index(Request $request, Response $response, $args)
    {

        return $this->c->get('view')->render($response, 'site/index.twig', [
            'appName' => $this->c->get('settings')['app']['name'],
        ]);
    }
}
