<?
include_once 'include/view/template.php';
toonBeginPagina("Boekjaar overzicht - Sportclub de Cuijt");
$model = new BoekjaarModel;
?><h2>Boekjaar toevoegen</h2>
<table>
    <thead>
        <tr>
            <th>Jaar</th>
            <th>Basis bedrag</th>
            <th colspan="1"></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <form action="index.php?pagina=<?echo $_GET['pagina']?>" method="post">
            <td><input type="text" name="BoekJaar" id="BoekJaar" placeholder="2023" pattern="^[2]\d{3}$" required></td>
            <td><input type="number" name="BasisBedrag" id="BasisBedrag" placeholder="100,00" step=0.01 min=0 required></td>
            <input type="hidden" name="methode" value="toevoegen">
            <td><input type="submit" value="toevoegen" class="btn"></td>
            </form>
        </tr>
    </tbody>
</table>
<hr>
<h2>Boekjaar overzicht</h2>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Boekjaar</th>
            <th>Basis bedrag</th>
            <th>Totaal bedrag</th>
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