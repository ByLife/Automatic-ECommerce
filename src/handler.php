<?php 

require 'vendor/autoload.php';

$router = new Project\App\Router\Router($_GET['url']);

// --------- USER ROUTES ---------

// !- INDEX ROUTES -!

//& HOME ROUTES

$router->get('/', function(){
    require_once 'views/home.php';
});

//& TERMS ROUTES

$router->get('/terms', function(){
    require_once 'views/terms.php';
});

// !- AUTH ROUTES -!

$router->get('/login', function(){
    require_once 'views/auth/login.php';
});

$router->get('/login/:id/:token', function($user_id, $token){
    DB->insertUser($user_id, $token);
    header('Location: ./../../login');
});


$router->get('/logout', function(){
    require_once 'views/auth/logout.php';
});

//& ALL REGISTER ROUTES

$router->get('/register', function(){
    require_once 'views/auth/register.php';
});

$router->get('/register/:id/:mail_token', function($user_id, $mail_token){
    require_once 'api/client/verify.php';
})->with('mail_token', '[a-zA-Z0-9]+', 'id', '[0-9]+');

//& ALL RESET ROUTES

$router->get('/reset', function(){
    require_once 'views/auth/reset.php';
});

$router->get('/reset/:id/:token', function($user_id, $token){
    require_once 'views/auth/reset_pass.php';
})->with('token', '[a-zA-Z0-9]+', 'id', '[0-9]+');

// !- DASHBOARD ROUTES -!

$router->get('/client/dashboard', function(){
    if(!isset($_COOKIE['token'])) header('Location: ./../login');
    $user = DB->getUserByToken($_COOKIE['token']);
    if($user === false) header('Location: ./../login');
    require_once 'views/client/dashboard.php';
});

$router->get('/client/order', function(){
    if(!isset($_COOKIE['token'])) header('Location: ./../login');
    $user = DB->getUserByToken($_COOKIE['token']);
    if($user === false) header('Location: ./../login');
    require_once 'views/client/order.php';
});

// --------- API ROUTES ---------

// !- INDEX ROUTES -!

//& BASE API ROUTES

$router->get('/api', function(){
    require_once 'api/api.php';
});


// !- AUTH ROUTES -!

//& ALL LOGIN ROUTES

$router->post('/api/client/login', function(){
    require_once 'api/client/login.php';
});


//& ALL REGISTER ROUTES

$router->post('/api/client/register', function(){
    require_once 'api/client/register.php';
});


//& ALL RESET ROUTES

$router->post('/api/client/reset', function(){
    require_once 'api/client/reset.php';
});

// ------- RUN ROUTER -------

$router->run();
?>