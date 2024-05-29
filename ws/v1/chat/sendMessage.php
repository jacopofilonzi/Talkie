<?php

    include_once $_SERVER['DOCUMENT_ROOT'] . "/inc/config.inc.php";

    include_once $_SERVER['DOCUMENT_ROOT'] . "/class/dmo/MessageDMO.cls.php";
    include_once $_SERVER['DOCUMENT_ROOT'] . "/class/bl/MessageBL.cls.php";

    include_once $_SERVER['DOCUMENT_ROOT'] . "/class/DMO/UserDMO.cls.php";
    include_once $_SERVER['DOCUMENT_ROOT'] . "/class/bl/UserBL.cls.php";



    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $data = json_decode(file_get_contents('php://input'), true);



        //Define the request client
        $internal = isset($data["internal"]) && $data["internal"] == "on" ? true : false;

        


        //Reject external clients
        if (!$internal && !$AllowExternal)
        {
            http_response_code(401);
            echo json_encode(array('success'=> false, 'error' => 'Unauthorized'));
            exit();
        }



        #region Check parameters

        //Check user id
        if (!isset($data['SenderID']) || empty($data['SenderID']))
        {
            http_response_code(400);
            echo json_encode(array('success'=> false, 'error' => 'SenderID is required'));
            exit();
        }
        else if (!filter_var($data['SenderID'], FILTER_VALIDATE_INT))
        {
            http_response_code(400);
            echo json_encode(array('success'=> false, 'error' => 'Invalid SenderID'));
            exit();
        }

        if (!isset($data["ReciverID"]) || empty($data["ReciverID"]))
        {
            http_response_code(400);
            echo json_encode(array('success'=> false, 'error' => 'ReciverID is required'));
            exit();
        }
        else if (!filter_var($data['ReciverID'], FILTER_VALIDATE_INT))
        {
            http_response_code(400);
            echo json_encode(array('success'=> false, 'error' => 'Invalid ReciverID'));
            exit();
        }

        if (!isset($data["Message"]) || empty($data["Message"]))
        {
            http_response_code(400);
            echo json_encode(array('success'=> false, 'error' => 'Message is required'));
            exit();
        }

        #endregion

        //-------------------------------------

        #region Check authentication

        //Check if the user is logged in

        if ($_SESSION['user']->getID() != $data['SenderID']) {
            http_response_code(401);
            echo json_encode(array('success'=> false, 'error' => 'Unauthorized'));
            exit();
        }

        #endregion

        //-------------------------------------

        #region Set message

        $message = new MessageDMO($data['SenderID'], $data['ReciverID'], $data['Message'], date("Y-m-d H:i:s"));

        $result = MessageBL::Create($message, $error);


        if ($result <= 0) {
            http_response_code(500);
            echo json_encode(array('success'=> false, 'error' => $error));
            exit();
        } else {
            echo json_encode(array('success'=> true, 'messageID' => $result));
        }



    
    } else {
        http_response_code(405);
        echo json_encode(array('success'=> false, 'error' => 'Method not allowed'));
        exit();
    }