<?
include_once 'include/view/template.php';
toonBeginPagina("Leden overzicht - Sportclub de Cuijt");
$model = new ledenModel;
?>
<h2>Leden overzicht</h2>
<table>
    <tbody>
        <tr>
            <th>Voornaam</th>
            <th>Achternaam</th>
            <th>Geboorte Datum</th>
            <th>Adres</th>
            <th>Aangemaakt op</th>
            <th>Aangepast op</th>
        </tr>
        
        <?
        $model->toon();
        ?>
    </tbody>
</table>
<?
toonEindPagina();
?>