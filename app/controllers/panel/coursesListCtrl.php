<?php

namespace app\controllers\panel;

use app\controllers\controller;
use Psr\Http\Message\{
    ServerRequestInterface as Request,
    ResponseInterface as Response
};

class coursesListCtrl extends controller {

    /**
     * Render the Course List page
     *
     * @param Request $request
     * @param Response $response
     * @param [type] $args
     * @return void
     */
    public function index(Request $request, Response $response, $args)
    {
        
        return $this->c->get('view')->render($response, 'panel/courses-list.twig', [
            'appName' => $this->c->get('settings')['app']['name'],
        ]);
    }    
}