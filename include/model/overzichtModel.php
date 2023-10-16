<?php 
include_once "include/model/basisModel.php";
class overzichtModel extends Model
{ 
    public function HaalOverzicht() // families en contributies
    {
        $sql = "SELECT boekjaar.Jaar, familie.Naam, COUNT(`familie lid`.`LidID`) as `Aantal Personen`, 
        ROUND(SUM(contributie.Bedrag - contributie.Bedrag * contributie.Korting * 0.01), 2) as Bedrag 
        FROM `familie lid` JOIN familie ON `familie lid`.`FamilieID` = familie.ID 
        JOIN `soort lid` ON `familie lid`.`SoortID` = `soort lid`.`ID` 
        JOIN contributie ON `familie lid`.`SoortID` = contributie.SoortID 
        JOIN boekjaar ON contributie.BoekjaarID = Boekjaar.ID
        GROUP BY familie.ID, Boekjaar.ID ORDER BY Boekjaar.Jaar";

        $stmt = $this->connect()->prepare($sql);

        if ($stmt->execute()) 
        {
            return $stmt;
        }
        return false;
    }

    public function toon()
    {
        $this->query = $this->HaalOverzicht();
        $this->toonSimpel();
    } 
}
?>