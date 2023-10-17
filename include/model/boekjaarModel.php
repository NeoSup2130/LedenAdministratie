<?php 
include_once "include/model/basisModel.php";
class BoekjaarModel extends Model
{ 
    public function HaalOverzicht() 
    {
        $sql = "SELECT boekjaar.ID, boekjaar.Jaar, contributie.Bedrag as `Basis bedrag`, ROUND(SUM(contributie.Bedrag - contributie.Bedrag * contributie.Korting * 0.01), 2) as `Totaal bedrag` 
        FROM boekjaar 
        JOIN `contributie` ON `contributie`.`BoekjaarID`=boekjaar.ID
        JOIN `soort lid` ON `soort lid`.`ID`=contributie.SoortID
        JOIN `familie lid` ON `familie lid`.`SoortID`=`soort lid`.`ID`
        WHERE 1 GROUP BY boekjaar.ID, boekjaar.Jaar, contributie.Bedrag ORDER BY boekjaar.Jaar;";
        $stmt = $this->connect()->prepare($sql);

        if ($stmt->execute()) 
        {
            return $stmt;
        }
        return false;
    }

    public function haalLaatsteJaar()
    {
        $sql = "SELECT boekjaar.ID FROM boekjaar ORDER BY ID DESC LIMIT 1;";
        $result = null;
        if (!$result = $this->doQuery($sql))
        {
            alertQueryError();
        }
        return $result->fetch()['ID'];
    }

    public function haalContributieJaar($boekID)
    {
        $fetchSQL = "SELECT `soort lid`.ID, `contributie`.Leeftijd, contributie.Korting, contributie.Bedrag FROM `soort lid` 
        JOIN contributie ON `soort lid`.ID=contributie.SoortID
        WHERE contributie.BoekjaarID=? ORDER BY contributie.Leeftijd;";
        if (!$result = $this->doQuery($fetchSQL, [$boekID]))
        {
            alertQueryError();
        }
        return $result;
    }

    public function haalBoekjaar($ID) 
    {
        $sql = "SELECT * FROM boekjaar WHERE ID=?;";
        return $this->doQuery($sql, [$ID]);
    }
    
    public function haalJaren()
    {
        $sql = "SELECT ID, Jaar FROM boekjaar WHERE 1;";
        return $this->doQuery($sql);
    }

    public function voegContributiesToe($boekID, $basisbedrag, &$staffels = array()) 
    {
        $cascaseSQL = "INSERT INTO `contributie` (`BoekjaarID`, `SoortID`, `Leeftijd`, `Korting`, `Bedrag`) 
        VALUES (?, ?, ?, ?, ?)";
        foreach($staffels as &$staffel)
        {
            if (!$this->doQuery($cascaseSQL, [$boekID, $staffel['ID'], $staffel['Leeftijd'], $staffel['Korting'], $basisbedrag]))
            {
                alertQueryError();
                return false;
            }      
        }    
        return true;
    }

    public function aanpassenContributies($boekID, $basisbedrag, &$staffels = array())
    {
        $cascaseSQL = "UPDATE `contributie` SET `BoekjaarID`=? `SoortID`=? `Leeftijd`=? `Korting`=? `Bedrag`=?;"; 
        foreach($staffels as &$staffel)
        {
            if (!$this->doQuery($cascaseSQL, [$boekID, $staffel['ID'], $staffel['Leeftijd'], $staffel['Korting'], $basisbedrag]))
            {
                alertQueryError();
                return false;
            }      
        }
        return true;
    }

    public function toevoegenBoekjaar($jaar, $basisbedrag) 
    {
        $laatsteBoekID = $this->haalLaatsteJaar();

        // Nieuwe boekjaar toevoegen
        $sql = "INSERT INTO boekjaar (Jaar) VALUES (?)";
        if (!$this->doQuery($sql, [$jaar]))
        {
            alertQueryError();
        }

        $boekID = $this->haalLaatsteJaar();

        // Haal oude staffels als referentie voor nieuwe staffel
        $staffels = $this->haalContributieJaar($laatsteBoekID)->fetchAll();

        $this->voegContributiesToe($boekID, $basisbedrag, $staffels);
        
        return true;
    }

    public function aanpassenBoekjaar($id, $jaar) 
    {
        $sql = "UPDATE boekjaar SET Jaar=? WHERE ID=?";
        return $this->doQuery($sql, [$jaar, $id]);
    }

    public function verwijderBoekjaar($ID) 
    {
        $sql = "DELETE FROM boekjaar WHERE ID=?";
        return $this->doQuery($sql, [$ID]);
    }

    public static function haalRegex($key)
    {
        switch($key)
        {
            case "Jaar": return "/^\d{4}$/"; break;
            case "BasisBedrag": return "/^\d+(.\d{1,2})?$/"; break;
        }
    }

    public function toon()
    {
        $this->query = $this->HaalOverzicht();
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
            $this->toonKnopCRUD("aanpassen", ['BoekjaarID', $id], 'get');
            $this->toonKnopCRUD("verwijderen", ['BoekjaarID', $id], 'get');
        echo '</tr>';
        }
    } 
}
?>