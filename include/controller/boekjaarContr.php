<?php 
require_once "include/basis.php";
include_once "include/model/boekjaarModel.php";

class BoekjaarContr extends Database
{
    protected function handelPOST()
    {
        if(isset($_POST['methode']))
        {
            $model = new BoekjaarModel;
            switch($_POST['methode'])
            {
                case "toevoegen":
                    $jaar = htmlspecialchars($_POST['BoekJaar']);
                    $bedrag = str_replace(',','.', htmlspecialchars($_POST['BasisBedrag']));
                    if (!$model->toevoegenBoekjaar($jaar, $bedrag))
                    $this->alertQueryError();
                break;
                case "aanpassen":
                    if (!$model->aanpassenBoekjaar($_POST['BoekjaarID'], $_POST['Jaar']))
                    $this->alertQueryError();
                break;
                case "verwijderen":
                    if (!$model->verwijderBoekjaar($_POST['BoekjaarID']))
                    $this->alertQueryError();
                break;
            }
            header('refresh:0');
        }
    }

    public function handelGET()
    {
        if(isset($_GET['methode']))
        {
            switch($_GET['methode'])
            {
                case "aanpassen":
                    include_once "include/view/contributie/boekjaarAanpassen.php";
                break;
                case "verwijderen":
                    include_once "include/view/contributie/boekjaarVerwijderen.php";
                break;
            }
            return true;
        } 
        return false;
    }

    public function invoke()
    {
        if(isset($_SERVER['REQUEST_METHOD']))
        {
            switch($_SERVER['REQUEST_METHOD'])
            {
                case 'POST': 
                    $this->handelPOST();
                    break;
                    case 'GET':
                        if (!$this->handelGET())
                            $this->toonAlles(); 
                        break;
                default:
                var_dump($_SERVER['REQUEST_METHOD']);
                    break;
            }
        } 
    }

    protected function toonAlles()
    {
        include_once "include/view/contributie/boekjaarOverzicht.php";
    }
}
?>