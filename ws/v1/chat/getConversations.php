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
        if (!isset($data['UserID']) || empty($data['UserID']))
        {
            http_response_code(400);
            echo json_encode(array('success'=> false, 'error' => 'UserID is required'));
            exit();
        }
        else if (!filter_var($data['UserID'], FILTER_VALIDATE_INT))
        {
            http_response_code(400);
            echo json_encode(array('success'=> false, 'error' => 'Invalid UserID'));
            exit();
        }

        #endregion

        //-------------------------------------

        #region Check authentication

        //Check if the user is logged in

        if ($_SESSION['user']->getID() != $data['UserID']) {
            http_response_code(401);
            echo json_encode(array('success'=> false, 'error' => 'Unauthorized'));
            exit();
        }

        #endregion

        //-------------------------------------

        #region Get conversations

        $users = UserBL::GetConversations($data['UserID']);
        $_users = array();

        foreach ($users as $user) {
            $_users[] = array(
                'ID' => $user->getID(),
                'Name' => $user->getName(),
                'Surname' => $user->getSurname(),
                'Email' => $user->getEmail()
            );
        }

        echo json_encode(array('success'=> true, 'users' => $_users));

    
    } else {
        http_response_code(405);
        echo json_encode(array('success'=> false, 'error' => 'Method not allowed'));
        exit();
    }