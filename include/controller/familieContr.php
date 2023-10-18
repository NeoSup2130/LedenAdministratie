<?php 
require_once "include/controller/basisContr.php";
include_once "include/model/familieModel.php";

// FamilieContr heeft verantwoordelijkheid over het weergeven van de familie view en het handelen van client input.
// Rondom de volgende tabel Familie
class FamilieContr extends Controller
{
    protected function handelPOST()
    {
        if(isset($_POST['methode']))
        {
            $model = new familieModel;
            switch($_POST['methode'])
            {
                case "toevoegen":
                    $filter = new Validator();
                    $filter->AddFilter('Naam', familieModel::haalRegex('Naam'));
                    $filter->AddFilter('Postcode', familieModel::haalRegex('Postcode'));
                    $filter->AddFilter('Straat', familieModel::haalRegex('Straat'));
                    $filter->AddFilter('Huisnummer', familieModel::haalRegex('Huisnummer'));
                    $data = $filter->Validate();
                    if(!$data) break;                    
                    $adres = $data['Postcode'].', '.$data['Straat'].' '.$data['Huisnummer'];
                    if (!$model->toevoegenFamilie($data['Naam'], $adres))
                    alertQueryError();
                break;
                case "aanpassen":
                    if ($this->ValideerID([$_POST['FamilieID']]))
                    {
                        $filter = new Validator();
                        $filter->AddFilter('Naam', familieModel::haalRegex('Naam'));
                        $filter->AddFilter('Postcode', familieModel::haalRegex('Postcode'));
                        $filter->AddFilter('Straat', familieModel::haalRegex('Straat'));
                        $filter->AddFilter('Huisnummer', familieModel::haalRegex('Huisnummer'));
                        $data = $filter->Validate();
                        if(!$data) break;                    
                        $adres = $data['Postcode'].', '.$data['Straat'].' '.$data['Huisnummer'];
                        if (!$model->aanpassenFamilie($_POST['FamilieID'], $data['Naam'], $adres))
                        alertQueryError();
                    }
                break;
                case "verwijderen":
                    if ($this->ValideerID([$_POST['FamilieID']]))
                    {
                        if (!$model->verwijderFamilie($_POST['FamilieID']))
                        alertQueryError();
                    }
                break;
            }
            header('refresh:0');
        }
    }

    protected function handelGET()
    {
        if(isset($_GET['methode']))
        {
            switch($_GET['methode'])
            {
                case "lid toevoegen":
                    header('location: index.php?pagina=familie+leden&FamilieID='.$_GET['FamilieID'].'&methode=toevoegen');
                    exit;
                break;
                case "leden bekijken":
                    header('location: index.php?pagina=familie+leden&FamilieID='.$_GET['FamilieID'].'');
                    exit;
                break;
                case "aanpassen":
                    include_once "include/view/familie/familieAanpassen.php";
                break;
                case "verwijderen":
                    include_once "include/view/familie/familieVerwijderen.php";
                break;
                default:
                return false;
                break;
            }
            return true;
        } 
        return false;
    }

    protected function toonAlles()
    {
        include_once "include/view/familie/familieOverzicht.php";
    }
}
?>