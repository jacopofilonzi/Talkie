<?php

    $nav_showLogout = false;

    if (isset($_SESSION["user"]))
        $nav_showLogout = true;

?>

<header>
    <nav class="navbar navbar-dark">
        <div class="container-fluid">
            <span class="navbar-brand mb-0 h1 brand-font">Talkie</span>
            <div class="d-lg-flex col-lg-3 justify-content-lg-end">
                <a  class="text-white <?php if (!$nav_showLogout) echo "hidden";?>"
                    href="/ws/v1/authentication/logout.php"
                    data-bs-toggle="tooltip"
                    data-bs-title="Logout">
                        <i class="bi bi-box-arrow-right"></i>
                </a>
            </div>
        </div>

    </nav>
</header>