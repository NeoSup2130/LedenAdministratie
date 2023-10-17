<?php 
include_once "include/model/basisModel.php";
class SoortModel extends Model
{ 
    public function haalSoorten()
    {
        $sql = "SELECT * FROM `soort lid` WHERE 1;";
        return $this->doQuery($sql);
    }

    public function haalSoort($ID) 
    {
        $sql = "SELECT * FROM `soort lid` WHERE ID=?;";
        return $this->doQuery($sql, [$ID]);
    }

    public function toevoegenSoort($naam) 
    {
        $sql = "INSERT INTO `soort lid` (Soort) VALUES (?)";
        return $this->doQuery($sql, [$naam]);
    }

    public function aanpassenSoort($ID, $naam) 
    {
        $sql = "UPDATE `soort lid` SET `Soort` =? WHERE `soort lid`.`ID`=?;";
        return $this->doQuery($sql, [$naam, $ID]);
    }

    public function verwijderSoort($ID) 
    {
        $sql = "DELETE FROM `soort lid` WHERE ID=?";
        return $this->doQuery($sql, [$ID]);

    }

    public static function haalRegex($key)
    {
        switch($key)
        {
            case "Soort": return "/^(?!^\s+$)[A-Za-zÀ-ÖØ-öø-ÿ\s'-]+$/"; break;
        }
    }

    public function toon()
    {
        $this->query = $this->haalSoorten();
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
            $this->toonKnopCRUD("aanpassen", ['SoortID', $id], 'get');
            $this->toonKnopCRUD("verwijderen", ['SoortID', $id], 'get');
        echo '</tr>';
        }
    } 
}
?>