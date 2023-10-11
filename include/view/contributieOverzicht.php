<?
include_once 'include/view/template.php';
toonBeginPagina("Families contributie overzicht - Sportclub de Cuijt");
$model = new overzichtModel;
?>
        <table>
            <tbody>
                <tr>
                    <th>Jaar</th>
                    <th>Familie</th>
                    <th>Aantal personen</th>
                    <th>Totaal bedrag</th>
                </tr>
                <?
                $model->toon();
                ?>
            </tbody>
        </table>
<?
toonEindPagina();
?>