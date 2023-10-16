<?php
include_once "include/basis.php";
abstract class Model extends Database
{
    protected $query;

    public function __construct()
    {
        $this->database = 'sportclub de cuijt';
    }

    abstract public function toon();

    protected function doQuery($sql, $args = [])
    {
        $stmt = null;
        try {
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute($args);
        } catch (PDOException $e) {
            $_SESSION['PDO_ERROR'] = $e;
            return false;            
        }
        return $stmt;
    }

    public function toonSimpel() 
    {
        while ($row = $this->query->fetch())
        {
            echo '<tr>';
            foreach($row as &$item)
            {
                echo '<td>'.$item.'</td>';
            }
            echo '</tr>';
        }
    }

    public static function toonSimpelQuery($query)
    {
        while ($row = $query->fetch())
        {
            echo '<tr>';
            foreach($row as &$item)
            {
                echo '<td>'.$item.'</td>';
            }
            echo '</tr>';
        }
    }

    public function toonKnopCRUD($methode = 'verwijderen', $identifier = ['NAME', 'ID'], $request='post')
    {
        echo '<td><form action="index.php" method="'.$request.'">'; 
        echo '<input type="hidden" name="pagina" value='.urlencode($_GET['pagina']).'>';
        echo '<input type="hidden" name="methode" value="'.$methode.'">';
        for($i = 0, $max = count($identifier); $i < $max; $i+=2) 
        {
            echo '<input type="hidden" name="'.$identifier[$i].'" value='.$identifier[$i + 1].'>';
        }
        echo'<input type="submit" value="'.$methode.'" class="btn"></form></td>';
    }

    public function getTabelData()
    {
        $result = '';
        if($row =$this->query->fetch())
        {
            $result = $result.'<tr>';
            foreach($row as $item)
            {
                $result = $result.'<td>'.$item.'</td>';
            }
            $result = $result.'</tr>';
        }
        return $result;
    }
}

?>