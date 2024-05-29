<?php

    include_once $_SERVER["DOCUMENT_ROOT"] . "/class/dmo/UserDMO.cls.php";

    session_start();

    $root = $_SERVER['DOCUMENT_ROOT'];
    $BaseUrl = "/R";
    $AppName = "Talkie";
    $AppIcon = "https://cdn.filonzi.it/img/logo.png";

    $AllowExternal = true;


    $currentUser = null;


    if (isset($_SESSION['user'])) {
        $currentUser = $_SESSION['user'];
    }


    #region Utility functions
    /**
     * Redirects to the given url
     * 
     * @param $url string url to redirect to
     */
    function redirect($URL){
        global $BaseUrl;
        header("Location: $BaseUrl$URL");
    }

    #endregion