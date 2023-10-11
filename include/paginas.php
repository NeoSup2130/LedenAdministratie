<?php 

class PaginaManager
{
    protected $paginas = array();

    protected function VoegPaginaToe($naam, $subpagina = [])
    {
        $this->paginas[$naam] = $subpagina;
    }

    public function __construct()
    {
        $this->VoegPaginaToe("overzicht");
        $this->VoegPaginaToe("families", ['leden']);
        $this->VoegPaginaToe("soorten sport");
        $this->VoegPaginaToe("staffels");   
    }
    
    public function &GetPaginas()
    {
        return $this->paginas;
    }
}

?>