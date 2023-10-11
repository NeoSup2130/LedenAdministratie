<?php 
include_once "include/model/basisModel.php";
class overzichtModel extends Model
{ 
    public function HaalOverzicht() // families en contributies
    {
        $sql = "SELECT boekjaar.Jaar, families.Naam, COUNT(families.`LidID`) as `Aantal Personen`, SUM(contributie.Bedrag) as `Totaal bedrag` FROM "
        ."(SELECT familie.Naam, `familie lid`.`LidID` FROM familie, `familie lid` WHERE `familie lid`.`FamilieID` = familie.ID ORDER BY familie.ID) as families, "
        ."contributie, boekjaar WHERE families.`LidID` = contributie.LidID AND boekjaar.ID = contributie.BoekID GROUP BY boekjaar.Jaar, families.Naam;";

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