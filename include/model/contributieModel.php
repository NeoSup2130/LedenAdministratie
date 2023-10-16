<?php 
include_once "include/model/basisModel.php";
class ContributieModel extends Model
{ 
    public function haalContributies()
    {
        $sql = "SELECT * FROM contributie WHERE 1;";
        return $this->doQuery($sql);
    }

    public function haalContributieJaar($boekjaar = 0)
    {   
        if ($boekjaar == 0)
        {
            $sql = "SELECT * FROM `contributie` WHERE 1 ORDER BY BoekjaarID DESC LIMIT 1;";
            if (!$boekjaar = $this->doQuery($sql))
            {
                $this->alertQueryError();
                exit;
            }
            $boekjaar = $boekjaar->fetch()['BoekjaarID'];
        }
        
        $sql = "SELECT * FROM contributie WHERE BoekjaarID=?;";
        return $this->doQuery($sql, [$boekjaar]);
    }

    public function haalContributie($ID) 
    {
        $sql = "SELECT * FROM contributie WHERE ID=?;";
        return $this->doQuery($sql, [$ID]);
    }

    public function toevoegenContributie($boekID, $soortID, $leeftijd, $korting, $bedrag) 
    {
        $sql = "INSERT INTO contributie (BoekjaarID, SoortID, Leeftijd, Korting, Bedrag) VALUES (?, ?, ?, ?, ?)";
        return $this->doQuery($sql, [$boekID, $soortID, $leeftijd, $korting, $bedrag]);
    }

    public function aanpassenContributie($boekID, $soortID, $leeftijd, $korting, $bedrag) 
    {
        $sql = "UPDATE contributie SET BoekjaarID=? SoortID=? Leeftijd=? Korting=? Bedrag=?";
        return $this->doQuery($sql, [$boekID, $soortID, $leeftijd, $korting, $bedrag]);
    }

    public function verwijderContributie($ID) 
    {
        $sql = "DELETE FROM contributie WHERE ID=?";
        return $this->doQuery($sql, [$ID]);

    }

    public function toon()
    {
        $this->query = $this->haalContributies();
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
            $this->toonKnopCRUD("aanpassen", ['contributieID', $id], 'get');
            $this->toonKnopCRUD("verwijderen", ['contributieID', $id], 'get');
        echo '</tr>';
        }
    } 
}
?>