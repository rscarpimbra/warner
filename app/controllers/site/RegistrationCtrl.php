<?php

namespace app\controllers\site;

use app\controllers\controller;
use app\models\site\users as UserMD;

use Psr\Http\Message\{
    ServerRequestInterface as Request,
    ResponseInterface as Response
};

use Valitron\Validator;
use app\helpers\Password;

class RegistrationCtrl extends controller {


    /**
     * Render the Registration page
     *
     * @param Request $request
     * @param Response $response
     * @param [type] $args
     * @return void
     */
    public function index(Request $request, Response $response, $args)
    {
        
        return $this->c->get('view')->render($response, 'site/registration.twig', [
            'appName'               => $this->c->get('settings')['app']['name'],
            'errors'                => $this->c->get('flash')->getFirstMessage('errors'),
            'ErrorUserExists'       => $this->c->get('flash')->getFirstMessage('ErrorUserExists'),
        ]);
    }
    
    

    /**
     * Render the Registration Creation
     *
     * @param Request $request
     * @param Response $response
     * @param [type] $args
     * @return void
     * @Method POST.
     */
    public function create(Request $request, Response $response, $args){

       /* Validating Fields. */
       $toValidate = new Validator($request->getParsedBody());

       /* Setting the Validations. */
       $toValidate->rule('required', 'user_name');        
       $toValidate->rule('required', 'user_password');

        /* If the Validation Fail */
        if(!$toValidate->validate()){

            $this->c->get('flash')->addMessage('errors', $toValidate->errors());

            return $response->withHeader('Location', '/registration')->withStatus(302);
        }


        /* Destructuring the POST Data. */
        [ 'user_name' => $user_name, 'user_password' => $user_password ] = $request->getParsedBody();

        /* Checking if user already Exists. */
        $toUser = UserMD::where('usu_name', '=', $user_name)->get()->toArray();

        /* User has been find */
        if($toUser){

            $this->c->get('flash')->addMessage('ErrorUserExists', 'User has been taken already');

            return $response->withHeader('Location', '/registration')->withStatus(302);            
        }

        /* Creating a New User and Login. */
        UserMD::create([
            'usu_name'      => $user_name,
            'usu_password'  => Password::make($user_password)
        ]);

        /* Setting the user SESSION */
        $_SESSION['usu_is_logged']      = true;
        $_SESSION['usu_id']             = $toUser->usu_id;
        $_SESSION['usu_name']           = $toUser->usu_name;



        return $response->withHeader('Location', '/panel');
    }
}