<?php

/**
 * Data Model Object for User
 */
class UserDMO
{

    #region Properties
    private $ID;            // ID of the user
    private $Name;          // Name of the user
    private $Surname;       // Surname of the user
    private $Birthday;      // Birthday of the user
    private $Email;         // Email of the user
    private $Password;      // Password of the user
    private $LastUpdate;    // Last update of the messages
    #endregion

    #region Constructor

    /**
     * Constructor for the UserDMO
     * 
     * @param string $Name Name of the user
     * @param string $Surname Surname of the user
     * @param string $Birthday Birthday of the user
     * @param string $Email Email of the user
     * @param string $Password Password of the user
     * @param int $ID ID of the user
     * 
     * @return UserDMO New instance of UserDMO
     */
    public function __construct($Name, $Surname, $Birthday, $Email, $Password, $PasswordHashed = false, $LastUpdate, $ID = null) {
        $this->setName($Name);
        $this->setSurname($Surname);
        $this->setBirthday($Birthday);
        $this->setEmail($Email);
        $this->setPassword($Password, $PasswordHashed);
        $this->setLastUpdate($LastUpdate);
        $this->setID($ID);
    }

    #endregion

    #region Getters


    /**
     * Get the ID of the user
     * 
     * @return int ID of the user
     */
    public function getID()
    {
        return $this->ID;
    }

    /**
     * Get the name of the user
     * 
     * @return string Name of the user
     */
    public function getName()
    {
        return $this->Name;
    }

    /**
     * Get the surname of the user
     * 
     * @return string Surname of the user
     */
    public function getSurname()
    {
        return $this->Surname;
    }

    /**
     * Get the birthday of the user
     * 
     * @return string Birthday of the user
     */
    public function getBirthday()
    {
        return $this->Birthday;
    }

    /**
     * Get the email of the user
     * 
     * @return string Email of the user
     */
    public function getEmail()
    {
        return $this->Email;
    }

    /**
     * Get the password of the user
     * 
     * @return string Password of the user
     */
    public function getPassword()
    {
        return $this->Password;
    }

    /**
     * Get the last update of the user
     * 
     * @return string Last update of the user
     */
    public function getLastUpdate()
    {
        return $this->LastUpdate;
    }

    #endregion

    #region Setters

    /**
     * Set the ID of the user
     * 
     * @param int $ID ID of the user
     * @return void
     */
    public function setID($ID)
    {
        $this->ID = $ID;
    }

    /**
     * Set the name of the user
     * 
     * @param string $Name Name of the user
     * @return void
     */
    public function setName($Name)
    {
        $this->Name = ucfirst($Name);
    }

    /**
     * Set the surname of the user
     * 
     * @param string $Surname Surname of the user
     * @return void
     */
    public function setSurname($Surname)
    {
        $this->Surname = ucfirst($Surname);
    }

    /**
     * Set the birthday of the user
     * 
     * @param string $Birthday Birthday of the user
     * @return void
     */
    public function setBirthday($Birthday)
    {
        $this->Birthday = $Birthday;
    }

    /**
     * Set the email of the user
     * 
     * @param string $Email Email of the user
     * @return void
     */
    public function setEmail($Email)
    {
        $this->Email = $Email;
    }

    /**
     * Set the password of the user
     * 
     * @param string $Password Password of the user
     * @return void
     */
    public function setPassword($Password, $hashed = false)
    {

        if ($hashed)
            $this->Password = $Password;
        else
            $this->Password = UserDMO::hashPassword($Password);
    }

    /**
     * Set the last update of the user
     * 
     * @param string $LastUpdate Last update of the user
     * @return void
     */
    public function setLastUpdate($LastUpdate)
    {
        $this->LastUpdate = $LastUpdate;
    }

    #endregion

    #region Methods

    /** Hash the password
     * 
     * @param string $password Password to hash
     * @return string Hashed password using sha256 and md5
     */
    public static function hashPassword($password) {
        return hash('sha256', $password) . hash('md5', $password);
    }

    public function CheckPassword($password) {

        // echo UserDMO::hashPassword($password);
        return $this->Password == UserDMO::hashPassword($password);
    }

    #endregion

}