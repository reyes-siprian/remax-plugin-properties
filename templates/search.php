<section class="rp-search">
    <form action="<?= $properties_url ?>" method="get" class="rp-search__form">
        <section class="rp-search__property-status">
            <input type="radio" name="property-status" class="rp-search__radio" id="property-status-all" value="all" checked>
            <label for="property-status-all" class="property-status_label">Todas las Propiedades</label>
            <input type="radio" name="property-status" class="rp-search__radio" id="property-status-rent" value="sell">
            <label for="property-status-rent" class="property-status_label">Para Ventas</label>
            <input type="radio" name="property-status" class="rp-search__radio" id="property-status-sell" value="rent">
            <label for="property-status-sell" class="property-status_label">Para Alquiler</label>
        </section>

        <section class="rp-search__filters">

            <div class="rp-search__filter">
                <span class="rp-search__label__title">Codigo del inmueble</span>
                <input type="number" name="property-id" id="">
            </div>

            <div class="rp-search__filter">
                <span class="rp-search__label__title">Provincia</span>
                <select class="rp-search__city" name="province">
                    <option value="" selected>Todas</option>
                    <?php foreach($provinces as $province): ?>
                        <option value="<?= $province->id ?>"><?= $province->description ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="rp-search__filter">
                <span class="rp-search__label__title">Precio Min.</span>
                <input type="number" name="min-price" id="">
            </div>

            <div class="rp-search__filter">
                <span class="rp-search__label__title">Precio Max.</span>
                <input type="number" name="max-price" id="">
            </div>

            <div class="rp-search__filter-footer">
                <input type="checkbox" name="exclusive" id="rp_exclusive" value="1">
                <label for="rp_exclusive" class="rp-search__exclusive" >Propiedades Exclusivas</label>
    
                <input type="submit" class="rp-search__submit" value="Buscar">
            </div>
        </section>

    </form>
</section>


