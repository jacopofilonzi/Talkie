<?php

    include_once $_SERVER['DOCUMENT_ROOT'] . "/inc/config.inc.php";
    include_once $_SERVER['DOCUMENT_ROOT'] . "/class/dmo/user.cls.php";
    include_once $_SERVER['DOCUMENT_ROOT'] . "/class/bl/user.cls.php";

    

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        //Define the request client
        $internal = isset($_POST["Internal"]) && $_POST["Internal"] == "on" ? true : false;

        //Reject external clients
        if (!$internal) {
            http_response_code(401);
            echo json_encode(array('error' => 'Unauthorized'));
            die();
        }

        #region Check parameters


        //Check email
        if (!isset($_POST['Email']) || empty($_POST['Email']))
            if ($internal) {
                redirect("/register?error=Email is required");
            } else {
                http_response_code(400);
                echo json_encode(array('error' => 'Email is required'));
                die();
            }
        else if (!filter_var($_POST['Email'], FILTER_VALIDATE_EMAIL))
            if ($internal) {
                redirect("/register?error=Invalid email");
            } else {
                http_response_code(400);
                echo json_encode(array('error' => 'Invalid email'));
                die();
            }
            

        //Check password
        if (!isset($_POST['Password']) || empty($_POST['Password']))
            if ($internal) {
                redirect("/register?error=Password is required");
            } else {
                http_response_code(400);
                echo json_encode(array('error' => 'Password is required'));
                die();
            }


        #endregion

        //-------------------------------------
        
        #region Check authentication

        $user = UserBL::Authenticate($_POST['Email'], $_POST['Password']);


        if ($user != null) {
            $_SESSION['user'] = $user;
            redirect("/index.php");
        } else {
            if ($internal) {
                redirect("/login?error=Invalid credentials");
            } else {
                http_response_code(400);
                echo json_encode(array('error' => 'Invalid credentials'));
                die();
            }
        }

        #endregion

    } else {
        http_response_code(400);
        echo json_encode(array('error' => 'Invalid request'));
        die();
    }