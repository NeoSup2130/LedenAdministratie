<?php 
    session_start();

    include_once "include/html_class.php";
    include_once "include/controller/userContr.php";
    
    $userController = new AdminUserContr();

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

        switch($_GET['pagina'])
        {
            case "overzicht":
                include_once "include/model/overzichtModel.php";
                include_once "include/view/contributieOverzicht.php";
                break;
                case "families":
                include_once "include/controller/familieContr.php";
                $familieController = new FamilieContr();
                $familieController->invoke();
                break;
                case "leden":
                include_once "include/controller/ledenContr.php";
                $ledenController = new LedenContr();
                $ledenController->invoke();
                break;
                default:

                echo "Pagina ".$_GET['pagina']." bestaat niet, er is iets misgegaan!";
                break;
        }
    }
    generateFooter();
?>