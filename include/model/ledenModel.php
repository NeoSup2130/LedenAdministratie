<?php 
include_once "include/model/basisModel.php";
class ledenModel extends Model
{ 
    public function haalLedenOverzicht()
    {
        $sql = "SELECT FamilieID, LidID, `familie lid`.`Naam`, familie.Naam as Achternaam, `GeboorteDatum`, `soort lid`.Soort, Adres, `familie lid`.Aangemaakt, `familie lid`.Aangepast 
        FROM `familie lid` JOIN familie on `familie lid`.`FamilieID` = familie.ID 
        JOIN `soort lid` ON `soort lid`.ID = `familie lid`.SoortID
        ORDER BY familie.Naam;";
        return $this->doQuery($sql);
    }

    public function haalLid($id) 
    {
        $sql = "SELECT FamilieID, LidID, `familie lid`.`Naam`, familie.Naam as Achternaam, `GeboorteDatum`, `soort lid`.`Soort`, Adres, 
        `familie lid`.Aangemaakt, `familie lid`.Aangepast 
        FROM `familie lid` JOIN familie on `familie lid`.`FamilieID` = familie.ID 
        JOIN `soort lid` ON `soort lid`.`ID` = `familie lid`.`SoortID`
        WHERE LidID=?";
        return $this->doQuery($sql, [$id]);
    }

    public function haalLedenFamilie($familieID)
    {
        $sql = "SELECT FamilieID, LidID, `familie lid`.`Naam`, familie.Naam as Achternaam, `GeboorteDatum`, `soort lid`.`Soort`, Adres, 
        `familie lid`.Aangemaakt, `familie lid`.Aangepast 
        FROM `familie lid` JOIN familie on `familie lid`.`FamilieID` = familie.ID 
        JOIN `soort lid` ON `soort lid`.`ID` = `familie lid`.`SoortID`
        WHERE FamilieID=? ORDER BY `familie lid`.`Naam`;";
        return $this->doQuery($sql, [$familieID]);
    }

    public function toevoegenLid($familieID, $naam, $soortID, $geboortedatum) 
    {
        $sql = "INSERT INTO `familie lid` (FamilieID, Naam, SoortID, GeboorteDatum) VALUES (?, ?, ?, ?)";
        return $this->doQuery($sql, [$familieID, $naam, $soortID, $geboortedatum]);
    }

    public function aanpassenLid($id, $familieID, $naam, $soortID, $geboortedatum) 
    {
        $sql = "UPDATE `familie lid` SET FamilieID=?, Naam=?, SoortID=?, GeboorteDatum=?, Aangepast=CURRENT_TIMESTAMP WHERE `familie lid`.`LidID`=?";
        return $this->doQuery($sql, [$familieID, $naam, $soortID, $geboortedatum, $id]);
    }

    public function verwijderLid($ID) 
    {
        $sql = "DELETE FROM `familie lid` WHERE LidID=?";
        return $this->doQuery($sql, [$ID]);
    }

    public static function haalRegex($key)
    {
        switch($key)
        {
            case "Naam": return "/^(?!^\s+$)[A-Za-zÀ-ÖØ-öø-ÿ\s'-]+$/"; break;
            case "GeboorteDatum": return "/^(0[1-9]|[12][0-9]|3[01])\\/(0[1-9]|1[0-2])\\/\d{4}$/"; break;
        }
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
            $this->toonKnopCRUD("aanpassen", $ids, "get");
            $this->toonKnopCRUD("verwijderen", $ids, "get");
        echo '</tr>';
        }
    } 
}
?>