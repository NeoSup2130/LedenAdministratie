<?php 
include_once "include/model/basisModel.php";
class familieModel extends Model
{ 
    public function haalFamilies()
    {
        $sql = "SELECT ID, Naam, Adres, Aangemaakt, Aangepast FROM `familie` WHERE 1;";
        return $this->doQuery($sql);
    }

    public function haalFamilie($ID) 
    {
        $sql = "SELECT ID, Naam, Adres, Aangemaakt, Aangepast FROM `familie` WHERE ID=?;";
        return $this->doQuery($sql, [$ID]);
    }

    public function haalLedenFamilie($FamilieID)
    {
        $sql = "SELECT FamilieID, LidID, `familie lid`.`Naam`, familie.Naam as Achternaam, `GeboorteDatum`, `soort lid`.`Soort`, Adres, 
        `familie lid`.Aangemaakt, `familie lid`.Aangepast 
        FROM `familie lid` JOIN familie on `familie lid`.`FamilieID` = familie.ID 
        JOIN `soort lid` ON `soort lid`.`ID` = `familie lid`.`SoortID`
        WHERE FamilieID=? ORDER BY `familie lid`.`Naam`;";
        return $this->doQuery($sql, [$FamilieID]);
    }

    public function toevoegenFamilie($naam, $adres) 
    {
        $sql = "INSERT INTO familie (Naam, Adres) VALUES (?, ?)";
        return $this->doQuery($sql, [$naam, $adres]);
    }

    public function aanpassenFamilie($id, $naam, $adres) 
    {
        $sql = "UPDATE familie SET Naam=?, Adres=?, Aangepast=CURRENT_TIMESTAMP WHERE ID=?";
        return $this->doQuery($sql, [$naam, $adres, $id]);
    }

    public function verwijderFamilie($ID) 
    {
        $sql = "DELETE FROM familie WHERE ID=?";
        return $this->doQuery($sql, [$ID]);
    }

    public static function haalRegex($key)
    {
        switch($key)
        {
            case "Naam": return "/^(?!^\s+$)[A-Za-zÀ-ÖØ-öø-ÿ\s'-]+$/"; break;
            case "Postcode": return "/^[1-9]\d{3}[A-Z]{2}$/"; break;
            case "Straat": return "/^[A-Za-z\s-]+$/"; break;
            case "Huisnummer": return "/^([1-9]\d*|[1-9])?\w?$/"; break;
        }
    }

    public function toon()
    {
        $this->query = $this->haalFamilies();
        $row = '';
        while($row = $this->query->fetch()) 
        {
        echo '<tr>';
            $id = $row["ID"];
            unset($row["ID"]);

            foreach($row as $item)
            {
                if ($item == '')
                {
                    echo '<td> .... </td>';
                } 
                else echo '<td>'.$item.'</td>';
            }

            $this->toonKnopCRUD('lid toevoegen', ['FamilieID', $id], 'get');
            $this->toonKnopCRUD("leden bekijken", ['FamilieID', $id], 'get');
            $this->toonKnopCRUD("aanpassen", ['FamilieID', $id], 'get');
            $this->toonKnopCRUD("verwijderen", ['FamilieID', $id], 'get');
        echo '</tr>';
        }
    } 
}
?>