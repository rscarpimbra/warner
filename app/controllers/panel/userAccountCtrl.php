<?php

namespace app\controllers\panel;

use app\controllers\controller;
use Psr\Http\Message\{
    ServerRequestInterface as Request,
    ResponseInterface as Response
};

class userAccountCtrl extends controller{

    /**
     * Render the User Account page
     *
     * @param Request $request
     * @param Response $response
     * @param [type] $args
     * @return void
     */
    public function index(Request $request, Response $response, $args)
    {

        return $this->c->get('view')->render($response, 'panel/userAccount.twig', [
            'appName'       => $this->c->get('settings')['app']['name']
        ]);
    }
}