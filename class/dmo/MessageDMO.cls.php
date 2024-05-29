<?php

/**
 * Data Model Object for Message
 */
class MessageDMO {

    #region Properties
    private $ID;            // ID of the message
    private $SenderID;      // ID of the sender
    private $ReceiverID;    // ID of the receiver
    private $Content;       // Content of the message
    private $Date;          // Date of the message
    #endregion

    #region Constructor

    /**
     * Constructor for the MessageDMO
     * 
     * @param int $SenderID ID of the sender
     * @param int $ReceiverID ID of the receiver
     * @param string $Content Content of the message
     * @param string $Date Date of the message
     * @param int $ID ID of the message
     * 
     * @return MessageDMO New instance of MessageDMO
     */
    public function __construct($SenderID, $ReceiverID, $Content, $Date, $ID = null) {
        $this->setSenderID($SenderID);
        $this->setReceiverID($ReceiverID);
        $this->setContent($Content);
        $this->setDate($Date);
        $this->setID($ID);
    }

    #endregion

    #region Getters

    /**
     * Get the ID of the message
     * 
     * @return int ID of the message
     */
    public function getID()
    {
        return $this->ID;
    }

    /**
     * Get the ID of the sender
     * 
     * @return int ID of the sender
     */
    public function getSenderID()
    {
        return $this->SenderID;
    }

    /**
     * Get the ID of the receiver
     * 
     * @return int ID of the receiver
     */
    public function getReceiverID()
    {
        return $this->ReceiverID;
    }

    /**
     * Get the content of the message
     * 
     * @return string Content of the message
     */
    public function getContent()
    {
        return $this->Content;
    }

    /**
     * Get the date of the message
     * 
     * @return string Date of the message
     */
    public function getDate()
    {
        return $this->Date;
    }

    #endregion

    #region Setters

    /**
     * Set the ID of the message
     * 
     * @param int $ID ID of the message
     */
    public function setID($ID)
    {
        $this->ID = $ID;
    }

    /**
     * Set the ID of the sender
     * 
     * @param int $SenderID ID of the sender
     */
    public function setSenderID($SenderID)
    {
        $this->SenderID = $SenderID;
    }

    /**
     * Set the ID of the receiver
     * 
     * @param int $ReceiverID ID of the receiver
     */
    public function setReceiverID($ReceiverID)
    {
        $this->ReceiverID = $ReceiverID;
    }

    /**
     * Set the content of the message
     * 
     * @param string $Content Content of the message
     */
    public function setContent($Content)
    {
        $this->Content = $Content;
    }

    /**
     * Set the date of the message
     * 
     * @param string $Date Date of the message
     */
    public function setDate($Date)
    {
        $this->Date = $Date;
    }

    #endregion

    #region Methods

    #endregion


}