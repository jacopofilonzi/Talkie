<?php
    include_once "../inc/config.inc.php";
    
    if (isset($_SESSION["user"]))
        redirect("/chat");
    else
        redirect("/login");
