<div class="grid-container">
    <header class="grid-item">
        <h1>Familie contributie overzicht - Sportclub de Cuijt</h1>
    </header>
    <nav class="grid-item">
        <?generateNav();?>
    </nav>
    <div class="content grid-item">
        <!-- content tabel hier -->
        <? 
        $model = new overzichtModel;
        $model->ToonOverzicht();
        ?>
    </div>
</div>