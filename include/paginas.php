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
        $this->VoegPaginaToe("familie", ['familie leden']);
        $this->VoegPaginaToe("contributie", ['soort leden', 'staffels']);
    }
    
    public function &GetPaginas()
    {
        return $this->paginas;
    }
}

?>