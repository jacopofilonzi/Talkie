<?php

class UserDMO
{
    // #region Properties
    private $ID;
    private $Name;
    private $Surname;
    private $Birthday;
    private $Email;
    private $Password;
    #endregion

    #region Constructor
    public function __construct($Name, $Surname, $Birthday, $Email, $Password, $ID = null)
    {
        $this->setName($Name);
        $this->setSurname($Surname);
        $this->setBirthday($Birthday);
        $this->setEmail($Email);
        $this->setPassword($Password);
        $this->setID($ID);
    }
    #endregion

    #region Getters

    public function getID()
    {
        return $this->ID;
    }

    public function getName()
    {
        return $this->Name;
    }

    public function getSurname()
    {
        return $this->Surname;
    }

    public function getBirthday()
    {
        return $this->Birthday;
    }

    public function getEmail()
    {
        return $this->Email;
    }

    public function getPassword()
    {
        return $this->Password;
    }

    #endregion

    #region Setters

    public function setID($ID)
    {
        $this->ID = $ID;
    }

    public function setName($Name)
    {
        $this->Name = ucfirst($Name);
    }

    public function setSurname($Surname)
    {
        $this->Surname = ucfirst($Surname);
    }

    public function setBirthday($Birthday)
    {
        $this->Birthday = $Birthday;
    }

    public function setEmail($Email)
    {
        $this->Email = $Email;
    }

    public function setPassword($Password)
    {
        $this->Password = UserDMO::hashPassword($Password);
    }

    #endregion

    #region Methods

    public static function hashPassword($password) {
        return hash('sha256', $password) . hash('md5', $password);
    }

    #endregion

}