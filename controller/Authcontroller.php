<?php
/**
 * Created by PhpStorm.
 * User: Tobias
 * Date: 07.05.2018
 * Time: 12:44
 */

namespace controller;

use service\AuthServiceImpl;

class AuthController
{

    public static function authenticate(){
        if (isset($_SESSION["agentLogin"])) {
            if(AuthServiceImpl::getInstance()->validateToken($_SESSION["agentLogin"]["token"])) {
                return true;
            }
        }
        if (isset($_COOKIE["token"])) {
            if(AuthServiceImpl::getInstance()->validateToken($_COOKIE["token"])) {
                return true;
            }
        }
        return false;
    }

    public static function login(){
        $authService = AuthServiceImpl::getInstance();
        if($authService->verifyUser($_POST["email"],$_POST["password"]))
        {
            $token = $authService->issueToken();
            $_SESSION["agentLogin"]["token"] = $token;
            if(isset($_POST["remember"])) {
                setcookie("token", $token, (new \DateTime('now'))->modify('+30 days')->getTimestamp(), "/");
            }
        }
    }

    public static function logout(){
        session_destroy();
        setcookie("token","",time() - 3600, "/");
    }

}