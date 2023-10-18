<?php 
    session_start();

    include_once "include/html_class.php";
    include_once "include/controller/userContr.php";
    
    $userController = new AdminUserContr();
    // Als gebruiker niet ingelogd/bekend is bij onze sessie. Weergeef login pagina.
    if (!isset($_SESSION['GebruikerID'])) 
    {
        $userController->ToonLogin();
    } 
    else 
    {
        generateHeader("Leden overzicht de Cuijt", function () {linkCSS("css/main.css");});
        
        if (!isset($_GET['pagina']))
        {
            $_GET['pagina'] = "overzicht";
        }
        // Weergeef de correcte pagina gebasseerd op de meegekregen URL 
        // Voorbeeld www.home.nl?pagina=hello+world -> laat pagina start zien.
        switch(urldecode($_GET['pagina']))
        {
            case "overzicht":
                include_once "include/model/overzichtModel.php";
                include_once "include/view/contributieOverzicht.php";
                break;
                case "familie":
                include_once "include/controller/familieContr.php";
                $familieController = new FamilieContr();
                $familieController->invoke();
                break;
                case "familie leden":
                include_once "include/controller/ledenContr.php";
                $ledenController = new LedenContr();
                $ledenController->invoke();
                break;
                case "contributie": 
                include_once "include/controller/boekjaarContr.php";
                $boekjaarController = new BoekjaarContr();
                $boekjaarController->invoke();
                break;
                case "soort leden":
                include_once "include/controller/soortLedenContr.php";
                $soortController = new SoortLedenContr();
                $soortController->invoke();
                break;
                case "staffels":
                include_once "include/controller/staffelsContr.php";
                $staffelsController = new StaffelsContr();
                $staffelsController->invoke();
                break;
                default:

                echo "Pagina ".$_GET['pagina']." bestaat niet, er is iets misgegaan!";
                break;
        }
    }
    generateFooter();
?>