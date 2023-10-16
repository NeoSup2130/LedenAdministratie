<?php 
include_once "include/model/basisModel.php";
class StaffelsModel extends Model
{ 
    public function haalStaffels()
    {
        $sql = "SELECT contributie.ID, boekjaar.Jaar, `soort lid`.`Soort`, Leeftijd, Korting, Bedrag  
        FROM `contributie` 
        JOIN  `soort lid` ON `soort lid`.`ID` = `contributie`.`SoortID` 
        JOIN boekjaar ON boekjaar.ID = contributie.BoekjaarID
        WHERE 1 ORDER BY boekjaar.Jaar;";
        return $this->doQuery($sql);
    }

    public function haalStaffel($ID) 
    {
        $sql = "SELECT * FROM `contributie` WHERE ID=?;";
        return $this->doQuery($sql, [$ID]);
    }

    public function haalBoekJaarStaffel($ID, $BoekID) 
    {
        $sql = "SELECT * FROM `contributie` WHERE ID=? AND BoekjaarID=?;";
        return $this->doQuery($sql, [$ID, $BoekID]);
    }

    public function toevoegenStaffel($boekID, $soortID, $leeftijd, $korting, $basisBedrag) 
    {
        $sql = "INSERT INTO `contributie` (BoekjaarID, SoortID, Leeftijd, Korting, Bedrag) VALUES (?, ?, ?, ?, ?)";
        return $this->doQuery($sql, [$boekID, $soortID, $leeftijd, $korting, $basisBedrag]);
    }

    public function aanpassenStaffel($ID, $boekID, $soortID, $leeftijd, $korting, $basisBedrag) 
    {
        $sql = "UPDATE `contributie` SET `BoekjaarID` = ?, `SoortID` = ?, `Leeftijd` = ?, `Korting` = ?,
        `Bedrag` = ? WHERE `contributie`.`ID`=?;";
        return $this->doQuery($sql, [$boekID, $soortID, $leeftijd, $korting, $basisBedrag, $ID]);
    }

    public function verwijderStaffel($ID) 
    {
        $sql = "DELETE FROM `contributie` WHERE ID=?";
        return $this->doQuery($sql, [$ID]);
    }

    public function toon()
    {
        $this->query = $this->haalStaffels();
        $row = '';
        while($row = $this->query->fetch()) 
        {
        echo '<tr>';
            $id = $row["ID"];

            foreach($row as $item)
            {
                if ($item == '')
                {
                    echo '<td> .... </td>';
                } 
                else echo '<td>'.$item.'</td>';
            }
            $this->toonKnopCRUD("aanpassen", ['StaffelID', $id], 'get');
            $this->toonKnopCRUD("verwijderen", ['StaffelID', $id], 'get');
        echo '</tr>';
        }
    } 
}
?>