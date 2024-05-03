<?php 

    include_once $_SERVER['DOCUMENT_ROOT'] . "/inc/database.inc.php";
    include_once $_SERVER['DOCUMENT_ROOT'] . "/class/dmo/user.cls.php";


    class UserBL
    {
        /**
         * Register a new user
         * 
         * @param UserDMO $user
         *
         * @return int 0 = generic error, 1 <= = success (user id), -1 = duplicate entry
         */
        public static function Register(&$user)
        {
            
            $query = "INSERT INTO users (Name, Surname, DateOfBirth, Email, Password) VALUES (?, ?, ?, ?, ?)";

            $params = array(
                $user->getName(),
                $user->getSurname(),
                $user->getBirthday(),
                $user->getEmail(),
                $user->getPassword()
            );

            $error = null;
            $result = Database::ExecuteQuery($query, $params, "sssss", $error);
            
            if ($error != null || $result <= 0) {
                // Handle errors
                if (strpos($error, "Duplicate entry") === 0) {
                    return -1; //Duplicate entry
                } else
                    return 0; //Generic error
            } else {
                $user->setID($result);
                return $result;
            }
        }

        /**
         * Authenticate a user
         * 
         * @param string $email
         * @param string $password
         * 
         * @return UserDMO|null UserDMO if authenticated, null otherwise
         */
        public static function Authenticate($email, $password)
        {
            $query = "SELECT * FROM users WHERE Email = ? AND Password = ?";

            $params = array(
                $email,
                UserDMO::hashPassword($password)
            );

            $error = null;
            $result = Database::ExecuteQuery($query, $params, "ss", $error);

            if ($error != null) {
                // Handle errors
                return null;
            } else {
                if (count($result) == 1) {

                    $user = new UserDMO(
                        $result[0]['Name'],
                        $result[0]['Surname'],
                        $result[0]['DateOfBirth'],
                        $result[0]['Email'],
                        $result[0]['Password'],
                        $result[0]['ID']
                    );
                    return $user;
                } else {
                    return null;
                }
            }
        }
    }