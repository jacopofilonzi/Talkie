<?php

/**
 * Business Logic for Message
 * 
 * 
 */
class MessageBL
{
    
    #region CRUD

    /**
    * Create a new message
    * 
    * @param MessageDMO $message
    * 
    * @return int 0 = generic error, 1 <= = success (message id)
    */
    public static function Create(&$message, &$error = null)
    {
        $query = "INSERT INTO messages (SenderID, ReciverID, Content, Timestamp) VALUES (?, ?, ?, ?)";

        $params = array(
            $message->getSenderID(),
            $message->getReceiverID(),
            $message->getContent(),
            $message->getDate()
        );

        $result = Database::ExecuteQuery($query, $params, "iiss", $error);

        if ($error != null || $result <= 0) {
        // Handle errors
            if (strpos($error, "Duplicate entry") === 0)
                return -1; //Duplicate entry
            else
                return 0; //Generic error
        } else {
            $message->setID($result);
            return $result;
        }
    }

    /**
    * Read a message
    * 
    * @param int|null $id ID of the message (optional)
    * 
    * @return MessageDMO|MessageDMO[]|null MessageDMO if found, null otherwise
    */
    public static function Read($id = null, &$error = null)
    {
        $query = $id == null ? "SELECT * FROM messages" : "SELECT * FROM messages WHERE ID = ?";

        $params = array();

        if ($id != null) {
            $params[] = $id;
        }

        $result = Database::ExecuteQuery($query, $params, "i", $error);

        if ($error != null || $result == null) {
            // Handle errors
            return null;
        } else {
            if ($id == null) {
                $messages = array();
                foreach ($result as $row) {
                    $messages[] = new MessageDMO($row["SenderID"], $row["ReceiverID"], $row["Content"], $row["Date"], $row["ID"]);
                }
                return $messages;
            } else {
                return new MessageDMO($result["SenderID"], $result["ReceiverID"], $result["Content"], $result["Date"], $result["ID"]);
            }
        }
    }

    /**
    * Update a message
    * 
    * @param MessageDMO $message
    *
    * @return bool Success of the operation
    */
    public static function Update($message, &$error = null)
    {
        $query = "UPDATE messages SET SenderID = ?, ReceiverID = ?, Content = ?, Date = ? WHERE ID = ?";

        $params = array(
            $message->getSenderID(),
            $message->getReceiverID(),
            $message->getContent(),
            $message->getDate(),
            $message->getID()
        );

        $result = Database::ExecuteQuery($query, $params, "iissi", $error);

        return $error == null && $result > 0;
    }

    /**
     * Delete a message
     * 
     * @param int $id ID of the message
     * 
     * @return bool Success of the operation
     */
    public static function Delete($id, &$error = null)
    {
        $query = "DELETE FROM messages WHERE ID = ?";

        $params = array($id);

        $result = Database::ExecuteQuery($query, $params, "i", $error);

        return $error == null && $result <= 0;
        
    }

    #endregion

    #region Methods

    /**
     * Find messages
     * 
     * @param int|null $senderID ID of the sender (optional)
     * @param int|null $receiverID ID of the receiver (optional)
     * @param string|null $content Content of the message (optional)
     * @param string|null $date Date of the message (optional)
     * 
     * @return MessageDMO[]|null Array of MessageDMO
     */
    public static function Find($senderID = null, $reciverID = null, $content = null, $dateMin = null, $dateMax = null, $limit = 15, &$error = null)
    {
        $query = "SELECT * FROM messages WHERE 1 = 1";

        $params = array();

        if ($senderID != null) {
            $query .= " AND SenderID = ?";
            $params[] = $senderID;
        }

        if ($reciverID != null) {
            $query .= " AND ReciverID = ?";
            $params[] = $reciverID;
        }

        if ($content != null) {
            $query .= " AND Content = ?";
            $params[] = $content;
        }

        if ($dateMin != null) {
            $query .= " AND Date >= ?";
            $params[] = $dateMin;
        }

        if ($dateMax != null) {
            $query .= "AND Date <= ?";
            $params[] = $dateMax;
        }

        
        
        // $query .= " LIMIT ?";
        // $params[] = $limit;

        $result = Database::ExecuteQuery($query, $params, str_repeat("s", count($params)), $error);


        if ($error != null || ($result == null && count($result) != 0)) {
            // Handle errors
                return null;
        } else {
            $messages = array();
            foreach ($result as $row) {
                $messages[] = new MessageDMO($row["SenderID"], $row["ReciverID"], $row["Content"], $row["Timestamp"], $row["ID"]);
            }
            return $messages;
        }
    }

    public static function GetChatBetween($senderEmail, $reciverEmail, $page = 1, $limit = 20, &$error = null)
    {
        $query = "SELECT * FROM messages WHERE (SenderID = (SELECT ID FROM users WHERE Email = ?) AND ReceiverID = (SELECT ID FROM users WHERE Email = ?)) OR (SenderID = (SELECT ID FROM users WHERE Email = ?) AND ReceiverID = (SELECT ID FROM users WHERE Email = ?)) ORDER BY Date DESC LIMIT ?, ?";

        $params = array(
            $senderEmail,
            $reciverEmail,
            $reciverEmail,
            $senderEmail,
            ($page - 1) * $limit,
            $limit
        );

        $result = Database::ExecuteQuery($query, $params, "ssssii", $error);

        if ($error != null || $result == null) {
            // Handle errors
            return null;
        } else {
            $messages = array();
            foreach ($result as $row) {
                $messages[] = new MessageDMO($row["SenderID"], $row["ReceiverID"], $row["Content"], $row["Date"], $row["ID"]);
            }
            return $messages;
        }
    }

    public static function GetNewMessages($receiverEmail, &$error = null)
    {
        $query = "SELECT * FROM messages WHERE ReceiverID = (SELECT ID FROM users WHERE Email = ?) AND Date > (SELECT LastUpdate FROM users WHERE Email = ?)";

        $params = array(
            $receiverEmail,
            $receiverEmail
        );

        $result = Database::ExecuteQuery($query, $params, "ss", $error);

        if ($error != null || $result == null) {
            // Handle errors
            return null;
        } else {
            $messages = array();
            foreach ($result as $row) {
            $messages[] = new MessageDMO($row["SenderID"], $row["ReceiverID"], $row["Content"], $row["Date"], $row["ID"]);
            }

            
            // Update the LastUpdate column for the receiver user
            $updateQuery = "UPDATE users SET LastUpdate = NOW() WHERE Email = ?";
            $updateParams = array($receiverEmail);
            Database::ExecuteQuery($updateQuery, $updateParams, "s");
            return $messages;
        }
    }
    #endregion
}