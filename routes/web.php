<?php

use app\middleware\RedirectNotAuthenticated;

use app\controllers\site\HomeCtrl;
use app\controllers\site\CertificationCtrl;
use app\controllers\site\AboutCtrl;
use app\controllers\site\ContactCtrl;
use app\controllers\site\CoursesCtrl;
use app\controllers\site\LoginCtrl;
use app\controllers\site\ForgotPwCtrl;
use app\controllers\site\RegistrationCtrl;

use app\controllers\panel\PanelCtrl;

use app\controllers\panel\userAccountCtrl;


use app\controllers\panel\coursesListCtrl;



$app->get('/',                  HomeCtrl::class .               ':index');

$app->get('/certification',     CertificationCtrl::class .      ':index');

$app->get('/about',             AboutCtrl::class .              ':index');

$app->get('/contact',           ContactCtrl::class .            ':index');

$app->get('/courses',           CoursesCtrl::class .            ':index');

/* Login / Auth Routes. */
$app->get('/login',                         LoginCtrl::class .              ':index');
$app->post('/login/auth',                   LoginCtrl::class .              ':auth')->setName('login.auth');

/* Sign out */
$app->get('/signout',                       LoginCtrl::class .              ':signOut')->setName('login.signout');

/* Forgot Password. */
$app->get('/forgot-pw',                     ForgotPwCtrl::class .           ':index');
$app->post('/forgot-pw-check',              ForgotPwCtrl::class .           ':forgot')->setName('forgot.pw');


/* Registration */
$app->get('/registration',                  RegistrationCtrl::class .      ':index');
$app->post('/registration/create',          RegistrationCtrl::class .       ':create')->setName('registration.create');


/* Protected Route Panel */
$app->get('/panel',             PanelCtrl::class .              ':index')->setName('panel')->add(new RedirectNotAuthenticated());

/* Protected Routes Panel */
$app->group('/panel', function($route){

    $route->get('/',                                PanelCtrl::class.               ':index');

    $route->get('/user-list',                       userAccountCtrl::class.         ':index')->setName('user.account');

    $route->get('/courses-list',                    coursesListCtrl::class.         ':index');




})->add(new RedirectNotAuthenticated());
