<?php 
require_once "include/controller/basisContr.php";
include_once "include/model/ledenModel.php";
include_once "include/model/contributieModel.php";

// LedenContr heeft verantwoordelijkheid over het weergeven van de familie leden view en het handelen van client input.
// Rondom de volgende tabel Familie leden
class LedenContr extends Controller
{
    protected function bepaalSoortLid($geboorteJaar)
    {
        $soortModel = new ContributieModel();
        $leeftijd = intval(date("Y")) - $geboorteJaar;
        $query = $soortModel->haalContributieJaar()->fetchAll();
        try 
        {
            foreach($query as &$row)
            {
                if ($leeftijd <= $row['Leeftijd'])
                {
                    return $row['SoortID'];
                }
            }
            throw new Exception('Soort kan niet bepaald worden. Leeftijd klopt niet "'.$leeftijd.'" !');
        }
        catch(Exception $e)
        {
            echo($e->getMessage());
        }
        return 0;
    }

    protected function handelPOST()
    {
        if(isset($_POST['methode']))
        {
            $model = new ledenModel;
            switch($_POST['methode'])
            {
                case "toevoegen":
                    if ($this->ValideerID([$_POST['FamilieID']]))
                    {
                        $filter = new Validator();
                        $filter->AddFilter('Naam', ledenModel::haalRegex('Naam'));
                        $filter->AddFilter('GeboorteDatum', ledenModel::haalRegex('GeboorteDatum'));
                        $data = $filter->Validate();
                        if(!$data) break;
                        // geboortedatum komt binnen als 01/01/2001
                        $geboortedatum = explode('/', $data['GeboorteDatum']);
                        // geboortedatum[2] is jaar
                        $soortID = $this->bepaalSoortLid($geboortedatum[2]);
                        $geboortedatum = $geboortedatum[2].'-'.$geboortedatum[1].'-'.$geboortedatum[0];

                        if (!$model->toevoegenLid($_POST['FamilieID'], $data['Naam'], $soortID, $geboortedatum))
                            alertQueryError();
                    }
                break;
                case "aanpassen":
                    if ($this->ValideerID([$_POST['LidID'], $_POST['FamilieID']]))
                    {
                        $filter = new Validator();
                        $filter->AddFilter('Naam', ledenModel::haalRegex('Naam'));
                        $filter->AddFilter('GeboorteDatum', ledenModel::haalRegex('GeboorteDatum'));
                        $data = $filter->Validate();
                        if(!$data) break;
                        // geboortedatum komt binnen als 01/01/2001
                        $geboortedatum = explode('/', $data['GeboorteDatum']);
                        // geboortedatum[2] is jaar
                        $soortID = $this->bepaalSoortLid($geboortedatum[2]);
                        $geboortedatum = $geboortedatum[2].'-'.$geboortedatum[1].'-'.$geboortedatum[0];

                        if (!$model->aanpassenLid($_POST['LidID'], $_POST['FamilieID'], $data['Naam'], $soortID, $geboortedatum))
                            alertQueryError();
                    }
                break;
                case "verwijderen":
                    if ($this->ValideerID([$_POST['LidID']]))
                    {
                        if (!$model->verwijderLid($_POST['LidID']))
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
                case "toevoegen":
                    include_once "include/view/leden/lidToevoegen.php";
                break;
                case "aanpassen":
                    include_once "include/view/leden/lidAanpassen.php";
                break;
                case "verwijderen":
                    include_once "include/view/leden/lidVerwijderen.php";
                break;
                default:
                    return false;
                break;

            }
            return true;
        } 
        else if (isset($_GET['FamilieID']))
        {
            include_once "include/view/leden/ledenFamilieOverzicht.php";
            return true;
        } 
        return false;
    }

    protected function toonAlles()
    {
        include_once "include/view/leden/ledenOverzicht.php";
    }
}
?>