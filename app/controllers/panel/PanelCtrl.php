<?php

namespace app\controllers\panel;

use app\controllers\controller;
use Psr\Http\Message\{
    ServerRequestInterface as Request,
    ResponseInterface as Response
};

class PanelCtrl extends controller{

    /**
     * Render the Panel page
     *
     * @param Request $request
     * @param Response $response
     * @param [type] $args
     * @return void
     */
    public function index(Request $request, Response $response, $args)
    {

        return $this->c->get('view')->render($response, 'panel/panel.twig', [
            'appName'       => $this->c->get('settings')['app']['name'],
            'userLogged'    => $_SESSION
        ]);
    }
}