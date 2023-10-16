<?php 
require_once "include/basis.php";
include_once "include/model/staffelsModel.php";

class StaffelsContr extends Database
{
    protected function controleerToevoeging()  
    {
        $staffelModel = new StaffelsModel;
        try {
            if ($stmt = $staffelModel->haalBoekJaarStaffel($_POST['BoekID'], $_POST['SoortID']))
            {
                $string = 'Uw toevoeging met BoekID='.$_POST['BoekID'].', SoortID='.$_POST['SoortID'].', Leeftijd='.$_POST['Leeftijd'].' bestaat al!';
                throw new Exception ($string);
            } 
            else return true;
        } catch (Exception $e) {
            $_SESSION['PDO_ERROR'] = $e;
            return false;
        }
        return true;
    }

    protected function handelPOST()
    {
        if(isset($_POST['methode']))
        {
            $staffelModel = new StaffelsModel;
            switch($_POST['methode'])
            {
                case "toevoegen":
                    if ($this->controleerToevoeging()) 
                    {
                        if (!$staffelModel->toevoegenStaffel($_POST['BoekID'], $_POST['SoortID'], $_POST['Leeftijd'], $_POST['Korting'], $_POST['BasisBedrag']))
                        $this->alertQueryError();
                    } 
                    else $this->alertQueryError();
                break;
                case "aanpassen":
                    if (!$staffelModel->aanpassenStaffel($_POST['ID'], $_POST['BoekID'], $_POST['SoortID'], $_POST['Leeftijd'], $_POST['Korting'], $_POST['Bedrag']))
                    $this->alertQueryError();
                break;
                case "verwijderen":
                    if (!$staffelModel->verwijderStaffel($_POST['StaffelID']))
                    $this->alertQueryError();
                break;
            }
            header('refresh:0');
        }
        else echo "holdup";
    }

    public function handelGET()
    {
        if(isset($_GET['methode']))
        {
            include_once "include/model/soortModel.php";
            include_once "include/model/boekjaarModel.php";

            switch($_GET['methode'])
            {
                case "aanpassen":
                    include_once "include/view/contributie/staffelAanpassen.php";
                break;
                case "verwijderen":
                    include_once "include/view/contributie/staffelVerwijderen.php";
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
        include_once "include/model/soortModel.php";
        include_once "include/model/boekjaarModel.php";
        include_once "include/view/contributie/staffelOverzicht.php";
    }
}
?>