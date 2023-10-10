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

function generateNav()
{
    include_once 'include/paginas.php';

    $pMan = new PaginaManager();

    $selectie = "overzicht";
    if(isset($_GET['pagina']))
    {
        $selectie = $_GET['pagina'];
    }

    echo ' <ul>';

    $paginas = array_keys($pMan->GetPaginas());
    foreach($paginas as $name)
    {
        if ($name === $selectie)
            echo '<li>'.ucfirst($name).'</li>';
        else // via een GET variable, pagina, bepaal ik wat voor pagina we weergeven om de database aan te passen.
            echo '<li><a href=index.php?pagina='.$name.'>'.ucfirst($name).'</a></li>';
    }
    echo ' </ul>';
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