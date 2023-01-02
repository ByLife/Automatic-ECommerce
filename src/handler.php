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
    $servers = DB->getUserServers($user['user_id']);
    $tickets = $user['rank'] == 0 ? DB->getUserTickets($user['user_id']) : DB->getAllUsersTickets();
    require_once 'views/client/dashboard.php';
});

$router->get('/client/order', function(){
    if(!isset($_COOKIE['token'])) header('Location: ./../login');
    $user = DB->getUserByToken($_COOKIE['token']);
    $plans = DB->getPlans();
    if($user === false) header('Location: ./../login');
    $servers = DB->getUserServers($user['user_id']);
    $tickets = $user['rank'] == 0 ? DB->getUserTickets($user['user_id']) : DB->getAllUsersTickets();
    require_once 'views/client/order.php';
});

$router->get('/client/profile', function(){
    if(!isset($_COOKIE['token'])) header('Location: ./../login');
    $user = DB->getUserByToken($_COOKIE['token']);
    if($user === false) header('Location: ./../login');
    $servers = DB->getUserServers($user['user_id']);
    $tickets = $user['rank'] == 0 ? DB->getUserTickets($user['user_id']) : DB->getAllUsersTickets();
    require_once 'views/client/profile.php';
});

$router->get('client/activity', function(){
    if(!isset($_COOKIE['token'])) header('Location: ./../login');
    $user = DB->getUserByToken($_COOKIE['token']);
    if($user === false) header('Location: ./../login');
    $logs = DB->getUserLogs($user['user_id']);
    $servers = DB->getUserServers($user['user_id']);
    $tickets = $user['rank'] == 0 ? DB->getUserTickets($user['user_id']) : DB->getAllUsersTickets();
    require_once 'views/client/activity.php';
});

$router->get('client/server/:id', function($id){
    if(!isset($_COOKIE['token'])) header('Location: ./../login');
    $user = DB->getUserByToken($_COOKIE['token']);
    if($user === false) header('Location: ./../login');
    $servers = DB->getUserServers($user['user_id']);
    $tickets = $user['rank'] == 0 ? DB->getUserTickets($user['user_id']) : DB->getAllUsersTickets();
    if($user['rank'] == 0){
        if(!DB->userServerCheck($user['user_id'], $id)) header('Location: ./../dashboard');
    } else {
        if(DB->getServer($id) == false) header('Location: ./../dashboard');
    }
    $server = DB->getServer($id);
    $plan = DB->getPlanByName(DB->getServer($id)['plan_name']);
    require_once 'views/client/pannel.php';
});

$router->get('client/ticket', function(){
    if(!isset($_COOKIE['token'])) header('Location: ./../login');
    $user = DB->getUserByToken($_COOKIE['token']);
    if($user === false) header('Location: ./../login');
    $servers = DB->getUserServers($user['user_id']);
    $tickets = $user['rank'] == 0 ? DB->getUserTickets($user['user_id']) : DB->getAllUsersTickets();
    require_once 'views/client/ticket.php';
});

$router->get('client/ticket/:id', function($id){
    if(!isset($_COOKIE['token'])) header('Location: ./../login');
    $user = DB->getUserByToken($_COOKIE['token']);
    if($user === false) header('Location: ./../login');
    $servers = DB->getUserServers($user['user_id']);
    $tickets = $user['rank'] == 0 ? DB->getUserTickets($user['user_id']) : DB->getAllUsersTickets();
    if($tickets == false) header('Location: ./../ticket');
    require_once 'views/client/ticket.php';
});

// !- ADMIN ROUTES -!

$router->get('admin/users', function(){
    if(!isset($_COOKIE['token'])) header('Location: ./../login');
    $user = DB->getUserByToken($_COOKIE['token']);
    if($user === false) header('Location: ./../login');
    if($user['rank'] == 0) header('Location: ./../login');
    $tickets = DB->getAllTickets();
    $servers = DB->getAllServers();
    $users = DB->getAllUsers();
    $servers = DB->getUserServers($user['user_id']);
    $tickets = $user['rank'] == 0 ? DB->getUserTickets($user['user_id']) : DB->getAllUsersTickets();
    require_once 'views/admin/users.php';
});

$router->get('admin/services', function(){
    if(!isset($_COOKIE['token'])) header('Location: ./../login');
    $user = DB->getUserByToken($_COOKIE['token']);
    if($user === false) header('Location: ./../login');
    if($user['rank'] == 0) header('Location: ./../login');
    $tickets = DB->getAllTickets();
    $servers = DB->getAllServers();
    $servers = DB->getUserServers($user['user_id']);
    $tickets = $user['rank'] == 0 ? DB->getUserTickets($user['user_id']) : DB->getAllUsersTickets();
    require_once 'views/admin/services.php';
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

//& ORDER ROUTES

$router->post('/api/client/order', function(){
    require_once 'api/client/order.php';
});

//& TICKET ROUTES

$router->post('/api/client/ticket', function(){
    require_once 'api/client/ticket.php';
});

//& ALL ADMIN ROUTES

$router->post('/api/admin/services', function(){
    require_once 'api/admin/services.php';
});

$router->post('/api/admin/users', function(){
    require_once 'api/admin/users.php';
});

// ------- RUN ROUTER -------

$router->run();
?>