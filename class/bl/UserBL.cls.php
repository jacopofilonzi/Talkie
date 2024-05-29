<?php 

include_once $_SERVER['DOCUMENT_ROOT'] . "/inc/database.inc.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/class/dmo/UserDMO.cls.php";


/**
 * Business Logic for User
 */
class UserBL
{

    #region CRUD

    /**
     * Register a new user
     * 
     * @param UserDMO $user
     *
     * @return int 0 = generic error, 1 <= = success (user id), -1 = duplicate entry
     */
    public static function Create(&$user, &$error = null)
    {
        
        $query = "INSERT INTO users (Name, Surname, DateOfBirth, Email, Password) VALUES (?, ?, ?, ?, ?)";

        $params = array(
            $user->getName(),
            $user->getSurname(),
            $user->getBirthday(),
            $user->getEmail(),
            $user->getPassword()
        );

        $result = Database::ExecuteQuery($query, $params, "sssss", $error);
        
        if ($error != null || $result <= 0) {
            // Handle errors
            if (strpos($error, "Duplicate entry") === 0)
                return -1; //Duplicate entry
            else
                return 0; //Generic error
        } else {
            $user->setID($result);
            return $result;
        }
    }

    /**
     * Read a user
     * 
     * @param int|null $id ID of the user (optional)
     * 
     * @return UserDMO|UserDMO[]|null UserDMO if found, null otherwise
     */
    public static function Read($id = null, &$error = null)
    {
        $query = $id == null ? "SELECT * FROM users" : "SELECT * FROM users WHERE ID = ?";

        $params = array();

        if ($id != null) {
            $params[] = $id;
        }

        $result = Database::ExecuteQuery($query, $params, "i", $error);


        if ($error != null)
        {
            // Handle errors
            return null;
        }
        else
        {
            $users = array();

            foreach ($result as $row) {
                $user = new UserDMO(
                    $row['Name'],
                    $row['Surname'],
                    $row['DateOfBirth'],
                    $row['Email'],
                    $row['Password'],
                    true,
                    $row['ID']
                );
                $users[] = $user;
            }

            return $id == null ? $users : $users[0];
        }
    }


    /**
     * Update a user
     * 
     * @param UserDMO $user
     * 
     * @return int 0 = generic error, 1 = success
     */
    public static function Update($user, &$error = null)
    {
        $query = "UPDATE users SET Name = ?, Surname = ?, DateOfBirth = ?, Email = ?, Password = ?, LastUpdate = ? WHERE ID = ?";

        $params = array(
            $user->getName(),
            $user->getSurname(),
            $user->getBirthday(),
            $user->getEmail(),
            $user->getPassword(),
            $user->getLastUpdate(),
            $user->getID()
        );

        $result = Database::ExecuteQuery($query, $params, "sssssi", $error);

        if ($error != null || $result <= 0) {
            // Handle errors
            return 0; //Generic error
        } else {
            return $result;
        }
    }

    /**
     * Delete a user
     * 
     * @param int $id
     * 
     * @return bool Success of the operation
     */
    public static function Delete($id, &$error = null)
    {
        $query = "DELETE FROM users WHERE ID = ?";

        $params = array(
            $id
        );

        $result = Database::ExecuteQuery($query, $params, "i", $error);

        return $error == null && $result <= 0;

    }
    #endregion

    #region Methods

    /**
     * Find a user
     * 
     * @param int|null $id ID of the user
     * @param string|null $name Name of the user
     * @param string|null $surname Surname of the user
     * @param string|null $email Email of the user
     * @param string|null $dateOfBirth Date of birth of the user
     * 
     * @return UserDMO[]|null Array of UserDMO
     */
    public static function Find($id = null, $name = null, $surname = null, $email = null, $dateOfBirth = null, $LastUpdate = null, &$error = null) 
    {
        $query = "SELECT * FROM users WHERE 1 = 1";

        $params = array();

        if ($id != null) {
            $query .= " AND ID = ?";
            $params[] = $id;
        }

        if ($name != null) {
            $query .= " AND Name = ?";
            $params[] = $name;
        }

        if ($surname != null) {
            $query .= " AND Surname = ?";
            $params[] = $surname;
        }

        if ($email != null) {
            $query .= " AND Email = ?";
            $params[] = $email;
        }

        if ($dateOfBirth != null) {
            $query .= " AND DateOfBirth = ?";
            $params[] = $dateOfBirth;
        }

        if ($LastUpdate != null) {
            $query .= " AND LastUpdate = ?";
            $params[] = $LastUpdate;
        }


        $result = Database::ExecuteQuery($query, $params, "s", $error);

        if ($error != null) {
            // Handle errors
            return null;
        } else {
            $users = array();
            foreach ($result as $row) {
                $user = new UserDMO(
                    $row['Name'],
                    $row['Surname'],
                    $row['DateOfBirth'],
                    $row['Email'],
                    $row['Password'],
                    true,
                    $row['LastUpdate'],
                    $row['ID']
                );
                $users[] = $user;
            }
            return $users;
        }
    }

    
    /**
     * Get user's conversations
     * 
     * @param string UserID ID of the user
     * 
     * @return UserDMO[]|null Array of UserDMO
     */
    public static function GetConversations($UserID, &$error = null)
    {
        $query = "SELECT * FROM users
                  WHERE ID IN (SELECT DISTINCT SenderID FROM messages WHERE ReciverID = ?
                  UNION SELECT DISTINCT ReciverID FROM messages WHERE SenderID = ?)";


        $params = array($UserID, $UserID);

        $result = Database::ExecuteQuery($query, $params, "ii", $error);


        if ($error != null) {
            // Handle errors
            return null;
        } else {
            $users = array();
            foreach ($result as $row) {
            $user = new UserDMO(
                $row['Name'],
                $row['Surname'],
                $row['DateOfBirth'],
                $row['Email'],
                $row['Password'],
                true,
                $row['LastUpdate'],
                $row['ID']
            );
            $users[] = $user;
            }
            return $users;
        }
    }
    #endregion
}