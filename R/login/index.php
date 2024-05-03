<?php
include_once $_SERVER["DOCUMENT_ROOT"] . "/inc/config.inc.php";
$pageTitle = "Talkie • Login";
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
            <h2 class="text-center mb-4">Login</h2>

            <!-- FORM -->
            <form id="form" method="post" name='LoginForm' action="/ws/v1/authentication/login.php" onsubmit="return controllaForm()">

                <!-- Email -->
                <div class="form-group mt-3">
                    <label for="formInput_email">Email</label>
                    <input type="email" class="form-control" name='Email' isValid="false" placeholder="example@domain.com" required autofocus>
                </div>

                <!-- Password -->
                <div class="form-group mt-3">
                    <label for="formInput_password">Password</label>
                    <input type="password" class="form-control" name='Password' isValid="false" placeholder="•••••••••" required>
                </div>

                <!-- Internal attribute -->
                <div class="form-group mt-3" style="display: none;">
                    <label for="formInput_password">Internal</label>
                    <input type="checkbox" class="form-control" name='Internal' isValid="false" placeholder="Internal" checked>
                </div>



                <!-- Submit -->
                <button type="submit" class="btn btn-primary mx-auto d-block mt-3 px-5">Login</button>

                
                <p class="text-center m-0 mt-3">You don't have an account? <a href="<?php echo $BaseUrl . "/register"; ?>">Register now!</a></p>
                <p class="text-center m-0 mt-3"><a href="<?php echo $BaseUrl . "/login/forgot/"; ?>">Forgotten password</a></p>
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