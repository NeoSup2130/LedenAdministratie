<?php 
require_once "include/basis.php";
include_once "include/model/ledenModel.php";
include_once "include/model/contributieModel.php";

class LedenContr extends Database
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
                    // geboortedatum komt binnen als 01/01/2001
                    $geboortedatum = explode('/', $_POST['GeboorteDatum']);
                    // geboortedatum[2] is jaar
                    $soortID = $this->bepaalSoortLid($geboortedatum[2]);

                    $geboortedatum = $geboortedatum[2].'-'.$geboortedatum[1].'-'.$geboortedatum[0];
                    if (!$model->toevoegenLid($_POST['FamilieID'], $_POST['Naam'], $soortID, $geboortedatum))
                    $this->alertQueryError();
                break;
                case "aanpassen":
                    if (!$model->aanpassenLid($_POST['LidID'], $_POST['FamilieID'], $_POST['Naam'], $_POST['GeboorteDatum']))
                    $this->alertQueryError();
                break;
                case "verwijderen":
                    if (!$model->verwijderLid($_POST['LidID']))
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
                case "toevoegen":
                    include_once "include/view/leden/lidToevoegen.php";
                break;
                case "aanpassen":
                    include_once "include/view/leden/lidAanpassen.php";
                break;
                case "verwijderen":
                    include_once "include/view/leden/lidVerwijderen.php";
                break;
            }
            return true;
        } 
        else if (isset($_GET['familieID']))
        {
            include_once "include/view/leden/ledenFamilieOverzicht.php";
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
        include_once "include/view/leden/ledenOverzicht.php";
    }
}
?>