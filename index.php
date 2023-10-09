<?php 
    session_start();

    if (!isset($_SESSION['GebruikerID'])) 
    {
        include_once "include/view/login.php";
    } 
    else 
    {
        echo "welkom gebruiker ".$_SESSION['GebruikerNaam']."!";
        // session_unset();
        // session_destroy();
    }
    ?>

    <footer>
    <?php //Footer 
    echo '@ '.date_create()->format('Y').' Copyright Sportclub de Cuijt';
    ?>
    </footer>
</body>
</html>