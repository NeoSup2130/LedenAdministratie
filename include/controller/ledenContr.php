<?php 
require_once "include/basis.php";
include_once "include/model/ledenModel.php";

class LedenContr extends Database
{
    public function invoke()
    {
        if(isset($_POST['methode']))
        {
            $model = new ledenModel;
            switch($_POST['methode'])
            {
                case "toevoegen":
                    $geboortedatum = explode('/', $_POST['GeboorteDatum']);
                    $geboortedatum = $geboortedatum[2].'-'.$geboortedatum[1].'-'.$geboortedatum[0];
                    if (!$model->toevoegenLid($_POST['FamilieID'], $_POST['Naam'], $geboortedatum))
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
        } 
        else $this->toonAlles();
    }

    protected function toonAlles()
    {
        include_once "include/view/leden/ledenOverzicht.php";
    }
}
?>