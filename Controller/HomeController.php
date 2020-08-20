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
            $reg_msg = "username cannot be empty";
            
            require ("View/HomeView.php");
            return;
        }
        if ($password == '') {
            $reg_msg = "password cannot be empty";
            require ("View/HomeView.php");
            return;
        }

        $result = $service->registerUser($username, password_hash($password, PASSWORD_DEFAULT));
        if ($result['success']) {
            $_SESSION['user_id'] = $result['user']['user_id'];
            $_SESSION['zone_id'] = $result['user']['current_zone'];
            require ("View/CombatSetupView.html");
        } else {
            $reg_msg = "username already taken";
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
            $_SESSION['user_id'] = $result['user']['user_id'];
            $_SESSION['zone_id'] = $result['user']['current_zone'];
            require ("View/CombatSetupView.html");
        } else {
            $log_msg = "username/password don't match";
            require ("View/HomeView.php");
        }
    }
}