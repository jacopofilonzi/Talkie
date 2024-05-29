<?php


    include_once $_SERVER['DOCUMENT_ROOT'] . "/inc/config.inc.php";

    include_once $_SERVER['DOCUMENT_ROOT'] . "/class/dmo/UserDMO.cls.php";
    include_once $_SERVER['DOCUMENT_ROOT'] . "/class/bl/UserBL.cls.php";


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $DATA = json_decode(file_get_contents('php://input'), true);


        //Define the request client
        $internal = isset($DATA["Internal"]) && $DATA["Internal"] == "on" ? true : false;

        //Reject external clients
        if (!$internal && !$AllowExternal) {
            http_response_code(401);
            echo json_encode(array('success'=> false, 'error' => 'Unauthorized'));
            exit();
        }


        $_email = isset($DATA['Email']) ? $DATA['Email'] : null;
        
        if (!isset($_email) || empty($_email)) {
            http_response_code(400);
            echo json_encode(array('success'=> false, 'error' => 'Email is required'));
            exit();
        } else if (!filter_var($_email, FILTER_VALIDATE_EMAIL)) {
            http_response_code(400);
            echo json_encode(array('success'=> false, 'error' => 'Invalid email'));
            exit();
        }

        #region Check parameters



        $user = UserBL::Find(null, null, null, $_email);

        if (count($user) == 0) {
            http_response_code(400);
            echo json_encode(array('success'=> false, 'error' => 'User not found'));
            exit();
        }

        echo json_encode(array('success'=> true, 'UserID' => $user[0]->getID()));

    }