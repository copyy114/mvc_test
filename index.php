<?php
// index.php

// โหลด database config และ model
$config = include './config/database.php';
require './app/models/UserModel.php';
require './app/controllers/AuthController.php';

// ตรวจสอบ URL ที่ร้องขอ
$url = isset($_GET['url']) ? rtrim($_GET['url'], '/') : '';

// เริ่มต้น Controller
$controller = new AuthController(new UserModel($config));

// ตรวจสอบและเรียกใช้เมธอดตาม URL ที่ร้องขอ
if ($url === 'login' || $_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->login();
} elseif ($url === 'home') {
    $controller->home();
} elseif ($url === 'logout') {
    $controller->logout();
} else {
    echo "Page not found";
}
