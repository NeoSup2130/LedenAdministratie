<?
include_once 'include/view/template.php';
toonBeginPagina("Staffel overzicht - Sportclub de Cuijt");
$model = new StaffelsModel;
?>
<h2>Staffel toevoegen</h2>
<table>
    <thead>
        <tr>
            <th>Boekjaar</th>
            <th>Soort</th>
            <th>Tot en met welke leeftijd</th>
            <th>Korting</th>
            <th>Basis bedrag</th>
            <th colspan="1"></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <?
            $boekjaarModel = new BoekjaarModel;
            $boekjaren = $boekjaarModel->haalJaren()->fetchAll();
            $soortModel = new SoortModel;
            $soorten = $soortModel->haalSoorten()->fetchAll();
            ?>
            <form action="index.php?pagina=<?echo $_GET['pagina']?>" method="post">
            <td>
            <select name="BoekID" id="BoekID" required>
                <?
                foreach($boekjaren as &$jaren)
                {
                ?>
                <option value=<?echo $jaren['ID']?>><?echo $jaren['Jaar']?></option>
                <?
                }
                ?>
            </select>
            </td>
            <td>
            <select name="SoortID" id="SoortID" required>
                <?
                foreach($soorten as &$soort)
                {
                ?>
                <option value=<?echo $soort['ID']?>><?echo $soort['Soort']?></option>
                <?
                }
                ?>
            </select>
            </td>
            <td><input type="number" name="Leeftijd" id="Leeftijd" placeholder="12" step=1 min=0 required></td>
            <td><input type="number" name="Korting" id="Korting" placeholder="0,00" step=0.01 min=0 required></td>
            <td><input type="number" name="BasisBedrag" id="BasisBedrag" placeholder="100,00" step=0.01 min=0 required></td>
            <input type="hidden" name="methode" value="toevoegen">
            <td><input type="submit" value="toevoegen" class="btn"></td>
            </form>
        </tr>
        <?
        // $model->toon();
        ?>
    </tbody>
<table>
<hr>
<h2>Staffel overzicht</h2>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Boekjaar ID</th>
            <th>Soort</th>
            <th>Leeftijd</th>
            <th>Korting</th>
            <th>Basis bedrag</th>
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