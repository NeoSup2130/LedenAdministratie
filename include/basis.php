<?php 
class Database
{
    private $servername = 'localhost'; 
    private $username = 'root';
    private $password = 'mysql'; 
    protected $database = '';

    public function connect() 
    {
        $conn = null;
        try 
        {
            $dsn = 'mysql:host='.$this->servername.';dbname='.$this->database;

            $conn = new PDO($dsn, $this->username, $this->password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conn->setAttribute( PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } 
        catch (PDOException $e) 
        {
            die("Database connection failed: " . $e->getMessage());
        }
        return $conn;
    }
}

class AdminUser extends Database
{
    public $gebruiker;
    public $wachtwoord;
    protected $id;

    public function __construct($gebruiker, $wachtwoord)
    {
        $gebruiker = htmlspecialchars($_POST['gebruiker'], ENT_QUOTES);
        $wachtwoord = htmlspecialchars($_POST['wachtwoord'], ENT_QUOTES);

        $this->gebruiker = $gebruiker;
        $this->wachtwoord = $wachtwoord;

        $this->database = 'sportclub de cuijt';
    }

    public function GetUser()
    {
        $sql = 'SELECT ID, GebruikersNaam, Wachtwoord, AuthCode FROM gebruikers WHERE GebruikersNaam=?';
        $stmt = $this->connect()->prepare($sql);

        if ($stmt->execute([$this->gebruiker])) 
        {
            return $stmt->fetch();
        }
        return false;
    }

    public function SetUser()
    {
        $sql = "UPDATE gebruikers SET GebruikersNaam=?, Wachtwoord=? WHERE ID=?";
        $stmt = $this->connect()->prepare($sql);

        if ($stmt->execute([$this->gebruiker, $this->wachtwoord, $this->id])) 
        {
            return true;
        }
        return false;
    }

    public function SetAuthCode()
    {
        $sql = "UPDATE gebruikers SET AuthCode=? WHERE ID=?";
        $stmt = $this->connect()->prepare($sql);

        $code = bin2hex(random_bytes(32)); 
        // Cookie opgeslagen voor 30 dagen
        setcookie("AuthCode", $code, time() + 3600 * 24 * 30, "/Ledenadministratie", "", true, true);
        
        if ($stmt->execute([$code, $this->id])) 
        {
            return true;
        }
        return false;
    }

    public function deleteAuthCode()
    {
        $sql = "UPDATE gebruikers SET AuthCode=? WHERE ID=?";
        $stmt = $this->connect()->prepare($sql);

        if ($stmt->execute(['', $this->id])) 
        {
             return true;
        }
        return false;
    }
}

class AdminUserContr extends AdminUser
{
    public function LoginIn()
    {
        if ($query = $this->GetUser())
        {
            if ($this->gebruiker === $query['GebruikersNaam'] && password_verify($this->wachtwoord, $query['Wachtwoord'])
                || isset($_COOKIE["AuthCode"]) && $_COOKIE["AuthCode"] === $query['AuthCode'])
            {
                $this->id = $query['ID'];
                $this->SetAuthCode();
            }
            $_SESSION['GebruikerID'] = $this->id;
            $_SESSION['GebruikerNaam'] = $this->gebruiker;
            return true;
        }
        else 
        {
            return false;
        }
    }
    public function LogOut()
    {
        $this->deleteAuthCode();
        session_unset();
        session_destroy();
    }
}
?>