<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . "/inc/config.inc.php";
    include_once $_SERVER['DOCUMENT_ROOT'] . "/class/dmo/UserDMO.cls.php";
    include_once $_SERVER['DOCUMENT_ROOT'] . "/class/bl/UserBL.cls.php";

    $today = new DateTime();
    

    //Params
    $MinAge = 13;

    $MinNameLength = 3;
    $MaxNameLength = 40;

    $MinSurnameLength = 3;
    $MaxSurnameLength = 40;

    $MinPasswordLength = 8;


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        //Define the request client
        $internal = isset($_POST["Internal"]) && $_POST["Internal"] == "on" ? true : false;


        //Reject external clients
        if (!$internal && !$AllowExternal) {
            http_response_code(401);
            echo json_encode(array('error' => 'Unauthorized'));
            exit();
        }


        #region Check parameters

        //Check name
        if (!isset($_POST['Name']) || empty($_POST['Name']))
            if ($internal) {
                redirect("/register?error=Name is required");
            } else {
                http_response_code(400);
                echo json_encode(array('error' => 'Name is required'));
                exit();
            }
        else if (strlen($_POST['Name']) <= $MinNameLength)
            if ($internal) {
                redirect("/register?error=Name is too short");
            } else {
                http_response_code(400);
                echo json_encode(array('error' => 'Name is too short'));
                exit();
            }
        else if (strlen($_POST['Name']) >= $MaxNameLength)
            if ($internal) {
                redirect("/register?error=Name is too long");
            } else {
                http_response_code(400);
                echo json_encode(array('error' => 'Name is too long'));
                exit();
            }

        
        //Check surname
        if (!isset($_POST['Surname']) || empty($_POST['Surname']))
            if ($internal) {
                redirect("/register?error=Surname is required");
            } else {
                http_response_code(400);
                echo json_encode(array('error' => 'Surname is required'));
                exit();
            }
        else if (strlen($_POST['Surname']) <= $MinSurnameLength)
            if ($internal) {
                redirect("/register?error=Surname is too short");
            } else {
                http_response_code(400);
                echo json_encode(array('error' => 'Surname is too short'));
                exit();
            }
        else if (strlen($_POST['Surname']) >= $MaxSurnameLength)
            if ($internal) {
                redirect("/register?error=Surname is too long");
            } else {
                http_response_code(400);
                echo json_encode(array('error' => 'Surname is too long'));
                exit();
            }

        
        //Check birthday
        if (!isset($_POST['DateOfBirth']) || empty($_POST['DateOfBirth']))
            if ($internal) {
                redirect("/register?error=Birthday is required");
            } else {
                http_response_code(400);
                echo json_encode(array('error' => 'Birthday is required'));
                exit();
            }
        else if (strlen($_POST['DateOfBirth']) != 10)
            if ($internal) {
                redirect("/register?error=Invalid date of birth");
            } else {
                http_response_code(400);
                echo json_encode(array('error' => 'Invalid date of birth'));
                exit();
            }
        else if ($today->diff(new DateTime($_POST["DateOfBirth"]))->y > $MinAge && $today->diff(new DateTime($_POST["DateOfBirth"]))->m > 0 && $today->diff(new DateTime($_POST["DateOfBirth"]))->d > 0)
            if ($internal) {
                redirect("/register?error=You must be at least 13 years old");
            } else {
                http_response_code(400);
                echo json_encode(array('error' => 'You must be at least 13 years old'));
                exit();
            }

        
        //Check email
        if (!isset($_POST['Email']) || empty($_POST['Email']))
            if ($internal) {
                redirect("/register?error=Email is required");
            } else {
                http_response_code(400);
                echo json_encode(array('error' => 'Email is required'));
                exit();
            }
        else if (!filter_var($_POST['Email'], FILTER_VALIDATE_EMAIL))
            if ($internal) {
                redirect("/register?error=Invalid email");
            } else {
                http_response_code(400);
                echo json_encode(array('error' => 'Invalid email'));
                exit();
            }

        
        //Check password
        if (!isset($_POST['Password']) || empty($_POST['Password']))
            if ($internal) {
                redirect("/register?error=Password is required");
            } else {
                http_response_code(400);
                echo json_encode(array('error' => 'Password is required'));
                exit();
            }
        else if (strlen($_POST['Password']) < $MinPasswordLength)
            if ($internal) {
                redirect("/register?error=Password is too short");
            } else {
                http_response_code(400);
                echo json_encode(array('error' => 'Password is too short'));
                exit();
            }
        else if ($_POST['Password'] != $_POST['PasswordConfirm'])
            if ($internal) {
                redirect("/register?error=Passwords do not match");
            } else {
                http_response_code(400);
                echo json_encode(array('error' => 'Passwords do not match, you must send "Password" and "PasswordConfirm" with the same value'));
                exit();
            }

        
        //Check ToS
        if (!isset($_POST['ToSacknowledge']) || empty($_POST['ToSacknowledge']))
            if ($internal) {
                redirect("/register?error=You must accept the Terms of Service");
            } else {
                http_response_code(400);
                echo json_encode(array('error' => 'You must accept the Terms of Service (ToSacknowledge)'));
                exit();
            }

        #endregion

        //-------------------------------------

        #region Register user

        $user = new UserDMO(
            $_POST['Name'],
            $_POST['Surname'],
            $_POST['DateOfBirth'],
            $_POST['Email'],
            $_POST['Password'],
            false
        );

        $result = UserBL::Create($user);


        if ($result >= 1) {
            $_SESSION["user"] = $user;

            if ($internal) {
                redirect("/index.php");
            } else {
                http_response_code(200);
                echo json_encode(array('success' => 'Registration successful'));
            }
        } else {
            if ($result == -1) {
                if ($internal) {
                    redirect("/register?error=Email already in use");
                } else {
                    http_response_code(400);
                    echo json_encode(array('error' => 'Email already in use'));
                }
            } else {
                if ($internal) {
                    redirect("/register?error=An error occurred");
                } else {
                    http_response_code(400);
                    echo json_encode(array('error' => 'An error occurred'));
                }
            }
        }

        #endregion
        
    } else {
        http_response_code(405);
        echo json_encode(array('success'=> false, 'error' => 'Method not allowed'));
        exit();
    }