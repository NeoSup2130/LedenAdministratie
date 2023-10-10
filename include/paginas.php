<?php 

class PaginaManager
{
    protected $paginas = array();

    protected function VoegPaginaToe($naam, $include)
    {
        $this->paginas[$naam] = $include;
    }

    public function __construct()
    {
        $this->VoegPaginaToe("overzicht", ['include/main.css']);
        $this->VoegPaginaToe("families", ['include/main.css']);
        $this->VoegPaginaToe("soorten sport", ['include/main.css']);
        $this->VoegPaginaToe("staffels", ['include/main.css']);   
    }
    
    public function &GetPaginas()
    {
        return $this->paginas;
    }
}

?>