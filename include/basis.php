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
    public function alertQueryError()
    {
        ?><script>window.alert("<?echo $_SESSION['PDO_ERROR']->getMessage()?>")</script> <?
    }
}
?>