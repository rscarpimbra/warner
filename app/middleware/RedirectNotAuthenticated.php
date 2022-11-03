<?php

namespace app\middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

class RedirectNotAuthenticated{

    public function __invoke(Request $request, RequestHandler $handler){

        $response = $handler->handle($request);


        /* If the Session Variable is not Set. */
        if( (!isset( $_SESSION['usu_is_logged' ]))){

            return $response->withHeader('Location', '/login')->withStatus(302);
        }

        return $response;
    }
}