<?php
// app/controllers/AuthController.php

class AuthController {
    private $model;

    public function __construct($model) {
        $this->model = $model;
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $user = $this->model->checkLogin($username, $password);

            if ($user) {
                session_start();
                $_SESSION['user'] = $user;
                header("Location: index.php?url=home");
                exit();
            } else {
                echo "Invalid username or password.";
                include "../app/views/login.php";
            }
        } else {
            include "../app/views/login.php";
        }
    }

    public function home() {
        session_start();
        if (isset($_SESSION['user'])) {
            include "../app/views/home.php";
        } else {
            header("Location: index.php?url=login");
            exit();
        }
    }

    public function logout() {
        session_start();
        session_unset();
        session_destroy();
        header("Location: index.php?url=login");
        exit();
    }
}
