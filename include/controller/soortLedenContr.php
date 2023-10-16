<?php 
require_once "include/basis.php";
include_once "include/model/soortModel.php";

class SoortLedenContr extends Database
{
    protected function handelPOST()
    {
        if(isset($_POST['methode']))
        {
            $model = new SoortModel;
            switch($_POST['methode'])
            {
                case "toevoegen":
                    if (!$model->toevoegenSoort($_POST['SoortNaam']))
                    $this->alertQueryError();
                break;
                case "aanpassen":
                    if (!$model->aanpassenSoort($_POST['SoortID'], $_POST['SoortNaam']))
                    $this->alertQueryError();
                break;
                case "verwijderen":
                    if (!$model->verwijderSoort($_POST['SoortID']))
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
                    include_once "include/view/contributie/soortAanpassen.php";
                break;
                case "verwijderen":
                    include_once "include/view/contributie/soortVerwijderen.php";
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
        include_once "include/view/contributie/soortOverzicht.php";
    }
}
?>