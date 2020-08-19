<?php
namespace Controller;

use Model\Services\UserService;

class HomeController
{

    public function home()
    {
        require ("View/HomeView.php");
    }

    public function register()
    {
        $service = new UserService();

        $username = $_POST['username'];
        $password = $_POST['password'];
        if ($username == '') {
            $_POST['reg_msg'] = "username cannot be empty";
            require ("View/HomeView.php");
            return;
        }
        if ($password == '') {
            $_POST['reg_msg'] = "password cannot be empty";
            require ("View/HomeView.php");
            return;
        }

        $result = $service->registerUser($username, password_hash($password, PASSWORD_DEFAULT));
        if ($result['success']) {
            setcookie('user_id', $result['user']['user_id']);
            require ("View/CombatSetupView.html");
        } else {
            $_POST['reg_msg'] = "username already taken";
            require ("View/HomeView.php");
        }
    }

    public function login()
    {
        $service = new UserService();

        $username = $_POST['username'];
        $password = $_POST['password'];

        $result = $service->checkUser($username, $password);
        if ($result['success']) {
            setcookie('user_id', $result['user']['user_id']);
            require ("View/CombatSetupView.html");
        } else {
            $_POST['log_msg'] = "username/password don't match";
            require ("View/HomeView.php");
        }
    }
}