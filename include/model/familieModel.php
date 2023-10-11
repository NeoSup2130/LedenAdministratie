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

            $this->toonKnopCRUD("lid toevoegen", ['familieID', $id]);
            $this->toonKnopCRUD("aanpassen", ['familieID', $id]);
            $this->toonKnopCRUD("verwijderen", ['familieID', $id]);
        echo '</tr>';
        }
    } 
}
?>