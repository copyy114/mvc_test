<?php
// app/models/UserModel.php

class UserModel {
    private $db;

    public function __construct($config) {
        // สร้างการเชื่อมต่อกับฐานข้อมูล
        try {
            $this->db = new PDO(
                "mysql:host=" . $config['db_host'] . ";dbname=" . $config['db_name'], 
                $config['db_user'], 
                $config['db_pass']
            );
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db->exec("set names utf8");
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    public function checkLogin($username, $password) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user && password_verify($password, $user['password'])) {
            $this->updateLoginTime($user['id']);
            return $user;
        }
        return false;
    }

    private function updateLoginTime($userId) {
        $stmt = $this->db->prepare("UPDATE users SET last_login = NOW() WHERE id = :id");
        $stmt->bindParam(':id', $userId);
        $stmt->execute();
    }
}
