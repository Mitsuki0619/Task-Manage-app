<?php

require_once '../config/dbconnect.php';

class UserLogic
{
    public static function createUser($userdata) 
    {
        $result = false;
        $sql = "SELECT * FROM users WHERE username = :username";
        $stmt = connect()->prepare($sql);
        $stmt->bindValue(':username', $userdata['username']);
        $stmt->execute();
        $member = $stmt->fetch();
        if($member['username'] === $userdata['username']) {
            return $result;
        } else {
            $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
    
            $arr = [];
    
            $arr[] = $userdata['username'];
            $arr[] = password_hash($userdata['password'], PASSWORD_DEFAULT);
    
            try {
                $stmt = connect()->prepare($sql);
                $result = $stmt->execute($arr);
                return $result;
    
            } catch(\Exception $e) {
                return $result;
            }
        }

    }

    public static function login($username, $password) 
    {
        $result = false;

        $user = self::getUser($username);

        if(!$user) {
            return $result;
        }

        if(password_verify($password, $user['password'])) {
            session_regenerate_id(true);
            $_SESSION['login_user'] = $user;
            $result = true;
            return $result;
        }
        return $result;
    }

    public static function getUser($username)
    {
        $sql = "SELECT * FROM users WHERE username = ?";
        
        $arr = [];
        $arr[] = $username;

        try {
            $stmt = connect()->prepare($sql);
            $stmt->execute($arr);
            $user = $stmt->fetch();
            return $user;
        } catch(\Exception $e) {
            return false;
        }
    }

    public static function checkLogin() {
        if(isset($_SESSION['login_user']) || isset($_SESSION['login_user']['id'])) {
            return true;
        }else {
            return false;
        }
    }

    public static function Logout() {
        $_SESSION = array();
        session_destroy();
        header('Location: login.php');
    }
}