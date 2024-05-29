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
        if (!isset($data['FirstUserID']) || empty($data['FirstUserID']))
        {
            http_response_code(400);
            echo json_encode(array('success'=> false, 'error' => 'FirstUserID is required'));
            exit();
        }
        else if (!filter_var($data['FirstUserID'], FILTER_VALIDATE_INT))
        {
            http_response_code(400);
            echo json_encode(array('success'=> false, 'error' => 'Invalid FirstUserID'));
            exit();
        }

        if (!isset($data["SecondUserID"]) || empty($data["SecondUserID"]))
        {
            http_response_code(400);
            echo json_encode(array('success'=> false, 'error' => 'SecondUserID is required'));
            exit();
        }
        else if (!filter_var($data['SecondUserID'], FILTER_VALIDATE_INT))
        {
            http_response_code(400);
            echo json_encode(array('success'=> false, 'error' => 'Invalid SecondUserID'));
            exit();
        }

        #endregion

        //-------------------------------------

        #region Check authentication

        //Check if the user is logged in


        if ($_SESSION['user']->getID() != $data['FirstUserID'] &&
            $_SESSION['user']->getID() != $data['SecondUserID']) 
        {
            http_response_code(401);
            echo json_encode(array('success'=> false, 'error' => 'Unauthorized'));
            exit();
        }

        #endregion

        //-------------------------------------

        #region Set message

        $messages1 = MessageBL::Find($data['FirstUserID'], $data['SecondUserID']);
        $messages2 = MessageBL::Find($data['SecondUserID'], $data['FirstUserID']);


        $messages = array_merge($messages1, $messages2);

        // Order the messages by date
        usort($messages, function($a, $b) {
            return strtotime($a->getDate()) - strtotime($b->getDate());
        });

        $_jsonDump = array();

        foreach ($messages as $message) {
            $_jsonDump[] = array(
                'ID' => $message->getID(),
                'SenderID' => $message->getSenderID(),
                'ReceiverID' => $message->getReceiverID(),
                'Content' => $message->getContent(),
                'Date' => $message->getDate()
            );
        }


        header('Content-Type: application/jso   n');
        echo json_encode($_jsonDump);

    
    } else {
        http_response_code(405);
        echo json_encode(array('success'=> false, 'error' => 'Method not allowed'));
        exit();
    }