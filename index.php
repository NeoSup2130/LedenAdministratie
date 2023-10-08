<?php 
    session_start();

    if (!isset($_SESSION['gebruikerID'])) 
    {
        include_once "include/view/login.php";
    }
    ?>

    <footer>
    <?php //Footer 
    echo '@ '.date_create()->format('Y').' Copyright Sportclub de Cuijt';
    ?>
    </footer>
</body>
</html>