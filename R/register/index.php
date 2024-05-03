<?php
include_once $_SERVER["DOCUMENT_ROOT"] . "/inc/config.inc.php";
$pageTitle = "Talkie • Register";
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


        <div class="col-10 col-md-6 mx-auto my-5 py-3 rounded-3 px-5" style="box-shadow: var(--shadow-basic); background-color: rgba(0, 0, 0, 0.05); max-width: 470px;">

            <!-- TITOLO -->
            <h2 class="text-center mb-4">Register</h2>


            <!-- FORM -->
            <form name='RegistrationForm' action="/ws/v1/authentication/register.php" method="POST">

                <!-- GRUPPO -->
                <div class="row">
                    <!-- Nome -->
                    <div class="form-group col-md-6 mt-3">
                        <label for='Name' class="required">Name</label>
                        <input type="text" class="form-control" name='Name' placeholder="John" autofocus>
                    </div>
                    <!-- Cognome -->
                    <div class="form-group col-md-6 mt-3">
                        <label for='Surname' class="required">Surname</label>
                        <input type="text" class="form-control" name='Surname' placeholder='Doe'>
                    </div>
                </div>

                <!-- Data di nascita -->
                <div class="form-group mt-3">
                    <label for='DataOfBirth' class="required">Date of birth</label>
                    <input type="date" class="form-control" name='DateOfBirth'>
                </div>

                <!-- Email -->
                <div class="form-group mt-3">
                    <label for='Email' class="required">Email</label>
                    <input type="email" class="form-control" name='Email' placeholder="example@domain.com">
                </div>

                <!-- GRUPPO -->
                <div class="row">
                    <!-- Password -->
                    <div class="form-group col-md-6 mt-3">
                        <label for='Password' class="required">Password</label>
                        <input type="password" class="form-control" name='Password' placeholder="••••••••••">
                    </div>

                    <!-- Conferma password -->
                    <div class="form-group col-md-6 mt-3">
                        <label for='PasswordConfirm' class="required" required>Password Check</label>
                        <input type="password" class="form-control" name='PasswordConfirm' placeholder="">
                    </div>
                </div>

                <div class="form-group mt-3">
                    <input type="checkbox" class="form-check-input" name="ToSacknowledge" required>
                    <label for="ToSacknowledge">I've read the non existing <a href="#">Terms of Service</a></label>
                </div>

                
                <!-- Internal attribute -->
                <div class="form-group mt-3" style="display: none;">
                    <label for="Internal">Internal</label>
                    <input type="checkbox" class="form-control" name='Internal' isValid="false" placeholder="Internal" checked>
                </div>



                <!-- Submit -->
                <button type="submit" class="btn btn-primary mx-auto d-block mt-3 px-5">Register now</button>
                <p class="text-center m-0 mt-3">Already own an account? <a href="<?php echo $BaseUrl . "/login"; ?>">Login</a></p>
            </form>


        </div>

        <!-- End page content -->
    </div>

    <!-- Default footer -->
    <?php include_once $root . "/components/Footer.comp.php" ?>

</body>
<!-- Default scripts -->
<?php include_once $root . "/components/Scripts.comp.php" ?>
<script src="index.js"></script>
</html>