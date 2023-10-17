<?php 
require_once "include/controller/basisContr.php";
include_once "include/model/boekjaarModel.php";

// BoekjaarContr heeft verantwoordelijkheid over het weergeven van het boekjaar view en het handelen van client input.
// Rondom de volgende tabel Boekjaar
class BoekjaarContr extends Controller
{
    protected function handelPOST()
    {
        if(isset($_POST['methode']))
        {
            $model = new BoekjaarModel;
            switch($_POST['methode'])
            {
                case "toevoegen":
                    $filter = new Validator();
                    $filter->AddFilter('BoekJaar', BoekjaarModel::haalRegex('Jaar'));
                    $filter->AddFilter('BasisBedrag', BoekjaarModel::haalRegex('BasisBedrag'));
                    $data = $filter->Validate();
                    if(!$data) break;
                    $bedrag = str_replace(',','.', htmlspecialchars($data['BasisBedrag']));
                    if (!$model->toevoegenBoekjaar($data['BoekJaar'], $bedrag))
                    alertQueryError();
                break;
                case "aanpassen":
                    if ($this->ValideerID([$_POST['BoekjaarID']]))
                    {
                        $filter = new Validator();
                        $filter->AddFilter('BoekJaar', BoekjaarModel::haalRegex('Jaar'));
                        $data = $filter->Validate();
                        if(!$data) break;
                        if (!$model->aanpassenBoekjaar($_POST['BoekjaarID'], $data['Jaar']))
                            alertQueryError();
                    }
                break;
                case "verwijderen":
                    if ($this->ValideerID([$_POST['BoekjaarID']]))
                    {
                        if (!$model->verwijderBoekjaar($_POST['BoekjaarID']))
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

    protected function toonAlles()
    {
        include_once "include/view/contributie/boekjaarOverzicht.php";
    }
}
?>