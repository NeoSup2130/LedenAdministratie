<?php 
require_once "include/controller/basisContr.php";
include_once "include/model/staffelsModel.php";
include_once "include/model/boekjaarModel.php";
include_once "include/model/soortModel.php";

// StaffelsContr heeft verantwoordelijkheid over het weergeven van de view en het handelen van client input.
// Rondom de volgende tabel Contributie
class StaffelsContr extends Controller
{
    protected function isEmptySoortID()
    {
        $soortModel = new SoortModel;
        return empty($soortModel->haalSoort($_POST['SoortID'])->fetch());
    }

    protected function isEmptyBoekID()
    {
        $boekjaarModel = new BoekjaarModel;
        return empty($boekjaarModel->haalBoekjaar($_POST['BoekID'])->fetch());
    }

    protected function controleerToevoeging()  
    {
        $staffelModel = new StaffelsModel;
        try {
            if($this->isEmptySoortID() || $this->isEmptyBoekID())
            {
                throw new Exception ("Meegegeven informatie bestaat niet.");
            }
            if(empty($staffelModel->haalBoekJaarStaffel($_POST['SoortID'], $_POST['BoekID'])->fetch())) 
            {
                return true;
            }
            else 
            {   
                $string = 'Uw toevoeging met BoekID='.$_POST['BoekID'].', SoortID='.$_POST['SoortID'].', Leeftijd='.$_POST['Leeftijd'].' bestaat al!';
                throw new Exception ($string);
            } 
        } catch (Exception $e) {
            $_SESSION['PDO_ERROR'] = $e;
            return false;
        }
    }

    protected function handelPOST()
    {
        if(isset($_POST['methode']))
        {
            $staffelModel = new StaffelsModel;
            switch($_POST['methode'])
            {
                case "toevoegen":
                    if ($this->ValideerID([$_POST['BoekID'], $_POST['SoortID']]))
                    {
                        $filter = new Validator();
                        $filter->AddFilter('Leeftijd', StaffelsModel::haalRegex('Leeftijd'));
                        $filter->AddFilter('Korting', StaffelsModel::haalRegex('Korting'));
                        $filter->AddFilter('Bedrag', BoekjaarModel::haalRegex('Bedrag'));
                        $data = $filter->Validate();
                        if(!$data) break;
                        if ($this->controleerToevoeging()) 
                        {
                            if (!$staffelModel->toevoegenStaffel($_POST['BoekID'], $_POST['SoortID'], $data['Leeftijd'], $data['Korting'], $data['BasisBedrag']))
                            alertQueryError();
                        } 
                        else alertQueryError();
                    }
                break;
                case "aanpassen":
                    if ($this->ValideerID([$_POST['ID'], $_POST['BoekID'], $_POST['SoortID']]))
                    {
                        if($this->isEmptySoortID() || $this->isEmptyBoekID()) break;
                        $filter = new Validator();
                        $filter->AddFilter('Leeftijd', StaffelsModel::haalRegex('Leeftijd'));
                        $filter->AddFilter('Korting', StaffelsModel::haalRegex('Korting'));
                        $filter->AddFilter('Bedrag', BoekjaarModel::haalRegex('BasisBedrag'));
                        $data = $filter->Validate();
                        if(!$data) break;
                        if (!$staffelModel->aanpassenStaffel($_POST['ID'], $_POST['BoekID'], $_POST['SoortID'], $data['Leeftijd'], $data['Korting'], $data['Bedrag']))
                        alertQueryError();
                    }
                break;
                case "verwijderen":
                    if ($this->ValideerID([$_POST['StaffelID']]))
                    {
                        if (!$staffelModel->verwijderStaffel($_POST['StaffelID']))
                        alertQueryError();
                    }
                break;
            }
            header('refresh:0');
        }
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

    protected function toonAlles()
    {
        include_once "include/model/soortModel.php";
        include_once "include/model/boekjaarModel.php";
        include_once "include/view/contributie/staffelOverzicht.php";
    }
}
?>