<?php 
require_once "include/controller/basisContr.php";
include_once "include/model/soortModel.php";

// SoortLedenContr heeft verantwoordelijkheid over het weergeven van de view en het handelen van client input.
// Rondom het tabel Soort Leden
class SoortLedenContr extends Controller
{
    protected function handelPOST()
    {
        if(isset($_POST['methode']))
        {
            $model = new SoortModel;
            switch($_POST['methode'])
            {
                case "toevoegen":
                    $filter = new Validator();
                    $filter->AddFilter('SoortNaam', SoortModel::haalRegex('Soort'));
                    $data = $filter->Validate();
                    if(!$data) break;

                    if (!$model->toevoegenSoort($data['SoortNaam']))
                    alertQueryError();
                break;
                case "aanpassen":
                    if ($this->ValideerID([$_POST['SoortID']]))
                    {
                        $filter = new Validator();
                        $filter->AddFilter('SoortNaam', SoortModel::haalRegex('Soort'));
                        $data = $filter->Validate();
                        if(!$data) break;

                        if (!$model->aanpassenSoort($_POST['SoortID'], $_POST['SoortNaam']))
                            alertQueryError();
                    }
                    
                break;
                case "verwijderen":
                    if ($this->ValideerID([$_POST['SoortID']]))
                    {
                        if (!$model->verwijderSoort($_POST['SoortID']))
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

    protected function toonAlles()
    {
        include_once "include/view/contributie/soortOverzicht.php";
    }
}
?>