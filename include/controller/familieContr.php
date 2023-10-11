<?php 
require_once "include/basis.php";
include_once "include/model/familieModel.php";

class FamilieContr extends Database
{

    public function invoke()
    {
        if(isset($_POST['methode']))
        {
            $model = new familieModel;
            switch($_POST['methode'])
            {
                case "toevoegen":
                    $adres = $_POST['Postcode'].', '.$_POST['Straat'].' '.$_POST['Huisnummer'];
                    if (!$model->toevoegenFamilie($_POST['Naam'], $adres))
                    $this->alertQueryError();
                break;
                case "aanpassen":
                    if (!$model->aanpassenFamilie($_POST['familieID'], $_POST['Naam'], $_POST['Adres']))
                    $this->alertQueryError();
                break;
                case "verwijderen":
                    if (!$model->verwijderFamilie($_POST['familieID']))
                    $this->alertQueryError();
                break;
            }
            header('refresh:0');
        }

        if(isset($_GET['methode']))
        {
            switch($_GET['methode'])
            {
                case "lid toevoegen":
                    header('location: index.php?pagina=leden&familieID='.$_POST['familieID'].'&methode=toevoegen');
                    exit;
                break;
                case "aanpassen":
                    include_once "include/view/familie/familieAanpassen.php";
                break;
                case "verwijderen":
                    include_once "include/view/familie/familieVerwijderen.php";
                break;
            }
        } 
        else $this->toonAlles();
    }

    protected function toonAlles()
    {
        include_once "include/view/familie/familieOverzicht.php";
    }
}
?>