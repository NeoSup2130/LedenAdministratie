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