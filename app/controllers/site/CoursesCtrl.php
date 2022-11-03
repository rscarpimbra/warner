<?php

namespace app\controllers\site;

use app\controllers\controller;
use Psr\Http\Message\{
    ServerRequestInterface as Request,
    ResponseInterface as Response
};

class CoursesCtrl extends controller {
    /**
     * Render the Courses page
     *
     * @param Request $request
     * @param Response $response
     * @param [type] $args
     * @return void
     */
    public function index(Request $request, Response $response, $args)
    {
        
        return $this->c->get('view')->render($response, 'site/courses.twig', [
            'appName' => $this->c->get('settings')['app']['name'],
        ]);
    }


}