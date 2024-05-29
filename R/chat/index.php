<?php
include_once $_SERVER["DOCUMENT_ROOT"] . "/inc/config.inc.php";
include_once $root . "/inc/protected.inc.php";

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


        <div class="contacts_container">
            <?php include_once "contacts.php"; ?>
        </div>
        <div class="chat_container">
            <div id="chat">


                <!-- Opposite example -->
                <!-- <div class="d-flex justify-content-between">
                    <p class="small mb-1">Timona Siera</p>
                    <p class="small mb-1 text-muted">23 Jan 5:37 pm</p>
                </div>
                <div class="d-flex flex-row justify-content-start" style="max-width: 500px;">

                    <div>
                        <p class="small p-2 ms-3 mb-3 rounded-3 bg-white">Lorem ipsum dolor
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Praesentium modi, deserunt dignissimos minima optio sed inventore a sequi nesciunt fugiat quod corrupti veritatis labore doloribus ex maiores necessitatibus vitae laborum!
                            Nesciunt, amet nulla! Fugiat iste praesentium sint, enim necessitatibus quidem explicabo incidunt illum quas iusto corrupti quisquam ipsam eaque ullam eveniet, ut voluptates quaerat dolorem magnam. Natus, nesciunt. Numquam, harum!</p>
                    </div>
                </div> -->


                <!-- Sender example -->
                <!--<div class="d-flex justify-content-between">
                    <p class="small mb-1 text-muted">23 Jan 6:10 pm</p>
                    <p class="small mb-1">Johny Bullock</p>
                </div>
                <div class="d-flex flex-row justify-content-end mb-4 pt-1">
                    <div>
                        <p class="small p-2 me-3 mb-3 text-white rounded-3 bg-primary">Dolorum quasi voluptates quas
                            amet in
                            repellendus perspiciatis fugiat</p>
                    </div>
                </div> -->

            </div>

            <div id="input">
                <input 
                    class="border-0"
                    style="outline: none; border-top-right-radius: 0px; border-bottom-right-radius: 0px;"
                    type="text"
                    id="messagetb" 
                    placeholder="Write a message" 
                    maxlength="300" 
                    data-email="<?php echo $_SESSION["user"]->getEmail() ?>" 
                    data-name="<?php echo $_SESSION["user"]->getName(); ?>" 
                    data-surname="<?php echo $_SESSION["user"]->getSurname(); ?>" 
                    data-id="<?php echo $_SESSION["user"]->getID(); ?>"
                    autofocus>

                <button id="send" onclick="sendMessage(null)" ><i class="bi bi-send"></i></button>
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
            display: flex;
        }

        .contacts_container {
            overflow: auto;
            min-width: fit-content;


        }

        .chat_container {
            width: 100%;
            display: flex;
            flex-direction: column;
        }

        .chat_container #chat {
            flex: 1;
            overflow-y: auto;
            padding: 10px;

        }

        .chat_container #input {
            display: flex;
            justify-content: space-between;
            padding: 10px;
        }

        .chat_container #input input {
            flex: 1;
            padding: 5px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .chat_container #input button {
            padding: 5px 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            background-color: #007bff;
            color: white;
        }
    </style>

    <?php include_once $root . "/components/Footer.comp.php" ?>

</body>
<!-- Default scripts -->
<?php include_once $root . "/components/Scripts.comp.php" ?>
<script src="define.js"></script>
<script src="addMessage.js"></script>
<script src="getConversations.js"></script>

</html>