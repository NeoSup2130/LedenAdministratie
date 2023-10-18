<?php 
require_once "include/basis.php";

class Validator {

    public $filters;
    public $type;
    
    public function __construct($type = INPUT_POST)
    {
        $this->type = $type;
    }

    public function AddFilter($key, $regex)  
    {
        $this->filters[$key] = array('filter' => FILTER_VALIDATE_REGEXP,
        'options' => array('regexp' => $regex));    
    }
    // Gebruikt met AddFilter om POST of GET variabelen te valideren 
    public function Validate()
    {
        $data = filter_input_array($this->type, $this->filters);
        foreach ($data as $key => $value) 
        {
            if ($value === false || empty($value)) 
            {
                goto error;
            }
        }
        return $data;
        
        error:
        alertError("Ongeldige informatie doorgestuurd!");
        return false;
    }
}

abstract class Controller extends Database
{
    protected function ValideerID($ids = [])
    {
        if (empty($ids)) return false;
        if (!is_array($ids)) 
        {
            alertError("array is nodig voor ValideerID!s");
            return false;
        }
        foreach($ids as &$id)
        {
            if(isset($id) && is_numeric($id) && intval($id > 0))
            continue;
            else return false;
        }
        return true;
    }
    
    abstract protected function handelPOST();
    abstract protected function handelGET();
    abstract protected function toonAlles();

    public function invoke()
    {
        if(isset($_SERVER['REQUEST_METHOD']))
        {
            switch($_SERVER['REQUEST_METHOD'])
            {
                case 'POST': 
                    $this->handelPOST();
                    break;
                    case 'GET':
                        if (!$this->handelGET())
                            $this->toonAlles(); 
                        break;
                default:
                break;
            }
        } 
    }
}

?>