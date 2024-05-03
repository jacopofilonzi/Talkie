<!--- #region Page vanity --->

<title>
    <?php // Define page title
        
        if (isset($pageTitle))
            echo $pageTitle;
        
        elseif (isset($AppName))
            echo $AppName;
        
        else
            echo "Talkie";
        
    ?>
</title>

<link rel="icon" 
      type="image/png" 
      href="<?php //Define page favicon

            if (isset($AppIcon))
                echo $AppIcon;

            else
                echo "https://cdn.filonzi.it/img/logo.png";

            ?>">

<!--- #endregion --->

<!--- #region Styles --->

    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Custom -->
    <link rel="stylesheet" href="/styles/Main.css">


<!--- #endregion --->