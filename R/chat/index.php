<?php
    include_once $_SERVER["DOCUMENT_ROOT"] . "/inc/config.inc.php";
    $pageTitle = "Chat";
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Default meta tags -->
    <?php include_once $root . "/components/Head.comp.php" ?>
</head>
<body>
    <!-- Default header -->
    <?php include_once $root . "/components/Header.comp.php" ?>

    <div class="content">
        <!-- Content goes here -->
    

        <div id="app">
            <div class="ChatList">
                <p>ciao</p>

            </div>
            <div class ="Chat">
                    <p>asd</p>
            </div>
        </div>


        <!-- End page content -->
    </div>

    <style>

        body {
            max-height: 100vh;
            overflow-y: auto;
            
        }

        .content {
            overflow: auto;
        }

        .app {
            display: flex;
            /* flex-direction: row; */
        }

        .Chat {
            background-color: red;
        }

        .chatList {
            overflow: auto;
            
        }

    </style>

    <?php include_once $root . "/components/Footer.comp.php" ?>

</body>
<!-- Default scripts -->
<?php include_once $root . "/components/Scripts.comp.php" ?>
</html>