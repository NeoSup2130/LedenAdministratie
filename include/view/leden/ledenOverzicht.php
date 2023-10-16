<?
include_once 'include/view/template.php';
toonBeginPagina("Leden overzicht - Sportclub de Cuijt");
$model = new ledenModel;
?>
<h2>Leden overzicht</h2>
<table>
    <thead>
    <tr>
            <th>Voornaam</th>
            <th>Achternaam</th>
            <th>Geboorte Datum</th>
            <th>Soort lid</th>
            <th>Adres</th>
            <th>Aangemaakt op</th>
            <th>Aangepast op</th>
            <th colspan="2"></th>
        </tr>
    </thead>
    <tbody>
        <?
        $model->toon();
        ?>
    </tbody>
</table>
<?
toonEindPagina();
?>