<?php

    include_once $_SERVER['DOCUMENT_ROOT'] . "/inc/config.inc.php";

    include_once $_SERVER['DOCUMENT_ROOT'] . "/class/dmo/UserDMO.cls.php";
    include_once $_SERVER['DOCUMENT_ROOT'] . "/class/bl/UserBL.cls.php";

    

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        //Define the request client
        $internal = isset($_POST["Internal"]) && $_POST["Internal"] == "on" ? true : false;

        //Reject external clients
        if (!$internal && !$AllowExternal) {
            http_response_code(401);
            echo json_encode(array('success'=> false, 'error' => 'Unauthorized'));
            exit();
        }

        #region Check parameters


        //Check email
        if (!isset($_POST['Email']) || empty($_POST['Email']))
            if ($internal) {
                redirect("/register?error=Email is required");
            } else {
                http_response_code(400);
                echo json_encode(array('success'=> false, 'error' => 'Email is required'));
                exit();
            }
        else if (!filter_var($_POST['Email'], FILTER_VALIDATE_EMAIL))
            if ($internal) {
                redirect("/register?error=Invalid email");
            } else {
                http_response_code(400);
                echo json_encode(array('success'=> false, 'error' => 'Invalid email'));
                exit();
            }
            

        //Check password
        if (!isset($_POST['Password']) || empty($_POST['Password']))
            if ($internal) {
                redirect("/register?error=Password is required");
            } else {
                http_response_code(400);
                echo json_encode(array('success'=> false, 'error' => 'Password is required'));
                exit();
            }


        #endregion

        //-------------------------------------
        
        #region Check authentication

        $users = UserBL::Find(null, null, null, $_POST['Email']);
        

        if (count($users) == 1 && $users[0]->CheckPassword($_POST['Password'])) {
            $_SESSION['user'] = $users[0];
            
            if ($internal) {
                redirect("/index.php");
            } else {
                http_response_code(200);
                echo json_encode(array('success'=> true, 'message' => 'Authorized'));
                exit();
            }
        }
        elseif (count($users) > 1)
        {
            if ($internal) {
                redirect("/login?error=An internal error occurred, Please contact the administrator");
            } else {
                http_response_code(400);
                echo json_encode(array('success'=> false, 'error' => 'Internal error', 'message' => 'An internal error occurred, Please contact the administrator'));
                exit();
            }
        }
        else
        {
            if ($internal) {
                redirect("/login?error=Combination of email and password not valid");
            } else {
                http_response_code(401);
                echo json_encode(array('success'=> false, 'error' => 'Unauthorized', 'message' => 'Combination of email and password not valid'));
                exit();
            }
        }

        #endregion

    } else {
        http_response_code(405);
        echo json_encode(array('success'=> false, 'error' => 'Method not allowed'));
        exit();
    }