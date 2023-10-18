<?
include_once 'include/view/template.php';
toonBeginPagina("Familie overzicht - Sportclub de Cuijt");
$model = new familieModel;
?>
<h2>Familie toevoegen</h2>
<table>
    <thead>
        <tr>
            <th>Familie Naam</th>
            <th>Postcode</th>
            <th>Straat</th>
            <th>Huisnummer</th>
            <th colspan="1"></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <form action="index.php?pagina=<?echo $_GET['pagina']?>" method="post">
            <td><input type="text" name="Naam" id="Naam" placeholder="Familie Naam" pattern="^(?!^\s+$)[A-Za-zÀ-ÖØ-öø-ÿ\s'-]+$" required></td>
            <td><input type="text" name="Postcode" id="Postcode" placeholder="Postcode" pattern="^[1-9]\d{3}[A-Z]{2}$" required></td>
            <td><input type="text" name="Straat" id="Straat" placeholder="Straat" pattern="^[A-Za-z\s-]+$" required></td>
            <td><input type="text" name="Huisnummer" id="Huisnummer" placeholder="Huisnummer" pattern="^([1-9]\d*|[1-9])?\w?$" required></td>
            <input type="hidden" name="methode" value="toevoegen">
            <td><input type="submit" value="toevoegen" class="btn"></td>
            </form>
        </tr>
    </tbody>
</table>
<hr>
<h2>Familie overzicht</h2>
        <table>
            <thead>
                <tr>
                    <th>Familie</th>
                    <th>Adres</th>
                    <th>Aangemaakt op</th>
                    <th>Aangepast op</th>
                    <th colspan="4"></th>
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