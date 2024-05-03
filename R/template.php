<?php
    include_once $_SERVER["DOCUMENT_ROOT"] . "/inc/config.inc.php";
    $pageTitle = "Template";
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

    <div class="content container">
        <!-- Content goes here -->
        <h1>Benvenuto</h1>
        <p>Questa è una pagina di template per il layout del sito "Giorno Libero"</p>

        <hr>

        <h2>Nome Sezione</h2>
        <p>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi hendrerit magna in porttitor mattis. Nulla ultricies metus id leo ornare porta. Proin finibus dolor odio, vel blandit velit vestibulum vel. Donec ex felis, mattis ut massa a, pretium lobortis risus. Etiam gravida augue in finibus efficitur. Aliquam erat volutpat. Curabitur cursus eleifend metus. Praesent a orci risus. Phasellus enim nibh, ullamcorper imperdiet gravida vel, luctus at justo. Nunc faucibus, lorem quis laoreet suscipit, nisi neque lacinia risus, sit amet condimentum nunc orci nec nulla. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Etiam elit lacus, porta a dictum ac, porttitor in lacus. Nam rhoncus dapibus tellus et placerat. Phasellus hendrerit sed tortor nec dapibus. Sed ultrices mi a consequat posuere. Suspendisse rutrum est nec magna aliquet vehicula. 
        </p>
        
        <p>
            Testo <a href="#">con link</a>.
        </p>

        <h2>Sottosezione</h2>

        <p>
            Inserisci il tuo nome.
            <br>
            <input type="text" placeholder="Nome">
        </p>

        <p>
            Scegli un giorno della settimana.
            <br>
            <select>
                <option selected>Lunedì</option>
                <option>Martedì</option>
                <option>Mercoledì</option>
                <option>Giovedì</option>
                <option>Venerdì</option>
                <option>Sabato</option>
                <option>Domenica</option>
            </select>
        </p>
        
        <p>
            Premi qui per confermare.
            <br>
            <button>Conferma</button>
        </p>

        <!-- End page content -->
    </div>
    
    <!-- Default footer -->
    <?php include_once $root . "/components/Footer.comp.php" ?>

</body>
<!-- Default scripts -->
<?php include_once $root . "/components/Scripts.comp.php" ?>
</html>