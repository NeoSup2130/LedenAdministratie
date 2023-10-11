<?php 
include_once "include/model/basisModel.php";
class ledenModel extends Model
{ 
    public function haalLedenOverzicht()
    {
        $sql = "SELECT FamilieID, LidID, `familie lid`.`Naam`, familie.Naam as Achternaam, `GeboorteDatum`, Adres, 
        `familie lid`.Aangemaakt, `familie lid`.Aangepast 
        FROM `familie lid` INNER JOIN familie WHERE `familie lid`.`FamilieID` = familie.ID;";
        return $this->doQuery($sql);
    }

    public function haalLid($id) 
    {
        $sql = "SELECT FamilieID, LidID, `familie lid`.`Naam`, familie.Naam as Achternaam, `GeboorteDatum`, Adres, 
        `familie lid`.Aangemaakt, `familie lid`.Aangepast 
        FROM `familie lid` INNER JOIN familie WHERE `familie lid`.`LidID`=?;";
        return $this->doQuery($sql, [$id]);
    }

    public function haalLedenFamilie($familieID)
    {
        $sql = "SELECT * FROM `familie lid` WHERE FamilieID=?;";
        return $this->doQuery($sql, [$familieID]);
    }

    public function toevoegenLid($familieID, $naam, $geboortedatum) 
    {
        $sql = "INSERT INTO `familie lid` (FamilieID, Naam, GeboorteDatum) VALUES (?, ?, ?)";
        return $this->doQuery($sql, [$familieID, $naam, $geboortedatum]);
    }

    public function aanpassenLid($id, $familieID, $naam, $geboortedatum) 
    {
        $sql = "UPDATE `familie lid` SET FamilieID=?, Naam=?, GeboorteDatum=?, Aangepast=CURRENT_TIMESTAMP WHERE `familie lid`.`LidID`=?";
        return $this->doQuery($sql, [$familieID, $naam, $geboortedatum, $id]);
    }

    public function verwijderLid($ID) 
    {
        $sql = "DELETE FROM `familie lid` WHERE LidID=?";
        return $this->doQuery($sql, [$ID]);
    }

    public function toon()
    {
        $this->query = $this->haalLedenOverzicht();
        $row = '';
        while($row = $this->query->fetch()) 
        {
        echo '<tr>';
            $ids = ["FamilieID", $row["FamilieID"], "LidID", $row["LidID"]];
            unset($row["LidID"]);
            unset($row["FamilieID"]);

            foreach($row as $item)
            {
                if ($item == '')
                {
                    echo '<td> .... </td>';
                } 
                else echo '<td>'.$item.'</td>';
            }
            $this->toonKnopCRUD("aanpassen", $ids);
            $this->toonKnopCRUD("verwijderen", $ids);
        echo '</tr>';
        }
    } 
}
?>