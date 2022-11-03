<?php

namespace app\controllers\site;

use app\controllers\controller;
use Psr\Http\Message\{
    ServerRequestInterface as Request,
    ResponseInterface as Response
};

use Valitron\Validator;
use app\helpers\Functions;
use Dotenv\Dotenv;

use app\models\site\users as UserMD;
use app\models\site\userForgotPwMD as UserForgotMD;

class ForgotPwCtrl extends controller {

    /**
     * Render the Forgot Password page
     *
     * @param Request $request
     * @param Response $response
     * @param [type] $args
     * @return void
     */
    public function index(Request $request, Response $response, $args)
    {
        
        return $this->c->get('view')->render($response, 'site/forgot.twig', [
            'appName'               => $this->c->get('settings')['app']['name'],
            'errors'                => $this->c->get('flash')->getFirstMessage('errors'),
            'ErrorUserName'         => $this->c->get('flash')->getFirstMessage('ErrorUserName'),
            'SuccessMessage'        => $this->c->get('flash')->getFirstMessage('SuccessMessage'),
        ]);
    }
    
    


     /**
     * Forgot Password
     *
     * @param Request $request
     * @param Response $response
     * @param [type] $args
     * @return void
     * @Method POST
     */
    public function forgot(Request $request, Response $response, $args)
    {
        
        /* Validating Fields. */
        $toValidate = new Validator($request->getParsedBody());

        /* Setting the Validations. */
        $toValidate->rule('required', 'user_name');

        /* If the Validation Fail */
        if(!$toValidate->validate()){

            $this->c->get('flash')->addMessage('errors', $toValidate->errors());

            return $response->withHeader('Location', '/forgot-pw')->withStatus(302);
        }



        /* Destructoring the Data. */
        [ 'user_name' => $user_name ] = $request->getParsedBody();

        /* Checking the Database for the Username or Email provided. */
        $toUsers = UserMD::where('usu_name', '=', $user_name)->get()->toArray();

        /* If the User Doesn't Exists. */
        if(!$toUsers){

            $this->c->get('flash')->addMessage('ErrorUserName', 'Invalid Username or Email Address');

            return $response->withHeader('Location', '/forgot-pw')->withStatus(302);
        }        

        /* If the User is Located. */
        if(!empty($toUsers)){

            /* Getting the .env File. */
            $env = (new Dotenv(__DIR__ . '/../../../'))->load();

            /* Saving the Recovery Password Information */
            UserForgotMD::create([
                'usu_id'                => $toUsers[0]['usu_id'],
                'rec_token'             => \bin2hex(\random_bytes(32)),
                'rec_expires'           => 0,
                'rec_expiration_date'   => Functions::FAddDays($_ENV['EMAIL_EXPIRATION_DAYS'])
            ]);

            /* Send the Email with the Token */

            $this->c->get('flash')->addMessage('SuccessMessage', 'Email has been send successfully');
        }

        return $response->withHeader('Location', '/forgot-pw');
    }  
}