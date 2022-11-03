<?php

namespace app\controllers\site;

use app\controllers\controller;
use Psr\Http\Message\{
    ServerRequestInterface as Request,
    ResponseInterface as Response
};

use Valitron\Validator;
use app\models\site\userMD;
use app\helpers\Password;
use app\helpers\Procedures;

class LoginCtrl extends controller {

    protected $Model;


    /**
     * Render the Login page
     *
     * @param Request $request
     * @param Response $response
     * @param [type] $args
     * @return void
     */
    public function index(Request $request, Response $response, $args)
    {
        return $this->c->get('view')->render($response, 'site/login.twig', [
            'appName'           => $this->c->get('settings')['app']['name'],
            'ErrorUserName'     => $this->c->get('flash')->getFirstMessage('ErrorUserName'),
            'ErrorPassword'     => $this->c->get('flash')->getFirstMessage('ErrorPassword'),
            'errors'            => $this->c->get('flash')->getFirstMessage('errors'),
            'old'               => $this->c->get('flash')->getFirstMessage('old'),
        ]);   
    }
    
    

    /**
     * Render the Auth function
     *
     * @param Request $request
     * @param Response $response
     * @param [type] $args
     * @return void
     */ 
    public function auth(Request $request, Response $response, $args)
    {

        /* Getting the Form Data.  */
        $toFormData = $request->getParsedBody();

        /* Adding the Data Typed to the SESSION to get that Data Back to the Fields. */
        $this->c->get('flash')->addMessage('old', $toFormData);

        /* Validating Fields. */
        $toValidate = new Validator($toFormData);

        /* Setting the Validations. */
        $toValidate->rule('required', 'user_name');
        $toValidate->rule('required', 'user_password');

        /* If the Validation Fail */
        if(!$toValidate->validate()){

            $this->c->get('flash')->addMessage('errors', $toValidate->errors());

            return $response->withHeader('Location', '/login')->withStatus(302);
        }

        /* Checking the DataBase for the User Data Entered. */
        $this->Model = new userMD();

        /* Returning the User Data. */
        $toUser = $this->Model->FQueryClauseWhere(['usu_name' => $toFormData['user_name']]);
        

        /* If the User Doesn't Exists. */
        if(!$toUser){

            $this->c->get('flash')->addMessage('ErrorUserName', 'Invalid User Name');

            return $response->withHeader('Location', '/login')->withStatus(302);
        }


        /* Checking the Password */
        if(!Password::verify($toFormData['user_password'], $toUser->usu_password)){

            /* Invalid Password */
            $this->c->get('flash')->addMessage('ErrorPassword', 'Invalid Password');

            return $response->withHeader('Location', '/login')->withStatus(302);
        }

        /* Setting the Logged in User into the $_SESSION */
        Procedures::PSetLoggedUserData($toUser);

        return $response->withHeader('Location', '/panel');
    }




    /**
     * Render the Sign Out function
     *
     * @param Request $request
     * @param Response $response
     * @param [type] $args
     * @return void
     */ 
    public function signOut(Request $request, Response $response, $args) {

        session_unset();

        unset($_SESSION['usu_is_logged']);
        session_destroy();

        return $response->withHeader('Location', '/login');
    }
}