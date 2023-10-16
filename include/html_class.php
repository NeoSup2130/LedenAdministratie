<?php

function generateHeader($title, $includeCallback) 
{
    echo 
    '<!DOCTYPE html>
    <html>
    <head>
    <meta charset="UTF-8">
    <title>'.$title.'</title>
    ';

    if (is_callable($includeCallback)) {
        call_user_func($includeCallback);
    }

    echo
    '</head>
    <body>';
}

function generateList($selectie, $list = array())
{
    echo ' <ul>';
    $items = array_keys($list);
    foreach($items as $name)
    {        
        if ($name === $selectie)
            echo '<li>'.ucfirst($name).'</li>';
        
        else
        { 
            ?> 
            <li>
                <a <?echo ('href=index.php?pagina='.urlencode($name));?>> 
                <?echo ucfirst($name);?>
                </a>
            </li>
            <?
        } // via een GET variable, pagina, bepaal ik wat voor pagina we weergeven om de database aan te passen.
           
        
        if(is_array($list[$name]) && count($list[$name]) > 0) 
        {
            foreach($list[$name] as $subpagina)
            {
                generateList($selectie, [$subpagina => '']);
            }
        }
    }
    echo ' </ul>';
}

function generateNav()
{
    include_once 'include/paginas.php';

    $pMan = new PaginaManager();

    $selectie = "overzicht";
    if(isset($_GET['pagina']))
    {
        $selectie = $_GET['pagina'];
    }
    generateList($selectie, $pMan->GetPaginas());
}

function generateFooter() 
{
    echo '<footer>';
    echo '@ '.date_create()->format('Y').' Copyright Sportclub de Cuijt';
    echo '</footer></body></html>';
}

function linkCSS($href) 
{
    echo "<link rel='stylesheet' type='text/css' href='$href'>";
}
?>