<?php 
require_once "include/basis.php";

class AdminUser extends Database
{
    public $gebruiker;
    public $wachtwoord;
    protected $id;

    // Als gebruiker en wachtwoord null zijn dan wordt er ingelogd met de AuthCode cookie als die er is.
    public function __construct($gebruiker = "", $wachtwoord = "")
    {
        $this->Init($gebruiker, $wachtwoord);
        $this->database = 'sportclub de cuijt';
    }

    public function Init($gebruiker = "", $wachtwoord = "")
    {
        if (isset($_POST['gebruiker']) && isset($_POST['wachtwoord']))
        {
            $gebruiker = htmlspecialchars($_POST['gebruiker'], ENT_QUOTES);
            $wachtwoord = htmlspecialchars($_POST['wachtwoord'], ENT_QUOTES);
    
            $this->gebruiker = $gebruiker;
            $this->wachtwoord = $wachtwoord;    
        }
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
        setcookie("AuthCode", $code, time() + 3600 * 24 * 30, "/", "", true, true);
        
        if ($stmt->execute([$code, $this->id])) 
        {
            return true;
        }
        return false;
    }

    public function DeleteAuthCode()
    {
        setcookie("AuthCode", ' ', time() - 3600 * 24 * 364, "/", "", true, true);

        $sql = "UPDATE gebruikers SET AuthCode=? WHERE ID=?";
        $stmt = $this->connect()->prepare($sql);

        if ($stmt->execute([" ", $this->id])) 
        {
             return true;
        }
        return false;
    }
}

class AdminUserContr extends AdminUser
{
    protected function LoginIn()
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
    protected function LogOut()
    {
        unset($_GET);
        $this->DeleteAuthCode();
        session_unset();
        session_destroy();
        return true;
    }

    public function ToonLogin()
    {
        $loginFout = false;
        
        if(isset($_POST['gebruiker']) && isset($_POST['wachtwoord']))
        {
            $this->Init($_POST['gebruiker'], $_POST['wachtwoord']); 

            if ($this->LoginIn())
            {
                header("Refresh:0");
            }
            else 
            {
                $loginFout = true;
            }
        }   
        generateHeader("Inloggen administratie de Cuijt", function () {linkCSS("css/main.css"); linkCSS("css/login.css");});
        include_once "include/view/gebruiker/login.php";
    }

    public function ToonLoguit()
    {
        if($_SESSION['GebruikerID'])
        {
            if (isset($_POST['LogUit']) && $_POST['LogUit'] === '1')
            {
                $this->LogOut();
                header("Refresh:0");
            }
        }
        generateHeader("Uitloggen de Cuijt", function () {linkCSS("css/main.css");});
        include_once "include/view/gebruiker/loguit.php";
    }
}
?>